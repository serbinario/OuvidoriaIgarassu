<html>
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</header>
<body>
<h4>Olá {{ $demanda->nome }},</h4>

<?php $data = \DateTime::createFromFormat("Y-m-d H:i:s", $demanda->data); ?>

<p style="text-align: justify">
    Sua manifestação foi registrado com o protocolo nº {{$demanda->n_protocolo}} em {{ $data->format("d/m/Y") }}
    às {{ $data->format("H:i:s") }} horas e será encaminhada para providência. Para consultar o andamento da sua
    manifestação acessando o <a href="{{$configuracaoGeral->consulta_externa}}">Link</a>, digitando o número do protocolo.
</p>

<p style="text-align: justify">
    {{$configuracaoGeral->texto_agradecimento}}<br />
    <table style="width: 50%; border-collapse: collapse;" cellspacing="0" cellpadding="0" border="1" width="50%">
        <tbody>
        <tr>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;"><b>Pessoalmente ou Correspondências:</b></td>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;">{{$configuracaoGeral->texto_ende_horario_atend}}</td>
        </tr>
        <tr>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;"><b>Telefone 1:</b></td>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;">{{$configuracaoGeral->telefone1}}</td>
        </tr>
        <tr>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;"><b>Telefone 2:</b></td>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;">{{$configuracaoGeral->telefone2}}</td>
        </tr>
        <tr>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;"><b>Site:</b></td>
            <td style="height:26px;
            padding-left:4px;
            padding-right:2px;
            font-family:Verdana, Geneva, sans-serif;
            font-size:12px;
            white-space:nowrap;
            border-bottom:solid 1px #E1E1E1;">{{$configuracaoGeral->acesso_principal}}</td>
        </tr>
        </tbody>
    </table>
</p>

<br />
<p style="text-align: justify">
    Atenciosamente
</p>

<p style="text-align: justify">
    {{$configuracaoGeral->nome_ouvidor}}<br />
    {{$configuracaoGeral->cargo}}
</p>

</body>
</html>