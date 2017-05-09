// Regras de validação
$(document).ready(function () {
    $("#formTurmaComplementar").validate({
        rules: {
            nome: {
                required: true,
                maxlength: 100
            },

            codigo: {
                required: true,
                maxlength: 50
            },

            escola_id: {
                required: true,
                integer: true
            },

            tipo_atendimento_id: {
                required: true,
                integer: true
            },

            calendario_id: {
                required: true,
                integer: true
            },

            dependencia_id: {
                required: true,
                integer: true
            },

            vagas: {
                required: true,
                integer: true
            },

            aprovacao_automatica: {
                required: true,
                integer: true
            },

            turno_id: {
                required: true,
                integer: true
            },

            quantidade_atividade_id: {
                required: true,
                integer: true
            },

            observacao: {
                alphaSpace: true,
                maxlength: 500
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