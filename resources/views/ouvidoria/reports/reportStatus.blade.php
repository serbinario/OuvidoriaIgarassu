<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title></title>
    <style type="text/css" class="init">

        body {
            font-family: arial;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        table , tr , td {
            font-size: small;
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<center>
    <div class="topo" style="">
        <center><img src="{{asset('/img/ouvidoria_saude.png')}}" style="width: 150px; height: 100px"></center>
    </div>
</center>

<center><h4>RELATÓRIO DE PESSOAS POR STATUS</h4></center>

<table id="example" border="1" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Numeração</th>
            <th>Nome</th>
            <th>Subassunto</th>
            <th>Status</th>
            <th>Telefone</th>
        </tr>
    </thead>
    <tbody>
    <?php $count = 0; ?>
        @foreach($demandas as $demanda)
            <tr>
                <td style="text-align: center">
                    <?php $count++ ?>
                    {{$count}}
                </td>
                <td>{{$demanda->nome}}</td>
                <td>@if(isset($demanda->subassunto)) {{$demanda->subassunto}} @endif</td>
                <td>@if(isset($demanda->situacao)) {{$demanda->situacao}} @endif</td>
                <td>{{$demanda->fone}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>