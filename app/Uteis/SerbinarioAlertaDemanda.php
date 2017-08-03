<?php

namespace Seracademico\Uteis;

use Illuminate\Support\Facades\Auth;

class SerbinarioAlertaDemanda
{
    
    /**
     * @param $dados
     * @throws \Exception
     */
    public static function alertaDeDemanda()
    {
        $alertas = array();
        
        $alertas['novas']           = SerbinarioAlertaDemanda::novas();
        $alertas['encaminhadas']    = SerbinarioAlertaDemanda::encaminhadas();
        $alertas['emAnalise']       = SerbinarioAlertaDemanda::emAnalise();
        $alertas['concluidas']      = SerbinarioAlertaDemanda::concluidas();
        $alertas['aAtrasar']        = SerbinarioAlertaDemanda::aAtrasar();
        $alertas['atrasadas']       = SerbinarioAlertaDemanda::atrasadas();
        
        return $alertas;
    }

    /**
     * @return bool
     */
    public static function novas()
    {
        $demandas = \DB::table('ouv_demanda')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_demanda.status_id')
            ->where('ouv_status.id', '=','5')
            ->select([
                \DB::raw('COUNT(ouv_demanda.id) as qtd'),
            ])->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }

    /**
     * @return bool
     */
    public static function encaminhadas()
    {
        $user =  Auth::user();

        $demandas = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->whereIn('ouv_status.id', [1,7])
            ->select([
                \DB::raw('COUNT(ouv_encaminhamento.id) as qtd'),
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$user->is('admin|ouvidoria') && $user->is('secretaria')) {
            $demandas->where('gen_secretaria.id', '=',$user->secretaria->id);
        }

        $demandas = $demandas->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }

    /**
     * @return bool
     */
    public static function emAnalise()
    {
        $user =  Auth::user();

        $demandas = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->whereIn('ouv_status.id', [2])
            ->select([
                \DB::raw('COUNT(ouv_encaminhamento.id) as qtd'),
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$user->is('admin|ouvidoria') && $user->is('secretaria')) {
            $demandas->where('gen_secretaria.id', '=', $user->secretaria->id);
        }

        $demandas = $demandas->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }

    /**
     * @return bool
     */
    public static function concluidas()
    {
        $user =  Auth::user();

        $demandas = \DB::table('ouv_encaminhamento')
            ->join('ouv_demanda', 'ouv_demanda.id', '=', 'ouv_encaminhamento.demanda_id')
            ->join('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->whereIn('ouv_status.id', [4])
            ->select([
                \DB::raw('COUNT(ouv_encaminhamento.id) as qtd'),
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$user->is('admin|ouvidoria') && $user->is('secretaria')) {
            $demandas->where('gen_secretaria.id', '=', $user->secretaria->id);
        }

        $demandas = $demandas->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }

    /**
     * @return bool
     */
    public static function aAtrasar()
    {
        $user =  Auth::user();

        $demandas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2)  ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->whereIn('ouv_encaminhamento.status_id', [1,7,2])
            ->where(\DB::raw('DATEDIFF(ouv_encaminhamento.previsao, CURDATE())'), '<=', '15')
            ->select([
                \DB::raw('COUNT(ouv_encaminhamento.id) as qtd'),
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$user->is('admin|ouvidoria') && $user->is('secretaria')) {
            $demandas->where('gen_secretaria.id', '=', $user->secretaria->id);
        }

        $demandas = $demandas->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }

    /**
     * @return bool
     */
    public static function atrasadas()
    {
        $data  = new \DateTime('now');
        $user =  Auth::user();

        $demandas = \DB::table('ouv_demanda')
            ->join(\DB::raw('ouv_encaminhamento'), function ($join) {
                $join->on(
                    'ouv_encaminhamento.id', '=',
                    \DB::raw("(SELECT encaminhamento.id FROM ouv_encaminhamento as encaminhamento 
                    where encaminhamento.demanda_id = ouv_demanda.id AND encaminhamento.status_id IN (1,7,2)  ORDER BY ouv_encaminhamento.id DESC LIMIT 1)")
                );
            })
            ->join('ouv_status', 'ouv_status.id', '=', 'ouv_encaminhamento.status_id')
            ->join('gen_departamento', 'gen_departamento.id', '=', 'ouv_encaminhamento.destinatario_id')
            ->join('gen_secretaria', 'gen_secretaria.id', '=', 'gen_departamento.area_id')
            ->whereIn('ouv_encaminhamento.status_id', [1,7,2])
            ->where('ouv_encaminhamento.previsao', '<', $data->format('Y-m-d'))
            ->select([
                \DB::raw('COUNT(ouv_encaminhamento.id) as qtd'),
            ]);

        // Validando se o usuário autenticado é de secretaria e adaptando o select para a secretaria do usuário logado
        if(!$user->is('admin|ouvidoria') && $user->is('secretaria')) {
            $demandas->where('gen_secretaria.id', '=', $user->secretaria->id);
        }

        $demandas = $demandas->first();

        if($demandas) {
            $retorno = $demandas->qtd;
        } else {
            $retorno = false;
        }
        
        return $retorno;
    }
}