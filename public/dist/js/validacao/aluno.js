// Regras de validação
$(document).ready(function () {

    $("#formAluno").validate({
        rules: {
            'codigo': {
                required: true,
                number: true,
                maxlength: 45
            },

            'num_nis': {
                required: true,
                number: true,
                maxlength: 30
            },

            'num_inep': {
                required: true,
                number: true,
                maxlength: 30
            },

            'cgm[nome]': {
                required: true,
                maxlength: 45,
                alphaSpace: true
            },

            'cgm[data_nascimento]': {
                required: true,
                //dateBr: true,
                maxlength: 15

            },

            'cgm[sexo_id]': {
                required: true,
                integer: true
            },

            'cgm[cpf]': {
                //required: true,
                cpfBr: true,
                // maxlength: 15,
                unique: [laroute.route('aluno.searchCpf'), $('#idAluno')]
            },

            'cgm[rg]': {
                //required: true,
                number: true,
                maxlength: 20
            },

            'cgm[pai]': {
                maxlength: 45,
                //required: true,
                alphaSpace: true
            },

            'cgm[mae]': {
                maxlength: 45,
                //required: true,
                alphaSpace: true
            },

            'cgm[email]': {
                email: true,
                maxlength: 45
            },

            'cgm[nacionalidade_id]': {
                integer: true
            },

            'cgm[naturalidade]': {
                required: true,
                alphaSpace: true,
                maxlength: 45
            },

            'telefone[nome]': {
                required: true,
                maxlength: 18
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

            'cgm[endereco][complemento]': {
                //alphaSpace: true,
                maxlength: 100
            },

            'cgm[endereco][cep]': {
                //number: true,
                maxlength: 15
            },

            'cgm[endereco][bairro_id]': {
                required: true,
                integer: true
            },

            estado: {
                required: true,
                integer: true
            },

            cidade: {
                required: true,
                integer: true
            },

            'cgm[endereco][zona_id]': {
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
})