// Regras de validação
$(document).ready(function () {

   /// $.validator.setDefaults({ ignore: '' });
    $("#formServidor").validate({
        rules: {
            'cgm[nome]': {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            'cgm[sexo_id]': {
                required: true,
                integer: true
            },

            'cgm[data_nascimento]': {
                required: true,
                maxlength: 15
            },

            'cgm[nacionalidade_id]': {
                required: true,
                integer: true
            },

            'cgm[cgm_municipio_id]': {
                required: true,
                integer: true
            },

            'cgm[estado_civil_id]': {
                required: true,
                integer: true
            },

            'cgm[escolaridade_id]': {
                required: true,
                integer: true
            },

            'cgm[cpf]': {
                required: true,
                cpfBR: true,
                maxlength: 20,
                unique: [laroute.route('servidor.searchCpf'), $('#idServidor')]
            },

            'cgm[rg]': {
                required: true,
                number: true,
                maxlength: 20
            },
            'cgm[endereco][logradouro]': {
                required: true,
                alphaSpace: true,
                maxlength: 200
            },

            'cgm[endereco][numero]': {
                required: true,
                number: true,
                maxlength: 10
            },

            'cgm[endereco][bairro_id]': {
                required: true,
                integer: true
            },

            cidade: {
                required: true,
                integer: true
            },

            estado: {
                required: true,
                integer: true
            },

            data_admicao: {
                dateBr: true,
                required: true
            },

            carga_horaria: {
                number: true,
                required: true
            },

            tipo_vinculo_servidor_id: {
                integer: true,
                //required: true
            },

            cargos_id: {
                integer:true,
                required: true
            },

            funcoes_id: {
                //required: true,
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