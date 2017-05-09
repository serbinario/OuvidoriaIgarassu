// Regras de validação
$(document).ready(function () {

    $("#formInstituicao").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 100
            },

            cnpj: {
                required: true,
                maxlength: 35
            },

            insc_municipal: {
                required: true,
                maxlength: 60
            },

            insc_estadual: {
                required: true,
                maxlength: 60
            },

            'endereco[logradouro]': {
                required: true,
                maxlength: 200
            },

            'endereco[numero]': {
                required: true,
                number: true,
                maxlength: 10
            },

            'endereco[bairro_id]': {
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