<?php

namespace Seracademico\Http\Controllers;

use Illuminate\Http\Request;

use Seracademico\Http\Requests;
use Seracademico\Http\Controllers\Controller;

class DefaultController extends Controller
{
    public function index()
    {

        $data  = new \DateTime('now');

        # Buscanco apenas as demandas encaminhadas e reencaminhadas
        $novas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })->select([
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
            })->select([
                \DB::raw('COUNT(ouv_demanda.id) as analises'),
            ])->first();

        # Buscanco apenas as demandas concluídas
        $concluidas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (4) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })->select([
                \DB::raw('COUNT(ouv_demanda.id) as concluidas'),
            ])->first();

        # Buscanco apenas as demandas atrasadas
        $atrasadas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2) ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })->where('ouv_encaminhamento.previsao', '<', $data->format('Y-m-d'))
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as atrasadas'),
            ])->first();

       // dd($atrasada);

        return view('default.index', compact('novas', 'analises', 'concluidas', 'atrasadas'));
    }
    
    
}
