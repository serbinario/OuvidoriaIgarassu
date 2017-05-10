// Regras de validação
$(document).ready(function () {

    $("#formFormaAvaliacao").validate({
        rules: {
            nome: {
                required: true,
                //alphaSpace: true,
                maxlength: 100
            },

            codigo: {
                required: true,
                maxlength: 50
            },

            tipo_resultado_id: {
                required: true,
                integer: true
            },

            menor_nota: {
                number: true,
                maxlength: 5
            },

            maior_nota: {
                number: true,
                maxlength: 5
            },

            variacao: {
                number: true,
                maxlength: 5
            },

            minimo_aprovacao: {
                number: true,
                maxlength: 5
            },

            /*niveis_alfabeizacao: {
                alphaSpace: true,
                maxlength: 60
            },*/

            codigo_nivel_alfabetizacao: {
                maxlength: 60
            },

            nome_nivel_alfabetizacao: {
                maxlength: 100
            },

            min_aprovacao_nivel_alfabetizacao: {
                integer: true
            },

            parecer: {
                integer: true
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