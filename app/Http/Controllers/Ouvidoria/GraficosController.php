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

class GraficosController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('biblioteca.responsavel.index');
    }

    /**
     * @return mixed
     */
    public function caracteristicas()
    {
        //return \PDF::loadView('ouvidoria.graficos.chartCaracteristicas')->stream();
        return view('ouvidoria.graficos.chartCaracteristicas');
    }

    /**
     * @return mixed
     */
    public function caracteristicasView()
    {
        return view('ouvidoria.graficos.chartCaracteristicasView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_informacao', 'ouv_informacao.id', '=', 'ouv_demanda.informacao_id')
            ->groupBy('ouv_demanda.informacao_id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
        return view('ouvidoria.graficos.chartAssuntoView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->join('ouv_assunto', 'ouv_assunto.id', '=', 'ouv_subassunto.assunto_id')
            ->groupBy('ouv_subassunto.assunto_id')
            ->select([
                'ouv_assunto.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function demandasView()
    {
        return view('ouvidoria.graficos.chartDemandasView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
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

        $rows = $rows->get();

        $nomes = [];
        $data = [];

        foreach ($rows as $row) {
            $nomes[] = $row->legenda;
            $data[] = $row->qtd;
        }

        return response()->json([$nomes,$data]);
    }

    /**
     * @return mixed
     */
    public function subassunto()
    {
        return view('ouvidoria.graficos.chartSubassunto');
    }

    /**
     * @return mixed
     */
    public function subassuntoView()
    {
        return view('ouvidoria.graficos.chartSubassuntoView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_subassunto', 'ouv_subassunto.id', '=', 'ouv_demanda.subassunto_id')
            ->groupBy('ouv_demanda.subassunto_id')
            ->select([
                'ouv_subassunto.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function meioRegistro()
    {
        return view('ouvidoria.graficos.chartMeioRegistro');
    }

    /**
     * @return mixed
     */
    public function meioRegistroView()
    {
        return view('ouvidoria.graficos.chartMeioRegistroView');
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
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', '=', 'ouv_demanda.tipo_demanda_id')
            ->groupBy('ouv_demanda.tipo_demanda_id')
            ->select([
                'ouv_tipo_demanda.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function perfil()
    {
        return view('ouvidoria.graficos.chartPerfil');
    }

    /**
     * @return mixed
     */
    public function perfilView()
    {
        return view('ouvidoria.graficos.chartPerfilView');
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
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_pessoa', 'ouv_pessoa.id', '=', 'ouv_demanda.pessoa_id')
            ->groupBy('ouv_demanda.pessoa_id')
            ->select([
                'ouv_pessoa.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function escolaridade()
    {
        return view('ouvidoria.graficos.chartEscolaridade');
    }

    /**
     * @return mixed
     */
    public function escolaridadeView()
    {
        return view('ouvidoria.graficos.chartEscolaridadeView');
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
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('escolaridade', 'escolaridade.id', '=', 'ouv_demanda.escolaridade_id')
            ->groupBy('ouv_demanda.escolaridade_id')
            ->select([
                'escolaridade.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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

        //dd($rows);

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
        return view('ouvidoria.graficos.meioAtendimentoView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_tipo_demanda', 'ouv_tipo_demanda.id', "=", "ouv_demanda.tipo_demanda_id")
            ->groupBy('ouv_tipo_demanda.id')
            ->select([
                'ouv_tipo_demanda.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
        return view('ouvidoria.graficos.informacaoView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_informacao', 'ouv_informacao.id', "=", "ouv_demanda.informacao_id")
            ->groupBy('ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function status()
    {
        return view('ouvidoria.graficos.statusView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_situacao', 'ouv_situacao.id', "=", "ouv_demanda.situacao_id")
            ->groupBy('ouv_situacao.id')
            ->select([
                'ouv_situacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
    public function melhoria()
    {
        return view('ouvidoria.graficos.melhoriaView');
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

        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_informacao', 'ouv_informacao.id', "=", "ouv_demanda.informacao_id")
            ->where('ouv_demanda.informacao_id', '=', 2)
            ->orWhere('ouv_demanda.informacao_id', '=', 4)
            ->groupBy('ouv_informacao.id')
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
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
        return view('ouvidoria.graficos.melhoriasView');
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
        
        #Criando a consulta
        $rows = \DB::table('ouv_demanda')
            ->join('ouv_melhorias', 'ouv_melhorias.id', "=", "ouv_demanda.melhoria_id")
            ->groupBy('ouv_melhorias.id')
            ->select([
                'ouv_melhorias.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($dataIni && $dataFim) {
            $rows->whereBetween('ouv_demanda.data', array($dataIni, $dataFim));
        }

        $rows = $rows->get();

        $dados = [];

        foreach ($rows as $row) {
            $r = ['name' => $row->nome, 'y' => $row->qtd];
            $dados[] = $r;
        }

        return response()->json($dados);
    }

}
