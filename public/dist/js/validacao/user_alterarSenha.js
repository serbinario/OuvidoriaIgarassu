// Regras de validação
$(document).ready(function () {

    $("#formAlterarSenha").validate({
        rules: {
            senha_atual: {
                required: true,
                confirmPassword: [laroute.route('user.searchSenha'), $('#idUsuario')],
                maxlength: 100
            },

            password: {
                required: true,
                maxlength: 100
            },

            password_confirmation: {
                required: true,
                maxlength: 100
            }

        },

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