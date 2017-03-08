<html>
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</header>
<body>


<center>
    <table style="width: 50%; border-collapse: collapse;" cellspacing="0" cellpadding="0" border="1" width="50%">
        <tbody>
        <tr>
            <td style="height:60px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:23px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;
        text-align: center; color: white;
        background-color: #59b1f6" colspan="3">

                Nova demanda para análise

            </td>
        </tr>
        <tr style="background-color: #e0e5ef">
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Data:</b> {{$detalhe->data}}</td>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Previsão:</b> {{$detalhe->previsao}}</td>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Prioridade:</b> {{$detalhe->prioridade}}</td>
        </tr>
        <tr>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Secretaria:</b> {{$detalhe->area}}</td>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Departamento/Destinatário:</b> {{$detalhe->destinatario}}</td>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;"><b>Status:</b> {{$detalhe->status}}</td>
        </tr>
        <tr>
            <td style="height:26px;
        padding-left:4px;
        padding-right:2px;
        font-family:Verdana, Geneva, sans-serif;
        font-size:12px;
        white-space:nowrap;
        border-bottom:solid 1px #E1E1E1;" colspan="3"><b>Parecer: </b></span>{{$detalhe->parecer}}</td>
        </tr>
        </tbody>
    </table>
</center>
</body>
</html>