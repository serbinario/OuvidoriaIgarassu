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
            })
            ->leftJoin('ouv_destinatario', 'ouv_destinatario.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->leftJoin('ouv_area', 'ouv_area.id', '=', 'ouv_destinatario.area_id')
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
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as atrasadas'),
            ]);


        if($user->is('secretaria')) {
            $atrasadas->where('ouv_area.id', '=', $user->secretaria->id);
        }

        $atrasadas = $atrasadas->first();

        return view('default.index', compact('novas', 'analises', 'concluidas', 'atrasadas'));
    }
    
    
}
