@extends('menu')

@section('css')
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
@endsection

@section('content')
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <div class="col-sm-6 col-md-9">
                <h4><i class="material-icons">find_in_page</i> GRÁFICO DE ASSUNTOS DA DEMANDA</h4>
            </div>
            <div class="col-sm-6 col-md-3">
                <a href="{{ route('seracademico.ouvidoria.graficos.assunto') }}" target="_blank" class="btn-sm btn-primary pull-right">Imprimir</a>
            </div>
        </div>

        <div class="ibox-content">
            <center>
                <div id="barchart_values" style="width: 900px; height: 300px;"></div>
            </center>
        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        $.ajax({
            url: '{{route('seracademico.ouvidoria.graficos.assuntoAjax')}}',
            type: 'POST',
            dataType: 'JSON',
            success: function (json) {
                // console.log(json);
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
                title: "Assuntos",
                width: 600,
                height: 300,
                bar: {groupWidth: "50%"},
                legend: { position: "none" },
            };

            var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
            chart.draw(view, options);
        }
    </script>
@stop