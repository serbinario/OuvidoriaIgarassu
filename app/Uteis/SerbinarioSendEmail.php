<?php

namespace Seracademico\Uteis;

use Mail;
use Carbon\Carbon;

class SerbinarioSendEmail
{
    /**
     * @param $dados
     * @throws \Exception
     */
    public static function sendEmailMultiplo($detalhe)
    {
        $usuarios = \DB::table('users')
            ->join('ouv_area', 'ouv_area.id', '=', 'users.area_id')
            ->where('ouv_area.id', '=', $detalhe->area_id)
            ->select(['email', 'name'])->get();


            Mail::send('emails.exemplo', ['detalhe' => $detalhe], function ($m) use ($usuarios) {
                $m->from('uchiteste@gmail.com', 'Demanda');

                foreach ($usuarios as $usuario) {
                    $m->to($usuario->email, $usuario->name);
                }

                $m->subject('E-mail de teste!');
            });
    }
    
}