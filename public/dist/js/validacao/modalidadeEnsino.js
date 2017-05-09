// Regras de validação
$(document).ready(function () {

    $("#formModalidadeEnsino").validate({
        rules: {
            nome: {
                unique: [laroute.route('modalidadeEnsino.uniqueNome'), $('#idModalidadeEnsino')],
                required: true,
                alphaSpace: true,
                maxlength: 30
            },

            codigo: {
                unique: [laroute.route('modalidadeEnsino.uniqueCodigo'), $('#idModalidadeEnsino')],
                required: true,
                alphaSpace: true,
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