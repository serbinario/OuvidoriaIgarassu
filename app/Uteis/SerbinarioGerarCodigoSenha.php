<?php

namespace Seracademico\Uteis;


class SerbinarioGerarCodigoSenha
{
    /**
     * @param int $tamanho
     * @param bool $maiusculas
     * @param bool $numeros
     * @param bool $simbolos
     * @return string
     */
    public static function gerar($tamanho = 8, $maiusculas = true, $numeros = true)
    {
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        //$simb = '!@#$%*-';

        $retorno = '';
        $caracteres = '';
        //$caracteres .= $lmin;

        if ($maiusculas) $caracteres    .= $lmai;
        if ($numeros) $caracteres       .= $num;
        //if ($simbolos) $caracteres      .= $simb;

        $len = strlen($caracteres);

        for ($n = 1; $n <= $tamanho; $n++) {
            $rand = mt_rand(1, $len);
            $retorno .= $caracteres[$rand-1];
        }

        return $retorno;
    }
    
    public static function gerarProtocolo()
    {
        $data  = new \DateTime('now');
        $data->setTimezone( new \DateTimeZone('BRT') );
        $ano = $data->format('Y');

        // Gerando o código da demanda
        $protocolo = SerbinarioGerarCodigoSenha::gerar(8,true,true,true);
        $protocolo = $protocolo.$ano;
        
        $aux = false;
        while ($aux == false) {
            
            $validarRepeticaoProtocolo = \DB::table('ouv_demanda')
                ->where('n_protocolo', '=', $protocolo)->select('id')->first();

            if($validarRepeticaoProtocolo) {
                $protocolo = SerbinarioGerarCodigoSenha::gerar(8,true,true,true);
                $protocolo = $protocolo.$ano;
            } else {
                $aux = true;
            }
            
        }
        
        return $protocolo;
    }
}