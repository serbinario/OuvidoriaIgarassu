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
    Sua manifestação foi registrado com o protocolo n {{$demanda->n_protocolo}} em {{ $data->format("d/m/Y") }}
    as {{ $data->format("H:i:s") }} horas e será encaminhada para providência.
</p>

<p style="text-align: justify">
    Para consultar o andamento da sua manifestação acessando o
    <a href="http://serouvidoria-abreu.serbinario.com.br/seracademico/indexPublico">Link</a>,
    digitanto o numero do protocolo
</p>

</body>
</html>