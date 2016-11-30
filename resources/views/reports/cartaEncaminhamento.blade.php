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
        span, p {
            font-size: 13px;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">

    <center>
        <div class="topo" style="">
            <center><img src="{{asset('/img/timbre.jpg')}}" style="width: 90px; height: 90px"></center>
        </div><br />
        <span style="font-size: 10px"><b>Secretaria Municipal de Saúde</b></span><br />
        <span style="font-size: 10px">Ouvidoria da Saúde</span>
    </center>

    <h5 style="font-size: 15px">Demanda N.º: {{$codFull}}</h5>

    <span class="text"><b>Data do encaminhamento:</b> {{$dataEncaminhamentoFormat}}</span> <br />
    <span class="text"><b>Destino:</b> {{$demanda['encaminhamento']['destinatario']['nome']}}</span><br />
    {{--<span class="text">Utiliza exclusivamente o SUS? @if($demanda['exclusividadeSUS']['id'] == '2')( X ) @elseif ($demanda['exclusividadeSUS']['id'] == '3' || $demanda['exclusividadeSUS']['id'] == '1') ( ) @endif</span> <br />--}}

    <h4>1. DETALHES DA DEMANDA</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 340px"><span class="text"><b>Característica da demanda:</b> {{$demanda['informacao']['nome']}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Prioridade :</b> {{$demanda['encaminhamento']['prioridade']['nome']}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Assunto:</b> {{$demanda['subassunto']['assunto']['nome']}}</span></td>
        </tr>
        <tr>
            <td style="width: 340px"><span class="text"><b>Subassunto:</b> {{$demanda['subassunto']['nome']}}</span></td>
        </tr>
    </table>

    <h4>2. DADOS DO CIDADÃO</h4>
    <table style="width: 100%">
        @if($demanda['sigilo']['id'] == 1)
            <tr>
                <td style="width: 340px"><span class="text"><b>Nome:</b> {{$demanda['nome']}}</span></td>
            </tr>
        @endif
            <tr>
                <td>
                    <span class="text"><b>Comunidade:</b> @if(isset($demanda['comunidade']['nome'])){{$demanda['comunidade']['nome']}}@endif</span>
                </td>
            </tr>
            <tr>
                <td style="width: 100px"><span class="text"><b>Endreço:</b> {{$demanda['endereco']}}</span></td>
            </tr>
            <tr>
                <td style="width: 100px"><span class="text"><b>Número:</b> {{$demanda['numero_end']}}</span></td>
            </tr>
            <tr>
                <td>
                    <span class="text"><b>Telefone:</b> {{$demanda['fone']}}</span>
                </td>
            </tr>
    </table>

    <h4>3. RELATO</h4>
    <p class="text" style="text-align: justify">{{$demanda['relato']}}</p>

    <h4>4. OBSERVAÇÃO</h4>
    <p class="text" style="text-align: justify">{{$demanda['obs']}}</p>

    <h4>5. COMENTÁRIO/PARECER</h4>
    <p class="text" style="text-align: justify">Encaminhamos Manifestação para análise e providências cabíveis</p>
    {{--<p class="text" style="text-align: justify">{{$demanda['encaminhamento']['parecer']}}</p>--}}

    <h4>6. RESPOSTA</h4>
    <p class="text" style="text-align: justify">{{$demanda['encaminhamento']['resposta']}}</p>

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