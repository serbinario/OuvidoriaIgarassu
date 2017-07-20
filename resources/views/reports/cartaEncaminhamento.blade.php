<?php


// leitura das datas automaticamente

function data($dia, $mes, $ano, $semana) {

// configuração mes

        switch ($mes){

                case 1: $mes = "Janeiro"; break;
                case 2: $mes = "Fevereiro"; break;
                case 3: $mes = "Março"; break;
                case 4: $mes = "Abril"; break;
                case 5: $mes = "Maio"; break;
                case 6: $mes = "Junho"; break;
                case 7: $mes = "Julho"; break;
                case 8: $mes = "Agosto"; break;
                case 9: $mes = "Setembro"; break;
                case 10: $mes = "Outubro"; break;
                case 11: $mes = "Novembro"; break;
                case 12: $mes = "Dezembro"; break;

        }


// configuração semana

        switch ($semana) {

                case 0: $semana = "Domingo"; break;
                case 1: $semana = "Segunda Feira"; break;
                case 2: $semana = "Terça Feira"; break;
                case 3: $semana = "Quarta Feira"; break;
                case 4: $semana = "Quinta Feira"; break;
                case 5: $semana = "Sexta Feira"; break;
                case 6: $semana = "Sábado"; break;

        }

        return "$dia de $mes de $ano";
}


$palavras = array(
        '$titulo$',
        '$codigo$',
        '$secretaria$',
        '$secretario$',
        '$data$',
        '$protocolo$',
        '$tipoManifestacao$',
        '$assunto$',
        '$origem$',
        '$tipoUsuario$',
        '$nome$',
        '$fone$',
        '$prioridade$',
        '$prazo$',
        '$relato$',
        '$parecer$'
);


if ($secretariaId == '3') {
        $secretaria = "Gabinte do Prefeitro";
        $secretario = "V.Ex.ª " . $secretario;
} else {
        $secretaria = "Ao secretário(a)";
        $secretario = "Dr(a) " . $secretario;
}


if ($dataManifestacao) {
        $data = \DateTime::createFromFormat('Y-m-d', $dataManifestacao);
        $dataFormatada = data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w'));
}


$nome = $sigiloId == 2 ? 'Confidencial' : $nome;

$variavies = array(
        $titulo,
        $codigo,
        $secretaria,
        $secretario,
        $dataFormatada,
        $protocolo,
        $tipoManifestacao,
        $assunto,
        $origem,
        $tipoUsuario,
        $nome,
        $fone,
        $prioridade,
        $prazo,
        $relato,
        $parecer
);

$texto = str_replace($palavras, $variavies, $template->html);

echo $texto;