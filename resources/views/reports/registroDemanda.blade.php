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
            <center><img src="{{asset('/img/pf.png')}}" style="width: 230px; height: 70px"></center>
        </div>
    </center>

    <h4>REGISTRO DE DEMANDAS DA OUVIDORIA</h4>
    <span class="text">Data: {{$demanda->data}}</span> --
    <span class="text">Demanda n.º {{$demanda->codigo}}</span><br />
    <span class="text">Sigilo @if($demanda->sigilo_id == '2') ( X ) @elseif ($demanda->sigilo_id == '1') ( ) @endif</span>
    <span class="text">Anônimo @if($demanda->anonimo_id == '2')( X ) @elseif ($demanda->anonimo_id == '1') ( ) @endif</span><br />
    {{--<span class="text">Utiliza exclusivamente o SUS? @if($demanda['exclusividadeSUS']['id'] == '2')( X ) @elseif ($demanda['exclusividadeSUS']['id'] == '3' || $demanda['exclusividadeSUS']['id'] == '1') ( ) @endif</span> <br />--}}

    <h4>1. DADOS PESSOAIS</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 340px"><span class="text">Nome: {{$demanda->nome}}</span></td>
        </tr>
        <tr>
            <td style="width: 100px"><span class="text">Endreço: {{$demanda->endereco}}</span></td>
            <td style="width: 100px"><span class="text">Número: {{$demanda->numero_end}}</span></td>
        </tr>
        <tr>
            <td style="width: 100px">
                <span class="text">Comunidade: {{$demanda->comunidade}}</span>
            </td>
            <td>
                <span class="text">Telefone: {{$demanda->fone}}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 100px">
                <span class="text">Idade: {{$demanda->idade}}</span>
            </td>
            <td>
                <span class="text">Sexo: {{$demanda->sexo}}</span>
            </td>
        </tr>
        <tr>
            <td style="width: 100px">
                <span class="text">Escolaridade: {{$demanda->escolaridade}}</span>
            </td>
            <td>
                <span class="text">Usa exclusivamente SUS? ( <?php if($demanda->exclusividade_sus_id == '2') { ?> X <?php }?> ) Sim ( <?php if($demanda->exclusividade_sus_id == '3') { ?> X <?php }?> ) Não </span>
            </td>
        </tr>
    </table>

    <h4>2. RELATO (com data aproximada)</h4>
    <p class="text" style="text-align: justify">{{$demanda->relato}}</p>

    <h4>3. Dados da demanda</h4>
    <table style="width: 100%">
        <tr>
            <td colspan="2" ><span class="text">Origem: {{$demanda->tipo_demanda}}</span></td>
        </tr>
        <tr>
            <td style="width: 80px"><span class="text">Assunto: {{$demanda->assunto}}</span></td>
            <td style="width: 50px"><span class="text">Subassunto: {{$demanda->subassunto}}</span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 500px"><span class="text">Área: {{$demanda->area}}</span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 500px"><span class="text">Destino: {{$demanda->destino}}</span></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 340px"><span class="text">Comentário\Parecer:</span></td>
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
    <div class="rodape" style="">
        <center><img src="{{asset('/img/pf.png')}}" style="width: 230px; height: 70px"></center>
    </div>
</center>

</body>
</html>