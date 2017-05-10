// Regras de validação
$(document).ready(function () {

    $("#formEscola").validate({
        rules: {
            codigo: {
                required: true,
                maxlength: 50
            },

            inep: {
                required: true,
                maxlength: 20
            },

            nome: {
                required: true,
                alphaSpace: true,
                maxlength: 100
            },
            portaria: {
                required: true,
                number: true,
                maxlength: 45
            },
            dt_pub_portaria: {
                required: true,
                dateBr: true
            },
            'endereco[logradouro]': {
                maxlength: 150,
                required: true
            },
            'endereco[numero]': {
                maxlength: 10,
                required: true
            },
            'endereco[bairro_id]': {
                integer: true,
                required: true
            },

            estado: {
                integer: true,
                required: true
            },

            'endereco[cidade_id]': {
                integer: true,
                required: true
            }
        },
        //For custom messages
        /*messages: {
             nome_operadores:{
             required: "Enter a username",
             minlength: "Enter at least 5 characters"
         }
         },*/
        //Reponsavel por indicar em que guia do formulário existe preenchimento incorreto
        invalidHandler: function(e, validator) {
            if(validator.errorList.length) {
                $('#tabs').attr('data-tab-color', 'red');
                $('#tabs a[href="#' + jQuery(validator.errorList[0].element).closest(".tab-pane").attr('id') + '"]').tab('show');
            }
        },
        //Define qual elemento será adicionado
        errorElement : 'small',
        errorPlacement: function(error, element) {
            error.insertAfter(element.parent());
        },

        highlight: function(element, errorClass) {
            //console.log("Error");
            $(element).parent().parent().addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            //console.log("Sucess");
            $(element).parent().parent().removeClass("has-error");

        }
    });
});