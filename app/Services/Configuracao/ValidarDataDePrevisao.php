<?php

namespace Seracademico\Services\Configuracao;

/**
 * Created by PhpStorm.
 * User: Fabio Aguiar
 * Date: 20/03/2017
 * Time: 07:58
 */
class ValidarDataDePrevisao
{


    /**
     * @param $dados
     * @param $data
     * @return bool
     */
    public static function getResult($dataObj, $dias)
    {

        // Determinando a data de devolução do empréstimo
        $dataObj->add(new \DateInterval("P{$dias}D"));
        $data       = $dataObj->format('d/m/Y'); // Data para gerar o dia da semana
        $dataReal   = $dataObj->format('Y-m-d'); // Data real no formato americano para inserir no banco

        $index = false;

        # Loop para validar se a data gerada não é de um final de semana
        while ($index == false) {

            // Pegando o dia da semana
            $diaDaSemana = ValidarDataDePrevisao::getDiaDaSemana($data);

            // Validando se a data cai em um dia não letivo
            if($diaDaSemana == "Domingo" || $diaDaSemana == "Sábado") {

                $dia = $dias + 1;
                #Gerando uma nova data para devolução
                $novaDataObj   = new \DateTime('now');
                $novaDataObj->add(new \DateInterval("P{$dia}D"));
                $data       = $novaDataObj->format('d/m/Y');
                $dataReal   = $novaDataObj->format('Y-m-d');

            } else {
                $index = true;
            }

        }

        return $dataReal;
    }

    /**
     * @param $data
     * @return string
     */
    public static function getDiaDaSemana($data)
    {
        $dia_semana = "";

        $dia = substr($data,0,2);

        $mes = substr($data,3,2);

        $ano = substr($data,6,4);

        // Recupera índice do dia da semana
        $diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

        // Retorna o dia da semana por extenso
        switch($diasemana) {

            case"0": $dia_semana = "Domingo"; break;

            case"1": $dia_semana = "Segunda"; break;

            case"2": $dia_semana = "Terça"; break;

            case"3": $dia_semana = "Quarta"; break;

            case"4": $dia_semana = "Quinta"; break;

            case"5": $dia_semana = "Sexta"; break;

            case"6": $dia_semana = "Sábado"; break;

        }

        return $dia_semana;
    }
}