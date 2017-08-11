/**
 * Created by fabio_000 on 29/06/2017.
 */

// Vari�vel global para armazenar o status da demanda para filtro da grid
var statusGet;

$(document).ready(function(){

    function formatDemanda(d) {

        var html = "";

        html += "<table class='table table-border'>";
        html += "<tbody>";
        html += "<tr>";
        html += "<td class='info'>Protocolo</td><td>"+d.n_protocolo+"</td>";
        html += "</tr>";
        html += "<tr>";
        html += "<td class='info' style='width: 15%;'>Nome</td><td>"+d.nome+"</td>";
        html += "</tr>";
        html += "<tr>";
        var assunto = d.assunto != null ? d.assunto : '';
        html += "<td class='info'>Assunto</td><td>"+ assunto +"</td>";
        html += "</tr>";
        html += "<tr>";
        var area = d.area_destino != null ? d.area_destino : '';
        html += "<td class='info'>Secretaria</td><td>"+ area + "</td>";
        html += "</tr>";
        html += "<tr>";
        html += "<td class='info'>Ouvidoria</td><td>"+ d.ouvidoria + "</td>";
        html += "</tr>";
        html += "<tr>";
        var destino = d.destino != null ? d.destino : '';
        html += "<td class='info'>Departamento</td><td>"+ destino +"</td>";
        html += "</tr>";
        html += "<td colspan='2' class='info'>Relato</td>";
        html += "</tr>";
        html += "<tr>";
        html += "<td colspan='2'>"+d.relato+"</td>";
        html += "</tr>";
        html += "</tbody>";
        html += "</table>";

        return html;
    }

    var tableDemanda = $('#demanda-grid').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 1, "desc" ]],
        fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
            if ( aData['demandaAgrupada'] == "1" )
            {
                $('td', nRow).css('background-color', '#a9d4e9');
            }
        },
        ajax: {
            url: "/index.php/seracademico/ouvidoria/demanda/grid",
            method: 'POST',
            data: function (d) {
                d.data_inicio = $('input[name=data_inicio]').val();
                d.data_fim = $('input[name=data_fim]').val();
                d.status = $('select[name=status] option:selected').val();
                d.responsavel = $('select[name=responsavel] option:selected').val();
                d.statusGet = statusGet;
                d.globalSearch = $('input[name=globalSearch]').val();
            }
        },
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           'ouv_demanda.nome',
                "defaultContent": ''
            },
            {data: 'data', name: 'ouv_demanda.data'},
            {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
            {data: 'codigo', name: 'ouv_demanda.codigo'},
            {data: 'responsavel', name: 'users.name'},
            {data: 'prioridade', name: 'ouv_prioridade.nome'},
            {data: 'informacao', name: 'ouv_informacao.nome'},
            {data: 'tipo_demanda', name: 'ouv_tipo_demanda.nome'},
            {data: 'status', name: 'ouv_status.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    //Fun��o do submit do search da grid principal
    $('#search').click(function(e) {
        statusGet = "0";
        tableDemanda.draw();
        e.preventDefault();
    });

    // Add event listener for opening and closing details
    $('#demanda-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = tableDemanda.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( formatDemanda(row.data()) ).show();
            tr.addClass('shown');
        }
    });
});


$(document).on('click', 'a.excluir', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    swal({
        title: "Alerta",
        text: "Tem certeza da exclusão da manifestação?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim!",
    }).then(function(){
        location.href = url;
    });
});

$(document).on('click', 'a.arquivar', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    swal({
        title: "Alerta",
        text: "Deseja arquivar a manifestação?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim!",
    }).then(function(){
        location.href = url;
    });
});