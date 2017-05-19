<?php
//formatando data
//$data = \DateTime::createFromFormat('Y-m-d', $date[0]);
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
            margin-top: 530px;

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
        </div>
    </center>

    <center><h4>OGMAL - Ouvidoria Geral do Município de Abreu e Lima</h4></center>

    <center><h4>REGISTRO DE MANIFESTAÇÃO DA OUVIDORIA</h4></center>
    <table style="width: 100%">
        <thead>
            <tr style="background-color: #B5B4B4">
                <th>Tipo da manifestação</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Nº da Demanda</th>
                <th>Origem</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #dfdfdf">
                <td style="text-align: center">{{$demanda->informacao}}</td>
                <td style="text-align: center">{{$demanda->data_da_ocorrencia}}</td>
                <td style="text-align: center">{{$demanda->hora_da_ocorrencia}}</td>
                <td style="text-align: center">{{$demanda->codigo}}</td>
                <td style="text-align: center">{{$demanda->tipo_demanda}}</td>
            </tr>
        </tbody>
    </table>
    {{--<span class="text">Data: {{$demanda->data_da_ocorrencia}}</span> --
    <span class="text">Hora: {{$demanda->hora_da_ocorrencia}}</span> --
    <span class="text">Demanda n.º {{$demanda->codigo}}</span><br />--}}
    {{--<span class="text">Sigilo @if($demanda->sigilo_id == '2') ( X ) @elseif ($demanda->sigilo_id == '1') ( ) @endif</span>
    <span class="text">Anônimo @if($demanda->anonimo_id == '2')( X ) @elseif ($demanda->anonimo_id == '1') ( ) @endif</span><br />--}}
    {{--<span class="text">Utiliza exclusivamente o SUS? @if($demanda['exclusividadeSUS']['id'] == '2')( X ) @elseif ($demanda['exclusividadeSUS']['id'] == '3' || $demanda['exclusividadeSUS']['id'] == '1') ( ) @endif</span> <br />--}}

    <h4>1. DADOS PESSOAIS</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 300px"><span class="text"><b>Nome:</b> {{$demanda->nome}}</span></td>
            <td><span class="text"><b>Sexo:</b> {{$demanda->sexo}}</span></td>
            <td><span class="text"><b>Idade:</b> {{$demanda->idade}}</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Telefone:</b> {{$demanda->fone}}</span></td>
            <td><span class="text"><b>E-mail:</b> {{$demanda->email}}</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>RG:</b> {{$demanda->rg}}</span></td>
            <td><span class="text"><b>CPF:</b> {{$demanda->cpf}}</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Profissão:</b> {{$demanda->profissao}}</span></td>
        </tr>
        <tr>
            <td style="width: 100px"><span class="text"><b>Endreço:</b> {{$demanda->endereco}}</span></td>
            <td style="width: 100px"><span class="text"><b>Número:</b> {{$demanda->numero_end}}</span></td>
        </tr>
        <tr>
            <td style=""><span class="text"><b>Cidade:</b> {{$demanda->cidade}}</span></td>
            <td style="width: 200px"><span class="text"><b>Bairro:</b> {{$demanda->bairro}}</span></td>
            <td style=""><span class="text"><b>CEP:</b> {{$demanda->cep}}</span></td>
        </tr>
    </table>

    <h4>2. AUTOR DA MANIFESTAÇÃO</h4>

    <p class="text" style="text-align: justify">{{$demanda->autor}}</p>

    <h4>3. RELATO</h4>
    <p class="text" style="text-align: justify">{{$demanda->relato}}</p>

    <h4>4. DADOS DA DEMANDA</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 80px"><span class="text"><b>Assunto:</b> {{$demanda->assunto}}</span></td>
            <td style="width: 50px"><span class="text"><b>Subassunto:</b> {{$demanda->subassunto}}</span></td>
        </tr>
        <tr>
            <td style="width: 300px"><span class="text"><b>Secretaria:</b> {{$demanda->area}}</span></td>
            <td><span class="text"><b>Secretário:</b> {{$demanda->secretario}}</span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 300px"><span class="text"><b>Destino:</b> {{$demanda->destino}}</span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 340px"><span class="text"><b>Comentário\Parecer:</b></span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 340px"><span class="text">{{$demanda->parecer}}</span></td>
        </tr>
    </table>

    {{--<h4>4. Dados da demanda</h4>--}}
    {{--<p class="text" style="text-align: justify">{{$demanda['melhorias']}}</p>--}}


    {{--<h4>4. Observações</h4>
    <p class="text" style="text-align: justify">{{$demanda['obs']}}</p>--}}
</div>

<center>
    <div class="rodape">
        <center><img src="{{asset('/img/LOGO_OUVIDORIA_1.jpg')}}" style="width: 130px; height: 85px"></center>
    </div>
</center>

</body>
</html>