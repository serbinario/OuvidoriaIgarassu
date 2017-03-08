// Regras de validação
$(document).ready(function () {

    $("#formNivelEnsino").validate({
        rules: {
            nome: {
                unique: [laroute.route('nivelEnsino.uniqueNome'), $('#idNivelEnsino')],
                required: true,
                alphaSpace: true,
                maxlength: 30
            },

            codigo: {
                unique: [laroute.route('nivelEnsino.uniqueCodigo'), $('#idNivelEnsino')],
                required: true,
                maxlength: 30
            },

            modalidade_id: {
                required: true,
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