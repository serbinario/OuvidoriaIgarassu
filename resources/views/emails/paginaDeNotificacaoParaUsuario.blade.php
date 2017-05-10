<html>
<header>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</header>
<body>
<h4>Olá caro manifestante!</h4>

<p>
    Somos da ouvidoria, estamos entrando em contato para informar que sua manifestação foi ouvida e te retornamos com uma reposta para você!
</p>
<p>
    Clique no link abaixo para consultar as informações da sua manifestação, use este
    <b>Número de protocolo: {{$demanda->n_protocolo}}, para realizar a consulta</b><br />
    <b>Link: </b> <a href="{{ route('buscarDemanda')  }}">Clique aqui para acessar</a>
</p>
</body>
</html>