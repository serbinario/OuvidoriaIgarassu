<?php
// leitura das datas automaticamente

function data($dia, $mes, $ano, $semana) {

    /*$dia = date('d');
    $mes = date('m');
    $ano = date('Y');
    $semana = date('w');*/
//$cidade = "Digite aqui sua cidade";

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

    echo ("$dia de $mes de $ano");
}
//Agora basta imprimir na tela...
//echo ("$cidade, $semana, $dia de $mes de $ano");
?>

<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">
        body {
            font-family: arial;
        }

        span, p {
            text-align: justify;
        }
        span {
            text-align: justify
        }

        table {
            width: 100%;
            border: 1px solid #444;
        }

    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">


    <h5 style="font-size: 15px">Comunicação interna N.º: {{$codigo}}</h5>

    @if($secretariaId == '3')
        <span><b>Gabinte do Prefeitro</b></span><br />
        <span><b>V.Ex.ª {{$secretario}}</b></span><br />
    @else
        @if($responsavel)
            <span><b>À {{$departamento}}</b></span><br />
            <span><b>{{$responsavel}}</b></span>
        @else
            <span><b>Ao secretário(a)</b></span><br />
            <span><b>Dr(a). {{$secretario}}</b></span>
        @endif
    @endif

    @if($dataManifestacao)
        <?php $data = \DateTime::createFromFormat('Y-m-d H:i:s', $dataManifestacao); ?>
        <div style="text-align: right">Igarassu, <?php data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?>.</div><br />
    @endif
    <span>Assunto: Manifestação recebida pela Ouvidoria Municipal de saúde de Igarassu.</span><br /><br />

    <span><b>Prezado(a) Senhor(a),</b></span><br />
    <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cumprimentando cordialmente, encaminhamos a V.S.a a manifestação
            recebida por essa Ouvidoria para análise e providências cabíveis.</b> Solicitamos encaminhar a Ouvidoria,
        dentro do prazo estabelecido, o retorno através de comunicação Interna para que esta seja informada ao cidadão.
    </p><br /><br />


    <table class="table table-border" >
        <tr>
            <td ><span class="text"><b>Protocolo Nº. {{$protocolo}} </b></span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Tipo de manifestação: </b>{{ $tipoManifestacao }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Assunto: </b>{{ $assunto  }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Origem: </b>{{ $origem }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Usuário: </b>{{ $tipoUsuario }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Nome: </b>{{ ($sigiloId == 2) ? 'Confidencial' : $nome }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Celular: </b>{{ $fone  }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Classificação: </b>{{ $prioridade  }}</span></td>
        </tr>
        <tr>
            <td ><span class="text"><b>Prazo de Resposta: </b>{{ $prazo  }} dias úteis</span></td>
        </tr>
    </table><br /><br />

    <table >
        <tr>
            <td><span><b>Descrição da Manifestação do autor</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><p>{{ $relato }}</p></td>
        </tr>
    </table> <br /><br />

    <table >
        <tr>
            <td><span><b>Interpretação da Manifestação pela ouvidoria</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><p>{{ $parecer }}</p></td>
        </tr>
    </table>

</div>

{{--<center>
    <div class="rodape">
        <center>
            <center><img src="{{asset('/img/ouvidoria_saude.png')}}" style="width: 130px; height: 95px"></center><br />
            <span style="font-size: 10px">Ouvidoria da Saúde de Igarassu</span><br />
            --}}{{--<span style="font-size: 10px">PREFEITURA MUNICIPAL DE ABREU E LIMA</span><br />
            <span style="font-size: 10px">Avenida Duque de Caxias nº 924 - Centro - Abreu E Lima PE</span><br />
            <span style="font-size: 10px">CEP: 53.580-020 - CNPJ: 08.637.3730001-80 - FONE: (81) 3542.1061</span>--}}{{--
        </center>
    </div>
</center>--}}

</body>
</html>