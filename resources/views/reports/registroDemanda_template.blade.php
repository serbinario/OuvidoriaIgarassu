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
            position: absolute;
            bottom:0;
            width: 100%;
            height: 90px;
            margin-top: 70px;

        }

        .table-assinatura, .table-assinatura th, .table-assinatura td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        span, p {
            font-size: 13px;
            /*   margin-left: 20px;*/
        }
    </style>
    <link href="" rel="stylesheet" media="screen">
</head>

<body>
<div class="page">

    <center>
        <div>
            <center><img src="http://serouvidoria-abreu.com/img/abreu.jpg" style="width: 130px; height: 85px"></center>
        </div>
    </center>

    <center><h4>$titulo$</h4></center>

    <center><h4>REGISTRO DE MANIFESTAÇÃO A OUVIDORIA</h4></center>

    <br /><br />
    <h4>DADOS DA MANIFESTAÇÃO</h4>
    <table style="width: 100%">
        <tr>
            <td style="width: 300px"><span class="text"><b>Tipo: </b>$informacao$</span></td>
            <td><span class="text"><b>Data: </b>$data_cadastro$</span></td>
            <td><span class="text"><b>Hora: </b>$hora_cadastro$</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Protocolo: </b>$protocolo$</span></td>
            <td><span class="text"><b>Registro: </b>$tipo_demanda$</span></td>
            <td><span class="text"><b>Identificação: </b>$sigilo$</span></td>
        </tr>
    </table>

    <h4>DADOS PESSOAIS</h4>
    <table style="width: 100%">
        <tr>
            <td colspan="3"><span class="text"><b>Nome:</b> $nome$</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Sexo:</b> $sexo$</span></td>
            <td><span class="text"><b>Telefone:</b> $fone$</span></td>
            <td><span class="text"><b>E-mail:</b> $email$</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Idade:</b> $idade$</span></td>
            <td><span class="text"><b>RG:</b> $rg$</span></td>
            <td><span class="text"><b>CPF:</b> $cpf$</span></td>
        </tr>
        <tr>
            <td><span class="text"><b>Profissão:</b> $profissao$</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="text"><b>Endereço:</b> $endereco$</span></td>
            <td ><span class="text"><b>Número:</b> $numero_end$</span></td>
        </tr>
        <tr>
            <td style=""><span class="text"><b>Cidade:</b> $cidade$</span></td>
            <td style="width: 200px"><span class="text"><b>Bairro:</b> $bairro$</span></td>
            <td style=""><span class="text"><b>CEP:</b> $cep$</span></td>
        </tr>
    </table>

    <h4>DADOS DA OCORRÊNCIA</h4>

    <table style="width: 100%">
        <tr>
            <td colspan="2" style="text-align: justify"><span style="text-align: justify"><b>Descrição:</b> $relato$</span></td>
        </tr>
    </table>

    <br /> <br /><br /><br />
    <h4 style="margin-top: 5%">Assinaturas:</h4>
    <table class="table-assinatura"  style="width: 100%;">
        <tr>
            <td style="width: 55%"><span><b>Manifestante<br /><br /><br /></b></span></td>
            <td><span><b>Ouvidor Geral<br /><br /><br /></b></span></td>
        </tr>
    </table>
</div>

<center>
    <div class="rodape">
        <center>
            <img src="http://serouvidoria-abreu.com/img/ouvidoria.png" style="width: 200px; height: 50px"><br />
            <span style="font-size: 10px">PREFEITURA MUNICIPAL DE ABREU E LIMA</span><br />
            <span style="font-size: 10px">Avenida Duque de Caxias nº 924 - Centro - Abreu E Lima PE</span><br />
            <span style="font-size: 10px">CEP: 53.580-020 - CNPJ: 08.637.3730001-80 - FONE: (81) 3542.1061</span>
        </center>
    </div>
</center>

</body>
</html>