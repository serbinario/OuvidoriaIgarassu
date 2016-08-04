<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="{{ asset('/js/jquery-2.1.1.js')}}"></script>
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
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    $.ajax({
        url: '{{route('seracademico.ouvidoria.graficos.idadeAjax')}}',
        type: 'POST',
        dataType: 'JSON',
        success: function (json) {
            drawChart(json)
        }
    });

    function drawChart(json) {

        var data = google.visualization.arrayToDataTable(json);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            { calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation" },
            2]);

        var options = {
            title: "Idade",
            width: 600,
            height: 300,
            bar: {groupWidth: "50%"},
            legend: { position: "none" },
        };

        var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
        chart.draw(view, options);
    }
</script>
<center>
    <div class="topo" style="">
        <center><img src="{{asset('/img/ouvidoria_saude.png')}}" style="width: 120px; height: 100px"></center>
    </div>
</center>

<center><h4>GRÁFICO DE IDADES DA DEMANDA</h4></center>
<center>
    <div id="barchart_values" style="width: 900px; height: 500px;"></div>
</center>

</body>
</html>