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

class TabelasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAssuntoClassificacao()
    {
        
        $query = $this->assuntoClassificacaoQuery(array());
        
        #Retorno para view
        return view('ouvidoria.tabelas.assuntoClassificacao', $query);
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
        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
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

        return compact('array', 'totalDemandas');
    }


    /**
     * @return string
     */
    public function assuntoView()
    {
        $assuntos = \DB::table('ouv_assunto')->get();
        
        return view('ouvidoria.tabelas.assuntos', ['assuntos' => $assuntos]);
    }

    /**
     * @return string
     */
    public function assuntos(Request $request)
    {
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

        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->where('ouv_assunto.id', '=', $assuntoId)
            ->groupBy('ouv_demanda.subassunto_id')
            ->select([
                'ouv_subassunto.id as subassunto',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();
        
        return view('ouvidoria.tabelas.assuntos', compact('assuntos', 'assuntosFirst','subassuntos', 'rows'), ['request' => $request]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSexo()
    {

        $query = $this->sexoQuery(array());

        #Retorno para view
        return view('ouvidoria.tabelas.sexo', $query);
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
        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('sexos', 'sexos.id', '=', 'ouv_demanda.sexos_id')
            ->groupBy('sexos.id')
            ->select([
                'sexos.nome as sexo',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);
            
        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }

        return compact('rows', 'totalDemandas');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewEscolaridade()
    {

        $query = $this->escolaridadeQuery(array());

        #Retorno para view
        return view('ouvidoria.tabelas.escolaridade',$query);
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
        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('escolaridade', 'escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->groupBy('escolaridade.id')
            ->select([
                'escolaridade.id as escolaridade',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $totalDemandas = 0;

        foreach ($rows as $row) {
            $totalDemandas += $row->qtd;
        }
        
        $escolaridades = \DB::table('escolaridade')->get();

        return compact('rows', 'totalDemandas', 'escolaridades');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewComunidadeClassificacao()
    {
        $query = $this->comunidadeClassificacaoQuery(array());

        #Retorno para view
        return view('ouvidoria.tabelas.comunidadeClassificacao', $query);
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

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_comunidade', 'ouv_comunidade.id', '=', 'ouv_demanda.comunidade_id')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->groupBy('ouv_comunidade.id', 'ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as info',
                'ouv_comunidade.nome as comunidade',
                'ouv_comunidade.id as comunidade_id',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $array = [];
        $arrayComunidade = [];
        $count = 0;
        $totalDemandas = 0;

        foreach ($rows as $row) {
            if(in_array($row->comunidade, $arrayComunidade)) {
                continue;
            }
            $array[$count]['comunidade'] = $row->comunidade;
            $arrayComunidade[$count]  = $row->comunidade;
            $totalGeral = 0;
            foreach ($rows as $row2) {
                if($row2->comunidade_id == $row->comunidade_id) {
                    $array[$count][$row2->info] = $row2->qtd;
                    $totalGeral += $row2->qtd;
                }
            }
            $array[$count]['totalGeral'] = $totalGeral;
            $totalDemandas += $totalGeral;
            $count++;
        }

        return compact('array', 'totalDemandas');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewMelhorias()
    {

        $query = $this->melhoriasQuery(array());

        #Retorno para view
        return view('ouvidoria.tabelas.melhorias', $query);
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
        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_melhorias', 'ouv_melhorias.id', '=', 'ouv_demanda.melhoria_id')
            ->groupBy('ouv_melhorias.id')
            ->select([
                'ouv_melhorias.id as melhoria',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $totalMelhorias = 0;

        foreach ($rows as $row) {
            $totalMelhorias += $row->qtd;
        }

        $melhorias = \DB::table('ouv_melhorias')->get();

        return compact('rows', 'totalMelhorias', 'melhorias');
    }
}
