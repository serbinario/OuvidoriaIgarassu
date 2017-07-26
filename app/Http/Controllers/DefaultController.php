<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Seracademico\Uteis\SerbinarioDateFormat;

class DefaultController extends Controller
{
    public function index()
    {

        // Pegando o usuário autenticado
        $user  = Auth::user();

        // Pega data atual
        $data  = new \DateTime('now');

        // Pega o mês atual
        $mesAtual = $data->format('m');

        # Buscanco apenas as demandas encaminhadas e reencaminhadas
        $novas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as novas'),
            ])->first();


        # Buscanco apenas as demandas em análise
        $analises = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (2) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as analises'),
            ]);


        if($user->is('secretaria')) {
            $analises->where('ouv_area.id', '=', $user->secretaria->id);
        }

        $analises = $analises->first();

        # Buscanco apenas as demandas concluídas
        $concluidas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (4) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as concluidas'),
            ]);


        if($user->is('secretaria')) {
            $concluidas->where('ouv_area.id', '=', $user->secretaria->id);
        }

        $concluidas = $concluidas->first();

        # Buscanco apenas as demandas atrasadas
        $atrasadas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->where('ouv_encaminhamento.previsao', '<', $data->format('Y-m-d'))
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as atrasadas'),
            ]);


        if($user->is('secretaria')) {
            $atrasadas->where('ouv_area.id', '=', $user->secretaria->id);
        }

        $atrasadas = $atrasadas->first();

        return view('default.index', compact('novas', 'analises', 'concluidas', 'atrasadas'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function statusAjax(Request $request)
    {

        // Pegando o usuário autenticado
        $user  = Auth::user();

        // Pega data atual
        $data  = new \DateTime('now');

        // Pega o mês atual
        $mesAtual = $data->format('m');

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
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->groupBy('ouv_status.id')
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                'ouv_status.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);

        if($user->is('secretaria')) {
            $rows->where('ouv_area.id', '=', $this->user->secretaria->id);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function informacaoAjax(Request $request)
    {

        // Pegando o usuário autenticado
        $user  = Auth::user();

        // Pega data atual
        $data  = new \DateTime('now');

        // Pega o mês atual
        $mesAtual = $data->format('m');

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
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
            ->groupBy('ouv_informacao.id')
            ->whereRaw("MONTH(ouv_demanda.data) = {$mesAtual}")
            ->select([
                'ouv_informacao.nome as nome',
                \DB::raw('count(ouv_demanda.id) as qtd'),
            ]);


        if ($user->is('secretaria')) {
            $rows->where('ouv_area.id', '=', $this->user->secretaria->id);
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
}
