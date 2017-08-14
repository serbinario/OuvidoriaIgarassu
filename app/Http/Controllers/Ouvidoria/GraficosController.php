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
use Illuminate\Support\Facades\Auth;

class GraficosController extends Controller
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
    ];

    /**
     * @var
     */
    private $user;

    /**
     * @param DemandaService $service
     */
    public function __construct(DemandaService $service)
    {
        $this->service   =  $service;
        $this->user      = Auth::user();
    }

    /**
     * @return mixed
     */
    public function caracteristicas()
    {
        return view('ouvidoria.graficos.chartCaracteristicas', compact('loadFields'));
    }

    /**
     * @return mixed
     */
    public function caracteristicasView()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartCaracteristicasView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function caracteristicasAjax(Request $request)
    {
        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
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
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_demanda.informacao_id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }


    /**
     * @return mixed
     */
    public function assunto()
    {
        return view('ouvidoria.graficos.chartAssunto');
    }

    /**
     * @return mixed
     */
    public function assuntoView()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartAssuntoView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function assuntoAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_subassunto.assunto_id')
            ->select([
                'ouv_assunto.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function subassuntoView()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartSubassuntoView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function subassuntoAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $assunto = isset($dados['assunto']) ? $dados['assunto'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->groupBy('ouv_demanda.subassunto_id')
            ->select([
                'ouv_subassunto.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($assunto) {
            $rows->where('ouv_assunto.id', '=', $assunto);
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function meioRegistroView()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartMeioRegistroView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function meioRegistroAjax(Request $request)
    {
        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_demanda.tipo_demanda_id')
            ->select([
                'ouv_tipo_demanda.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();
        
        $nomes = [];
        $data = [];
        
        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function perfilView()
    {

        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartPerfilView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function perfilAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_demanda.pessoa_id')
            ->select([
                'ouv_pessoa.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function escolaridadeView()
    {

        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartEscolaridadeView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function escolaridadeAjax(Request $request)
    {

        $dados = $request->request->all();

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
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_demanda.escolaridade_id')
            ->select([
                'gen_escolaridade.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];
        
        foreach ($rows as $row) {
            $nomes[] = $row->nome;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function idade()
    {
        return view('ouvidoria.graficos.chartIdade');
    }

    public function idadeAjax()
    {

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_idade', 'ouv_idade.id', '=', 'ouv_demanda.idade_id')
            ->groupBy('ouv_demanda.idade_id')
            ->whereBetween('ouv_idade.id', array(1, 204))
            ->select([
                'ouv_idade.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])->get();

        $dados = [];
        $dados[0] = ['Element', 'Density', ['role' => 'style']];

        $contar = 1;
        foreach ($rows as $row) {
            $r = ["1-20", $row->qtd, 'silver'];
            $dados[$contar] = $r;
            $contar++;
        }

        return response()->json($dados);
    }

    /**
     * @return mixed
     */
    public function atendimento()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.meioAtendimentoView', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function atendimentoAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', "=", "ouv_demanda.tipo_demanda_id")
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_tipo_demanda.id')
            ->select([
                'ouv_tipo_demanda.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $dados = [];

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd];
            $dados[] = $r;
        }

        return response()->json($dados);
    }

    /**
     * @return mixed
     */
    public function informacao()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.informacaoView', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function informacaoAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_informacao', 'ouv_informacao.id', "=", "ouv_demanda.informacao_id")
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        } else if ($this->user->is('secretaria')) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$this->user->secretaria->id}"));
        }

        $rows = $rows->get();


        $dados = [];
        $qtdTotal = 0;

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd, 'qtd' => $row->qtd];
            $dados[] = $r;
            $qtdTotal = $qtdTotal + $row->qtd;
        }

        return response()->json(['dados' => $dados, 'qtdTotal' => $qtdTotal]);
    }


    /**
     * @return mixed
     */
    public function status()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.statusView', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_status', 'ouv_status.id', "=", "ouv_demanda.status_id")
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_status.id')
            ->select([
                'ouv_status.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        } else  if($this->user->is('secretaria')) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$this->user->secretaria->id}"));
        }

        $rows = $rows->get();

        $dados = [];

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd, 'qtd' => $row->qtd];
            $dados[] = $r;
        }

        return response()->json($dados);
    }

    /**
     * @return mixed
     */
    public function melhoria()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.melhoriaView', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function melhoriaAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_informacao', 'ouv_informacao.id', "=", "ouv_demanda.informacao_id")
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->whereIn('ouv_demanda.informacao_id', [2,4])
            ->groupBy('ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $dados = [];

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd];
            $dados[] = $r;
        }

        return response()->json($dados);
    }


    /**
     * @return mixed
     */
    public function melhorias()
    {
        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.melhoriasView', compact('loadFields'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function melhoriasAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_melhorias', 'ouv_melhorias.id', "=", "ouv_demanda.melhoria_id")
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->leftJoin('gen_secretaria as secretaria_dm', 'secretaria_dm.id', '=', 'ouv_encaminhamento.secretaria_id')
            ->groupBy('ouv_melhorias.id')
            ->select([
                'ouv_melhorias.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->whereRaw(\DB::raw("IF(gen_secretaria.id != '', gen_secretaria.id, secretaria_dm.id) = {$secretaria}"));
        }

        $rows = $rows->get();

        $dados = [];

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd];
            $dados[] = $r;
        }

        return response()->json($dados);
    }

    /**
     * @return mixed
     */
    public function demandasView()
    {

        $loadFields = $this->service->load($this->loadFields);

        return view('ouvidoria.graficos.chartDemandasView', compact('loadFields'));
    }

    /**
     * @return string
     */
    public function demandasAjax(Request $request)
    {

        $dados = $request->request->all();

        //Tratando as datas
        $dataIni = isset($dados['data_inicio']) ? SerbinarioDateFormat::toUsa($dados['data_inicio'], 'date') : "";
        $dataFim = isset($dados['data_fim']) ? SerbinarioDateFormat::toUsa($dados['data_fim'], 'date') : "";
        $secretaria = isset($dados['secretaria']) ? $dados['secretaria'] : '';

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->leftJoin(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento
                    where encaminhamento.demanda_id = ouv_demanda.id ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->select([
                \DB::raw('month(ouv_demanda.data) as mes'),
                \DB::raw('year(ouv_demanda.data) as ano'),
                \DB::raw('CONCAT(DATE_FORMAT(ouv_demanda.data,"%m"), "/", DATE_FORMAT(ouv_demanda.data,"%Y")) as legenda'),
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ])
            ->groupBy('mes', 'ano');

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        if($secretaria) {
            $rows->where('gen_secretaria.id', '=', $secretaria);
        }

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->legenda;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }
}
