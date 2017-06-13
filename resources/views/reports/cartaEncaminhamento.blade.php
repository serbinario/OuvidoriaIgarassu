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
        .rodape{
            position:absolute;
            bottom:0;
            width: 100%;
            height: 90px;
            margin-top: 785px;
        }
        span, p {
            font-size: 14px;
            margin-left: 20px;
            text-align: justify;
        }
        span {
            text-align: justify
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">

    <center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/LOGO_OUVIDORIA_1.jpg')}}" style="width: 130px; height: 85px"></center>
        </div><br />
        <span style="font-size: 14px"><b>{{ $configuracaoGeral->nome }}</b></span><br />
        {{--<span style="font-size: 10px">Ouvidoria da Saúde</span>--}}
    </center>
    {{--<center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/ouvidoria-logo.png')}}" style="width: 320px; height: 100px"></center>
        </div>
    </center>--}}

    <h5 style="font-size: 15px">Comunicação interna N.º: {{$demanda->codigo}}</h5>

    <span><b>Ao secretário(a)</b></span></br>
    <span><b>Dr(a). {{$demanda->secretario}}</b></span></br>

    @if($demanda->data)
        <?php $data = \DateTime::createFromFormat('Y-m-d', $demanda->data); ?>
        <span style="position: absolute; top: 180px; left: 400px;">Abreu e Lima, <?php data($data->format('d'), $data->format('m'), $data->format('Y'), $data->format('w')); ?>.</span></br>
    @endif
    <span>Assunto: Manifestação recebida pela Ouvidoria Geral do Município de Abreu e Lima.</span></br></br>

    <span><b>Prezado(a) Senhor(a),</b></span></br>
    <p>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Cumprimentando Cordialmente, encaminhamos a V.S.a a manifestação recebida pela ouvidoria,</b> para fins de
        conhecimento e para que sejam tomadas as devidas providências cabíveis.
        Devido ao caráter interativo da Ouvidoria Municipal a qual permite ao usuário o acompanhamento do processo em
        epígrafe, solicito informar a ouvidoria dentro do prazo estabelecido o <b>retorno</b> através de <b>comunicação interna</b> as providências
        adotada e/ou possível solução do problema. Considerando a <b>resposta</b> primordial a ser informada ao cidadão.</p></br></br>


    <table border rules=none style="width: 100%;">
        <tr>
            <td style="width: 340px"><span class="text"><b>Protocolo Nº. {{$demanda->n_protocolo}} </b></span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Tipo de manifestação: </b>{{ $demanda->tipoManifestacao }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Assunto: </b>{{ $demanda->assunto  }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Origem: </b>{{ $demanda->origem }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Usuário: </b>{{ $demanda->tipoUsuario }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Nome: </b>{{ ($demanda->sigilo_id == 2) ? 'Confidencial' : $demanda->nome }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Celular: </b>{{ $demanda->fone  }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Classificação: </b>{{ $demanda->prioridade  }}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Prazo de Resposta: </b>{{ $demanda->prazo  }} dias úteis</span></td>
        </tr>
    </table><br />

    <table border rules=none style="width: 100%;">
        <tr>
            <td><span><b>Descrição da Manifestação do autor</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><p>{{ $demanda->relato }}</p></td>
        </tr>
    </table> <br />

    <table border rules=none style="width: 100%;">
        <tr>
            <td><span><b>Interpretação da Manifestação pela ouvidoria</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><p>{{ $demanda->parecer }}</p></td>
        </tr>
    </table>

</div>

<center>
    <div class="rodape" style="">
        <center><img src="{{asset('/img/LOGO_OUVIDORIA_1.jpg')}}" style="width: 130px; height: 85px"></center>
    </div>
</center>

</body>
</html>