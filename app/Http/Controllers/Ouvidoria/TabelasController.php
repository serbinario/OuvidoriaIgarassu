<?php

namespace Seracademico\Http\Controllers\Ouvidoria;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Seracademico\Http\Requests;
use Yajra\Datatables\Datatables;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;
use Khill\Lavacharts\Lavacharts;
use Seracademico\Uteis\SerbinarioDateFormat;
use Seracademico\Services\Ouvidoria\DemandaService;

class TabelasController extends Controller
{

    /**
     * @var DemandaService
     */
    private $service;

    /**
     * @var array
     */
    private $loadFields = [
        'Ouvidoria\Secretaria',
        'Cidade|byEstado,16'
    ];

    /**
     * @param DemandaService $service
     */
    public function __construct(DemandaService $service)
    {
        $this->service   =  $service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAssuntoClassificacao()
    {
        $loadFields = $this->service->load($this->loadFields);
        
        #Retorno para view
        return view('ouvidoria.tabelas.assuntoClassificacao',  compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function assuntoClassificacao(Request $request)
    {

        $query = $this->assuntoClassificacaoQuery($request);

        #Retorno para view
        return view('ouvidoria.tabelas.assuntoClassificacao', $query, ['request' => $request]);
    }

    /**
     * @return mixed
     */
    public function assuntoClassificacaoQuery($dados)
    {

        $loadFields = $this->service->load($this->loadFields);

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'ouv_assunto.area_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->groupBy('ouv_assunto.id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'ouv_assunto.nome as assunto',
                'ouv_assunto.id as assunto_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        $rows = $rows->get();
        
        $array = [];
        $arrayAssunto = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->assunto, $arrayAssunto)) {
                continue;
            }
            $array[$count]['assunto'] = $row->assunto;
            $arrayAssunto[$count]  = $row->assunto;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->assunto_id == $row->assunto_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }

        return compact('array', 'totalDemandas', 'loadFields');
    }


    /**
     * @return string
     */
    public function assuntoView()
    {
        //$assuntos = \DB::table('ouv_assunto')->get();
        $loadFields = $this->service->load($this->loadFields);
        
        return view('ouvidoria.tabelas.assuntos', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function assuntos(Request $request)
    {
        $loadFields = $this->service->load($this->loadFields);
        
        $dados = $request->request->all();
        $assuntoId = $dados['assunto'];

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";

        $assuntos = \DB::table('ouv_assunto')->get();
        
        $assuntosFirst = \DB::table('ouv_assunto')
            ->where('ouv_assunto.id', '=', $assuntoId)->select(['nome'])->first();

        $subassuntos = \DB::table('ouv_subassunto')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->where('ouv_assunto.id', '=', $assuntoId)->select(['ouv_subassunto.nome', 'ouv_subassunto.id'])->get();

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->where('ouv_assunto.id', '=', $assuntoId)
            ->groupBy('ouv_demanda.subassunto_id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'ouv_subassunto.nome as subassunto',
                'ouv_subassunto.id as subassunto_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $array = [];
        $arraySubassunto = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->subassunto, $arraySubassunto)) {
                continue;
            }
            $array[$count]['subassunto'] = $row->subassunto;
            $arraySubassunto[$count]  = $row->subassunto;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->subassunto_id == $row->subassunto_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }
        
        return view('ouvidoria.tabelas.assuntos', 
            compact('assuntos', 'assuntosFirst','subassuntos', 'array', 'totalDemandas', 'loadFields'), ['request' => $request]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSexo()
    {

        $query = $this->sexoQuery(array());
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.tabelas.sexo', $query, compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sexo(Request $request)
    {
        $query = $this->sexoQuery($request);

        #Retorno para view
        return view('ouvidoria.tabelas.sexo', $query, ['request' => $request]);
    }

    /**
     * @return mixed
     */
    public function sexoQuery($dados)
    {
        $loadFields = $this->service->load($this->loadFields);

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('gen_sexo', 'gen_sexo.id', '=', 'ouv_demanda.sexos_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->groupBy('gen_sexo.id')
            ->select([
                'gen_sexo.nome as sexo',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);
            
        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        $rows = $rows->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }

        return compact('rows', 'totalDemandas', 'loadFields');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEscolaridade()
    {

        $query = $this->escolaridadeQuery(array());
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.tabelas.escolaridade',$query, compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function escolaridade(Request $request)
    {
        $query = $this->escolaridadeQuery($request);

        #Retorno para view
        return view('ouvidoria.tabelas.escolaridade',$query, ['request' => $request]);
    }

    /**
     * @return mixed
     */
    public function escolaridadeQuery($dados)
    {

        $loadFields = $this->service->load($this->loadFields);

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('gen_escolaridade', 'gen_escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->groupBy('gen_escolaridade.id')
            ->select([
                'gen_escolaridade.id as escolaridade',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        $rows = $rows->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }
        
        $escolaridades = \DB::table('gen_escolaridade')->get();

        return compact('rows', 'totalDemandas', 'escolaridades', 'loadFields');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewComunidadeClassificacao()
    {
        //$query = $this->comunidadeClassificacaoQuery(array());
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.tabelas.comunidadeClassificacao', compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comunidadeClassificacao(Request $request)
    {
        $query = $this->comunidadeClassificacaoQuery($request);

        #Retorno para view
        return view('ouvidoria.tabelas.comunidadeClassificacao', $query, ['request' => $request]);
    }

    /**
     * @return mixed
     */
    public function comunidadeClassificacaoQuery($dados)
    {

        $loadFields = $this->service->load($this->loadFields);

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        $cidade     = isset($dados['cidade']) ? $dados['cidade'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('gen_bairros', 'gen_bairros.id', '=', 'ouv_demanda.bairro_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->groupBy('gen_bairros.id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'gen_bairros.nome as bairro',
                'gen_bairros.id as bairro_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        if($cidade) {
            $rows->where('gen_bairros.cidades_id', $cidade);
        }

        $rows = $rows->get();

        $array = [];
        $arrayComunidade = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->bairro, $arrayComunidade)) {
                continue;
            }
            $array[$count]['bairro'] = $row->bairro;
            $arrayComunidade[$count]  = $row->bairro;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->bairro_id == $row->bairro_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }

        return compact('array', 'totalDemandas', 'loadFields');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMelhorias()
    {
        
        $loadFields = $this->service->load($this->loadFields);

        #Retorno para view
        return view('ouvidoria.tabelas.melhorias', compact('loadFields'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function melhorias(Request $request)
    {
        $query = $this->melhoriasQuery($request);

        #Retorno para view
        return view('ouvidoria.tabelas.melhorias', $query, ['request' => $request]);
    }

    /**
     * @return mixed
     */
    public function melhoriasQuery($dados)
    {
        $loadFields = $this->service->load($this->loadFields);

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_melhorias', 'ouv_melhorias.id', '=', 'ouv_demanda.melhoria_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->groupBy('ouv_melhorias.id')
            ->select([
                'ouv_melhorias.id as melhoria',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        $rows = $rows->get();

        $totalMelhorias = 0;

        foreach ($rows as $row) {
            $totalMelhorias += $row->qtd;
        }

        $melhorias = \DB::table('ouv_melhorias')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'ouv_melhorias.area_id')
            ->where('gen_secretaria.id', '=', $secretaria)
            ->select('ouv_melhorias.nome', 'ouv_melhorias.id')
            ->get();

        return compact('rows', 'totalMelhorias', 'melhorias', 'loadFields');
    }
}
