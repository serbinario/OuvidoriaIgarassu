<html>
<title>

</title>
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</header>
<body>

<h3>Você recebeu uma demanda para ser analisada</h3>

<p>
    Segue dados da demanda
</p>

<table class="table table-bordered" width="100%">
    <tbody>
    <tr style="background-color: #e0e5ef">
        <td><b>Data:</b> {{$detalhe->data}}</td>
        <td><b>Previsão:</b> {{$detalhe->previsao}}</td>
        <td><b>Prioridade:</b> {{$detalhe->prioridade}}</td>
    </tr>
    <tr>
        <td><b>Secretaria:</b> {{$detalhe->area}}</td>
        <td><b>Departamento/Destinatário:</b> {{$detalhe->destinatario}}</td>
        <td><b>Status:</b> {{$detalhe->status}}</td>
    </tr>
    <tr>
        <td><b>Tipo da demanda:</b> {{$detalhe->informacao}}</td>
        <td><b>Assunto:</b> {{$detalhe->assunto}}</td>
        <td><b>Subassunto:</b> {{$detalhe->subassunto}}</td>
    </tr>
    <tr>
        <td colspan="3"><b>Relato: </b></span>{{$detalhe->relato}}</td>
    </tr>
    <tr>
        <td colspan="3"><b>Parecer: </b></span>{{$detalhe->parecer}}</td>
    </tr>
    </tbody>
</table>

</body>
</html>