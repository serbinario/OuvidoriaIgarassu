/**
 * Created by fabio_000 on 29/06/2017.
 */


$(document).ready(function(){

    function formatManifestacaoArquivada(d) {

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
        //var comunidade = d.comunidade != null ? d.comunidade : '';
        //html += "<td class='info'>Comunidade</td><td>"+ comunidade +"</td>";
        //html += "</tr>";
        // html += "<tr>";
        var assunto = d.assunto != null ? d.assunto : '';
        html += "<td class='info'>Assunto</td><td>"+ assunto +"</td>";
        html += "</tr>";
        html += "<tr>";
        html += "<tr>";
        //var melhoria = d.melhoria != null ? d.melhoria : '';
        //html += "<td class='info'>Melhoria</td><td>"+ melhoria +"</td>";
        //html += "</tr>";
        //html += "<tr>";
        var area = d.area_destino != null ? d.area_destino : '';
        html += "<td class='info'>Secretaria</td><td>"+ area + "</td>";
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

    var tableManifestacaoArquivada = $('#manifestacao-arquivada-grid').DataTable({
        processing: true,
        serverSide: true,
        order: [[ 1, "asc" ]],
        ajax: {
            url: "/index.php/seracademico/ouvidoria/demanda/gridManifestacoesArquivadas",
            method: 'POST'
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


    // Add event listener for opening and closing details
    $('#manifestacao-arquivada-grid tbody').on('click', 'td.details-control', function () {
        var tr  = $(this).closest('tr');
        var row = tableManifestacaoArquivada.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( formatManifestacaoArquivada(row.data()) ).show();
            tr.addClass('shown');
        }
    });

});