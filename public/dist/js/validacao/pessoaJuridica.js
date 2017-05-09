// Regras de validação
$(document).ready(function () {

    $("#formPessoaJuridica").validate({
        rules: {
            nome: {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            cgm_municipio_id: {
                required: true,
                integer: true
            },

            cnpj: {
                unique: [laroute.route('pessoaJuridica.searchCnpj'), $('#idPessoaJuridica')],
                required: true
                //cnpj: true
            },

            nome_complemento: {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            nome_fantasia: {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            /*num_cgm: {
                required: true,
                alphaSpace: true,
                maxlength: 60
            },*/

            data_cadastramento: {
                dateBr: true,
                maxlength: 20
            },

            email: {
                email: true,
                maxlength: 45
            },

            tipo_empresa_id: {
                required: true,
                integer: true
            },

            nire: {
                number: true,
                maxlength: 45
            },

            /*tipo_cadastro: {
                integer: true
            },*/

            inscricao_estadual: {
                number: true,
                maxlength: 45
            },

            endereco_id: {
                integer: true
            },

            'telefone[nome]': {
                required: true,
                //number: true,
                maxlength: 18
            },

            'endereco[logradouro]': {
                required: true,
                alphaSpace: true,
                maxlength: 200
            },

            'endereco[numero]': {
                required: true,
                number: true,
                maxlength: 10
            },

            'endereco[complemento]': {
                alphaSpace: true,
                maxlength: 100
            },

            'endereco[estado_id]': {
                required: true,
                integer: true
            },

            'endereco[cidade_id]': {
                required: true,
                integer: true
            },

            'endereco[cep]': {
                //number: true,
                maxlength: 15
            },

            'endereco[bairro_id]': {
                required: true,
                integer: true
            },

            'endereco[zona_id]': {
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