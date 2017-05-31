// Regras de validação
$(document).ready(function () {

    $("#formConfiguracaoGeral").validate({
        rules: {
            nome: {
                required: true,
            },

            instituicao: {
                required: true,
            },

            nome_ouvidor: {
                required: true,
            },

            cnpj: {
                required: true,
            },

            cargo: {
                required: true,
            },

            /*texto_agradecimento: {
                required: true,
            },

            texto_ende_horario_atend: {
                required: true,
            },

            telefone1: {
                required: true,
            },

            telefone2: {
                required: true,
            },

            pagina_principal: {
                required: true,
            },*/

            email: {
                required: true,
            },

            senha: {
                required: true,
            },

          /*  acesso_principal: {
                required: true,
            },

            consulta_externa: {
                required: true,
            }*/
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