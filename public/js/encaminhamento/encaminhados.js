
var statusGet;
$(document).ready(function(){


    var table = $('#encaminhamento-grid').DataTable({
        processing: true,
        serverSide: true,
        bLengthChange: false,
        order: [[ 1, "asc" ]],
        ajax: {
            url: "/seracademico/ouvidoria/encaminhamento/encaminhadosGrid",
            method: 'POST',
            data: function (d) {
                d.status = $('select[name=status] option:selected').val();
                d.responsavel = $('select[name=responsavel] option:selected').val();
                d.statusGet = statusGet;
            }
        },
        columns: [
            {data: 'codigo', name: 'codigo', orderable: false, searchable: false},
            {data: 'area', name: 'ouv_area.nome'},
            {data: 'destino', name: 'ouv_destinatario.nome'},
            {data: 'responsavel', name: 'users.name'},
            {data: 'prioridade', name: 'ouv_prioridade.nome'},
            {data: 'data', name: 'ouv_encaminhamento.data'},
            {data: 'previsao', name: 'ouv_encaminhamento.previsao'},
            {data: 'status', name: 'ouv_status.nome'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    // Função do submit do search da grid principal
    $('#search').click(function(e) {
        statusGet = "0";
        table.draw();
        e.preventDefault();
    });

});

$(document).on('click', 'a.excluir', function (event) {
    event.preventDefault();
    var url = $(this).attr('href');
    bootbox.confirm("Tem certeza da exclusão do item?", function (result) {
        if (result) {
            location.href = url
        } else {
            false;
        }
    });
});