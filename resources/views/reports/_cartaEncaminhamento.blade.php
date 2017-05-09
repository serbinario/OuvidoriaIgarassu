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
            height: 65px;
            margin-top: 785px;
        }
        span, p {
            font-size: 11px;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">

    <center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/logoabreulimasad.png')}}" style="width: 130px; height: 90px"></center>
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

    <div>Ao secretário</div>
    <div>Dra. Sônia Arruda</div></br>

    <div>Abreu e Lima, 03 de Maio de 2017.</div>

    <div>Assunto: Manifestação recebida pela Ouvidoria Geral do Município de Abreu e Lima.</div></br>

    <div><b>Prezado(a) Senhor(a),</b></div></br>
    <div><b>Cumprimentando Cordialmente, encaminhamos a V.S.a a $reclamação $via da ouvidoria,</b> para fins de
        conhecimento e para que semam tomadas as decidas providências cabíveis.</div>
    <div>Devido ao caráter interativo da Ouvidoria Municipal a qual permite ao usuário o acompanhamento do processo em
        epígrafe, solicito informar a este setor no prazo especifico através de <b>comunicação interna</b> as providencias
    adotada e/ou possível solução do problema. Considerando a <b>resposta</b> primordila para a satisfação do cidadão.</div>

    {{--<span class="text"><b>Data do encaminhamento:</b> {{$demanda->data}}</span> <br />
    <span class="text"><b>Secretaria:</b> {{$demanda->area}}</span><br />
    <span class="text"><b>Destino:</b> {{$demanda->destino}}</span><br />--}}
    {{--<span class="text">Utiliza exclusivamente o SUS? @if($demanda['exclusividadeSUS']['id'] == '2')( X ) @elseif ($demanda['exclusividadeSUS']['id'] == '3' || $demanda['exclusividadeSUS']['id'] == '1') ( ) @endif</span> <br />--}}

    {{--<h4>1. DETALHES DA DEMANDA</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 340px"><span class="text"><b>Característica da demanda:</b> {{$demanda->informacao}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Prioridade :</b> {{$demanda->prioridade}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Assunto:</b> {{$demanda->assunto}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Subassunto:</b> {{$demanda->subassunto}}</span></td>
        </tr>
    </table>

    <h4>2. DADOS DO CIDADÃO</h4>
    <table style="width: 100%">
        @if($demanda->sigilo_id == 1)
            <tr>
                <td style="width: 340px"><span class="text"><b>Nome:</b> {{$demanda->nome}}</span></td>
            </tr>
        @endif
        <tr>
            <td>
                <span class="text"><b>Comunidade:</b> {{$demanda->comunidade}}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 100px"><span class="text"><b>Endreço:</b> {{$demanda->endereco}}</span></td>
        </tr>
        <tr>
            <td style="width: 100px"><span class="text"><b>Número:</b> {{$demanda->numero_end}}</span></td>
        </tr>
        @if($demanda->sigilo_id == 1)
            <tr>
                <td>
                    <span class="text"><b>Telefone:</b> {{$demanda->fone}}</span>
                </td>
            </tr>
        @endif
    </table>

    <h4>3. RELATO</h4>
    <p class="text" style="text-align: justify">{{$demanda->relato}}</p>

    <h4>4. OBSERVAÇÃO</h4>
    <p class="text" style="text-align: justify">{{$demanda->obs}}</p>

    <h4>5. COMENTÁRIO/PARECER</h4>
    <p class="text" style="text-align: justify">Encaminhamos Manifestação para análise e providências cabíveis</p>

    <h4>6. RESPOSTA</h4>
    <p class="text" style="text-align: justify">{{$demanda->resposta}}</p>--}}
</div>

<center>
    <div class="rodape" style="">
        <center><img src="{{asset('/img/logoabreulimasad.png')}}" style="width: 130px; height: 65px"></center>
    </div>
</center>

</body>
</html>