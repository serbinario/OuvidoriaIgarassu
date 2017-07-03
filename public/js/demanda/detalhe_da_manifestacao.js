
// Variáveis globais
var idDemanda, idEncaminhamento;

function format(d) {

    var html = "";

    html += "<table class='table table-border'>";
    html += "<tbody>";
    html += "<tr>";
    html += "<td class='info' style='width: 15%;'>Parecer</td><td>"+d.parecer+"</td>";
    html += "</tr>";
    html += "<tr>";
    html += "<td class='info'>Resposta</td><td>"+d.resposta+"</td>";
    html += "</tr>";
    html += "</tbody>";
    html += "</table>";

    return html;
}

$(document).ready(function(){

    // Grid de histórico da demanda
    var table = $('#historico-grid').DataTable({
        processing: true,
        serverSide: true,
        bFilter: false,
        bLengthChange: false,
        order: [[ 1, "asc" ]],
        ajax: {
            url: "/index.php/seracademico/ouvidoria/encaminhamento/historicoGrid",
            method: 'POST',
            data: {'id' : idDemanda},
        },
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           'ouv_prioridade.nome',
                "defaultContent": ''
            },
            {data: 'data', name: 'ouv_encaminhamento.data'},
            {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
            {data: 'prioridade', name: 'ouv_prioridade.nome'},
            {data: 'area', name: 'ouv_area.nome'},
            {data: 'destinatario', name: 'ouv_destinatario.nome'},
            {data: 'status', name: 'ouv_status.nome'},
        ]
    });

    // Add event listener for opening and closing details
    $('#historico-grid tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );

        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    });

});


//Finalizar demanda
$('#btnFinalizarManifestacao').click(function() {

    var statusExterno = $('#status_externo_id option:selected').val();

    location.href = "/index.php/seracademico/ouvidoria/encaminhamento/finalizar/"+idEncaminhamento+"?statusExterno="+statusExterno;

});

//Carregando os departamentos
$(document).on('change', "#secretaria", function () {
    //Removendo as assuntos
    $('#destinatario_id option').remove();

    //Recuperando a secretaria
    var secretaria = $(this).val();

    if (secretaria !== "") {
        var dados = {
            'table' : 'ouv_destinatario',
            'field_search' : 'area_id',
            'value_search': secretaria,
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/util/search",
            data: dados,
            datatype: 'json'
    }).done(function (json) {
        var option = "";

        option += '<option value="">Selecione</option>';
        for (var i = 0; i < json.length; i++) {
            option += '<option value="' + json[i]['id'] + '">' + json[i]['nome'] + '</option>';
        }

        $('#destinatario_id option').remove();
        $('#destinatario_id').append(option);
    });
}
});


// Grid de demandas agrupadas
var table2 = $('#demandas-agrupadas-grid').DataTable({
    processing: true,
    serverSide: true,
    bFilter: false,
    bLengthChange: false,
    order: [[ 1, "asc" ]],
    ajax: {
        url: "/index.php/seracademico/ouvidoria/encaminhamento/demandasAgrupadasGrid",
        method: 'POST',
        data: {'id' : idDemanda},
    },
    columns: [
        {data: 'codigo', name: 'agrupada.codigo'},
        {data: 'area', name: 'ouv_area.nome'},
        {data: 'assunto', name: 'ouv_assunto.nome'},
        {data: 'subassunto', name: 'ouv_subassunto.nome'},
        {data: 'status', name: 'ouv_status.nome'},
        {data: 'data', name: 'agrupada.data'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
    ]
});

//Agrupar demanda
$(document).on('click', "#agrupar-demanda", function () {

    //Recuperando a secretaria
    var codigo = $('#codigo').val();
    var idDemanda = "{{$detalheEncaminhamento->demanda_id}}";

    if (codigo !== "") {

        var dados = {
            'codigo' : codigo,
            'id' : idDemanda,
        };

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/ouvidoria/encaminhamento/agruparDemanda",
            data: dados,
            datatype: 'json'
    }).done(function (json) {
        if(json['retorno']) {
            //Success Message
            swal("Ok!", json['msg'], "success");
            table2.ajax.reload();
            $('#codigo').val("");
        } else {
            swal("Ok!", json['msg'], "warning");
        }
    });
} else {
    swal("Ops!", "Você deve informar o código de uma demanda para o agrupamento!", "warning");
}
});

// Excluir agrupamento
$(document).on('click', 'a.excluir-agrupamento', function (event) {
    event.preventDefault();
    var id = $(this).attr('data');
    swal({
        title: "Alerta",
        text: "Tem certeza da exclusão do agrupamento?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sim!",
    }).then(function(){

        jQuery.ajax({
            type: 'POST',
            url: "/index.php/seracademico/ouvidoria/encaminhamento/deleteAgrupamento",
            data: {'id' : id},
        datatype: 'json'
    }).done(function (json) {
        if(json['retorno']) {
            swal("Ok!", json['msg'], "success");
            table2.ajax.reload();
        } else {
            swal("Ok!", json['msg'], "warning");
        }
    });

});
});