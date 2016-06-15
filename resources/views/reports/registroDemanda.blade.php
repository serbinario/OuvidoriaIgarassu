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
            width:100%;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">
    <h4>REGISTRO DE DEMANDAS DA OUVIDORIA</h4>
    <span class="text">Data: {{$dataFromat}}</span> <span class="text" style="margin-left: 581px">Demanda n.º {{$codFull}}</span><br />
    <span class="text">Sigilo @if($demanda['sigilo']['id'] == '2') ( X ) @elseif ($demanda['sigilo']['id'] == '1') ( ) @endif</span> <span class="text">Anônimo @if($demanda['anonimo']['id'] == '2')( X ) @elseif ($demanda['anonimo']['id'] == '1') ( ) @endif</span> <br />

    <h4>1. DADOS PESSOAIS</h4>
    <span class="text">Nome: {{$demanda['nome']}}</span><br />
    <span class="text">Endreço: {{$demanda['endereco']}}</span><br />
    <span class="text">Bairro: {{$demanda['minicipio']}}</span> <span class="text" style="margin-left: 400px">Telefone: {{$demanda['fone']}}</span><br />
    <span class="text">Idade: {{$demanda['idade']['nome']}}</span> <span class="text" style="margin-left: 445px">Sexo: {{$demanda['sexo']['nome']}}</span><br />
    <span class="text">Escolaridade: {{$demanda['escolaridade']['nome']}}</span> <span class="text" style="margin-left: 277px">Usa exclusivamente SUS? ( <?php if($demanda['exclusividadeSUS']['id'] == '1') { ?> X <?php }?> ) Sim ( <?php if($demanda['exclusividadeSUS']['id'] == '2') { ?> X <?php }?> ) Não </span>

    <h4>2. RELATO (com data aproximada)</h4>
    <p class="text" style="text-align: justify">{{$demanda['relato']}}</p>

    <h4>3. Quais melhorias você identifica na saúde de Igarassu</h4>
    <p class="text" style="text-align: justify">{{$demanda['melhorias']}}</p>


    <h4>4. Observações</h4>
    <p class="text" style="text-align: justify">{{$demanda['obs']}}</p>
</div>

<center>
    <div class="rodape" style="background: url({{asset('/img/igarassu.png')}}); width: 354px; height: 82px; margin-top: 550px; margin-left: 30%">

    </div>
</center>

</body>
</html>