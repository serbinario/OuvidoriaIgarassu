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


        Mail::send('emails.paginaDeNotificacao', ['detalhe' => $detalhe], function ($m) use ($usuarios) {
            $m->from('uchiteste@gmail.com', 'Ouvidoria - Notificação de demanda');

            foreach ($usuarios as $usuario) {
                $m->to($usuario->email, $usuario->name);
            }

            $m->subject('E-mail de teste!');
        });
    }

    /**
     * Método responsável por enviar um email genérico
     */
    public static function enviarEmailCom(string $view, array $dadosParaView, array $dadosDaMensagem)
    {
        if(!isset($dadosDaMensagem['destinatario'])
            || !isset($dadosDaMensagem['assunto'])) {

            throw new \Exception("O terceiro parâmetro requer um array com os seguintes
                chaves: destinatario e assunto.");
        }

        Mail::send($view, $dadosParaView, function ($m) use ($dadosDaMensagem) {
            $m->from('no-reply@serbinario.com.br');
            //$m->from('andreyfbs2013@gmail.com');
            $m->to($dadosDaMensagem['destinatario'])->subject($dadosDaMensagem['assunto']);
        });
    }
    
}