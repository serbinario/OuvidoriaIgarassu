// Regras de validação
$(document).ready(function () {

    $("#formDemanda").validate({
        rules: {

            sigilo_id: {
                required: true,
            },

            anonimo_id: {
                required: true,
            },

            informacao_id: {
                required: true,
            },

            pessoa_id: {
                required: true,
            },

            relato: {
                required: true,
            },

            area_id: {
                required: true,
            }
        },
        //For custom messages
        /*messages: {
             nome_operadores:{
             required: "Enter a username",
             minlength: "Enter at least 5 characters"
         }
         },*/
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