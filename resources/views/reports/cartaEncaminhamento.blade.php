{{--{{dd($demanda)}}--}}
<?php
//Pegando o código
/*$cod = str_pad($demanda['codigo'],8,"0",STR_PAD_LEFT);
$codigo =  substr($cod, 0, -4);
$ano = substr($cod, -4);
$codFull = $codigo."/".$ano;*/
//formatando data
/*$date = explode('T', $demanda['data']);
$data = \DateTime::createFromFormat('Y-m-d', $date[0]);
$dataFromat = $data->format('d/m/Y');*/
//formatando data
/*if(isset($demanda['encaminhamento']['data'])) {
    $dateEncaminhamento = explode('T', $demanda['encaminhamento']['data']);
    $dataEncaminhamento = \DateTime::createFromFormat('Y-m-d', $dateEncaminhamento[0]);
    $dataEncaminhamentoFormat = $dataEncaminhamento->format('d/m/Y');
} else {
    $dataEncaminhamentoFormat = "";
}*/
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
            font-size: 13px;
            margin-left: 20px;
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
        <span style="font-size: 10px"><b>Secretaria Municipal de Saúde</b></span><br />
        <span style="font-size: 10px">Ouvidoria da Saúde</span>
    </center>
    {{--<center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/ouvidoria-logo.png')}}" style="width: 320px; height: 100px"></center>
        </div>
    </center>--}}

    <h5 style="font-size: 15px">Demanda N.º: {{$demanda->codigo}}</h5>

    <span><b>Ao secretário</b></span></br>
    <span><b>Dra. Sônia Arruda</b></span></br>

    <span style="position: absolute; top: 180px; left: 480px;">Abreu e Lima, 03 de Maio de 2017.</span></br>

    <span>Assunto: Manifestação recebida pela Ouvidoria Geral do Município de Abreu e Lima.</span></br></br>

    <span><b>Prezado(a) Senhor(a),</b></span></br>
    <span><b>Cumprimentando Cordialmente, encaminhamos a V.S.a a {{ $demanda->tipoManifestacao }} via {{$demanda->origem}} da ouvidoria,</b> para fins de
        conhecimento e para que sejam tomadas as devidas providências cabíveis.</span>
    <span>Devido ao caráter interativo da Ouvidoria Municipal a qual permite ao usuário o acompanhamento do processo em
        epígrafe, solicito informar a este setor no prazo específico através de <b>comunicação interna</b> as providências
    adotada e/ou possível solução do problema. Considerando a <b>resposta</b> primordial para a satisfação do cidadão.</span></br></br>


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
            <td><span><b>Descrição da Manifestação</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><span>{{ $demanda->relato }}</span></td>
        </tr>
    </table> <br />

    <table border rules=none style="width: 100%;">
        <tr>
            <td><span><b>Tradução da Manifestação</b></span></td>
        </tr>
        <tr>
            <td rowspan="5"><span>{{ $demanda->parecer }}</span></td>
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