// Regras de validação
$(document).ready(function () {

    $("#formPeriodo").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 45
            },

            abreviatura: {
                required: true,
                maxlength: 30
            },

            soma_carga_horaria: {
                integer: true,
                maxlength: 1
            },

            controle_frequencia: {
                required: true,
                integer: true,
                maxlength: 1
            },

            ordenacao: {
                integer: true,
                maxlength: 15
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