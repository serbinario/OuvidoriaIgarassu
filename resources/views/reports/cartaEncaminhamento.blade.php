<?php

//Pegando o código
$cod = str_pad($demanda['codigo'],8,"0",STR_PAD_LEFT);
$codigo =  substr($cod, 0, -4);
$ano = substr($cod, -4);
$codFull = $codigo."/".$ano;

//formatando data
$date = explode('T', $demanda['data']);
$data = \DateTime::createFromFormat('Y-m-d', $date[0]);
$dataFromat = $data->format('d/m/Y');

//formatando data
$dateEncaminhamento = explode('T', $demanda['encaminhamento']['data']);
$dataEncaminhamento = \DateTime::createFromFormat('Y-m-d', $dateEncaminhamento[0]);
$dataEncaminhamentoFormat = $dataEncaminhamento->format('d/m/Y');

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
            height: 82px;
            margin-top: 550px;

        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">

    <center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/ouvidoria_saude.png')}}" style="width: 120px; height: 100px"></center>
        </div>
    </center>

    <center><h4>DOCUMENTO DE ENCAMINHAMENTO</h4></center>
    <span class="text"><b>Data do encaminhamento:</b> {{$dataEncaminhamentoFormat}}</span> <br />
    <span class="text"><b>Destino:</b> {{$demanda['encaminhamento']['destinatario']['nome']}}</span><br />
    {{--<span class="text">Utiliza exclusivamente o SUS? @if($demanda['exclusividadeSUS']['id'] == '2')( X ) @elseif ($demanda['exclusividadeSUS']['id'] == '3' || $demanda['exclusividadeSUS']['id'] == '1') ( ) @endif</span> <br />--}}

    <h4>1. DADOS DA DEMANDA</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 340px"><span class="text"><b>Tipo de demanda:</b> {{$demanda['tipoDemanda']['nome']}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Assunto:</b> {{$demanda['subassunto']['assunto']['nome']}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Subassunto:</b> {{$demanda['subassunto']['nome']}}</span></td>
        </tr>
    </table>

    <h4>2. DADOS PESSOAIS</h4>
    <table style="width: 100%">
        @if($demanda['sigilo']['id'] == 1)
            <tr>
                <td style="width: 340px"><span class="text"><b>Nome:</b> {{$demanda['nome']}}</span></td>
            </tr>
        @endif
        <tr>
            <td style="width: 100px"><span class="text"><b>Endreço:</b> {{$demanda['endereco']}}</span></td>
            <td style="width: 100px"><span class="text"><b>Número:</b> {{$demanda['numero_end']}}</span></td>
        </tr>
        <tr>
            <td>
                <span class="text"><b>Telefone:</b> {{$demanda['fone']}}</span>
            </td>
        </tr>
            <tr>
                <td>
                    <span class="text"><b>Comunidade:</b> @if(isset($demanda['comunidade']['nome'])){{$demanda['comunidade']['nome']}}@endif</span>
                </td>
            </tr>
    </table>

    <h4>3. RELATO (com data aproximada)</h4>
    <p class="text" style="text-align: justify">{{$demanda['relato']}}</p>

    <h4>4. COMENTÁRIO/PARECER</h4>
    <p class="text" style="text-align: justify">{{$demanda['encaminhamento']['parecer']}}</p>

    {{--<h4>4. Dados da demanda</h4>--}}
    {{--<p class="text" style="text-align: justify">{{$demanda['melhorias']}}</p>--}}


    {{--<h4>4. Observações</h4>
    <p class="text" style="text-align: justify">{{$demanda['obs']}}</p>--}}
</div>

<center>
    <div class="rodape" style="">
        <center><img src="{{asset('/img/igarassu.png')}}" style="width: 230px; height: 55px"></center>
    </div>
</center>

</body>
</html>