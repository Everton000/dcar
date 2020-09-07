<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 28/10/2018
 * Time: 16:48
 */
?>

<script type="text/javascript">

    //FUNÇÃO QUE VALIDA CAMPOS OBRIGATÓRIOS DE FORMULÁRIO
    function ValidarFormulario(form)
    {
        var retorno = true;
        $('.invalid-feedback').remove();
        $('.valid-feedback').remove();

        //VALIDA INPUT
        form.find(".input-obrigatorio").each(function ()
        {
//            console.log($(this).parent('input:not(.hidden)'));
            var input = $(this).parent().find('input:not(.hidden)');
            var valor = $(this).val();
            var divError = $(this).parent();

            if (valor === "")
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback">Obrigatório!</div>');
                retorno = false;
            }
            else
            {
                input.removeClass('is-invalid');
            }
        });
        //VALIDA SELECT
        form.find(".select-obrigatorio").each(function ()
        {
            var input = $(this);
            var valor = $(this).val();
            var divError = $(this).parent();

            if (valor === "")
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback">Obrigatório!</div>');
                retorno = false;
            }
            else
            {
                input.removeClass('is-invalid');
            }
        });

        //VALIDA INPUT MONEY
        form.find(".input-money-obrigatorio").each(function ()
        {
            var input = $(this);
            var valor = $(this).val();
            var divError = $(this).parent();

            if (valor == "0,00")
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback">Obrigatório!</div>');
                retorno = false;
            }
            else
            {
                input.removeClass('is-invalid');
            }
        });

        //VALIDA INPUT SENHA
        form.find(".confirma-senha-obrigatorio").each(function ()
        {
            var valorConfirmaSenha = $("#confirma_senha").val();
            var valorSenha = $("#senha").val();
            var confirmaSenha = $("#confirma_senha");
            var senha = $("#senha");
            var divConfirmaSenha = $("#confirma_senha").parent();
            var divSenha = $("#senha").parent();

            senha.removeClass('is-invalid');
            senha.removeClass('is-valid');
            confirmaSenha.removeClass('is-invalid');
            confirmaSenha.removeClass('is-valid');

            if (valorSenha === "")
            {
                senha.addClass('is-invalid');
                divSenha.append('<div class="invalid-feedback invalid-senha">Obrigatório!</div>');
                retorno = false;
            }
            if (valorConfirmaSenha === "")
            {
                confirmaSenha.addClass('is-invalid');
                divConfirmaSenha.append('<div class="invalid-feedback invalid-senha">Obrigatório!</div>');
                retorno = false;
            }
            else if (valorConfirmaSenha !== valorSenha && valorSenha !== "" && valorConfirmaSenha !== "")
            {
                confirmaSenha.addClass('is-invalid');
                divConfirmaSenha.append('<div class="invalid-feedback invalid-senha">As senhas são diferentes!</div>');
                retorno = false;
            }
            else if (valorConfirmaSenha === valorSenha)
            {
                senha.addClass('is-valid');
                divSenha.append('<div class="valid-feedback valid-senha">Válido!</div>');
                confirmaSenha.addClass('is-valid');
                divConfirmaSenha.append('<div class="valid-feedback valid-senha">Válido!</div>');
            }
        });

        //VALIDA EMAIL
        form.find(".email-obrigatorio").each(function ()
        {
            var input = $(this);
            var valor = $(this).val();
            var div = $(this).parent();

            if (valor === "")
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-email">Obrigatório!</div>');
                retorno = false;
            }
            else if(!(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test(valor))
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-email">Formato Inválido!</div>');
                retorno = false;
            }
            else
            {
                input.removeClass('is-invalid');
                input.addClass('is-valid');
                div.append('<div class="valid-feedback valid-email">Válido!</div>');
            }
        });

        //VALIDA CPF
        form.find(".cpf-obrigatorio").each(function ()
        {
            var input = $(this);
            var div = $(this).parent();
            var valorCampo = $(this).val();
            var result = TestaCPF(valorCampo);

            $('.invalid-cpf').remove();
            $('.valid-cpf').remove();

            if (valorCampo === "")
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-cpf">Obrigatório!</div>');
                retorno = false;
            }
            else if (result === true)
            {
                input.removeClass('is-invalid');
                input.addClass('is-valid');
                div.append('<div class="valid-feedback valid-cpf">Válido!</div>');
            }
            else
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-cpf">CPF Inválido!</div>');
                retorno = false;
            }
        });

        //VALIDA CNPJ
        form.find(".cnpj-obrigatorio").each(function ()
        {
            var input = $(this);
            var div = $(this).parent();
            var valorCampo = $(this).val();
            var result = TestaCNPJ(valorCampo);

            $('.invalid-cnpj').remove();
            $('.valid-cnpj').remove();

            if (valorCampo === "")
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-cnpj">Obrigatório!</div>');
                retorno = false;
            }
            else if (result === true)
            {
                input.removeClass('is-invalid');
                input.addClass('is-valid');
                div.append('<div class="valid-feedback valid-cnpj">Válido!</div>');
            }
            else
            {
                input.addClass('is-invalid');
                div.append('<div class="invalid-feedback invalid-cnpj">CNPJ Inválido!</div>');
                retorno = false;
            }
        });

        //VALIDA PLACA
        form.find(".placa-obrigatorio").each(function ()
        {
            var input = $(this);
            var valor = $(this).val();
            var divError = $(this).parent();

            if (valor === "")
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback">Obrigatório!</div>');
                retorno = false;
            }
            else if (valor.length < 7)
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback">Formato Inválido!</div>');
                retorno = false;
            }
            else
            {
                input.removeClass('is-invalid');
            }
        });

        return retorno;
    }

    function validarEmail(email)
    {
        var input = $(email);
        var valor = $(email).val();
        var div = $(email).parent();

        $('.invalid-email').remove();
        $('.valid-email').remove();

        if(!(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i).test(valor))
        {
            input.addClass('is-invalid');
            div.append('<div class="invalid-feedback invalid-email">Formato Inválido!</div>');
            retorno = false;
        }
        else
        {
            input.removeClass('is-invalid');
            input.addClass('is-valid');
            div.append('<div class="valid-feedback valid-email">Válido!</div>');
        }
    }

    function ValidarCpf(campo)
    {
        var input = $(campo);
        var div = $(campo).parent();
        var valorCampo = $(campo).val();
        var retorno = TestaCPF(valorCampo);

        $('.invalid-cpf').remove();
        $('.valid-cpf').remove();

        if (retorno === true)
        {
            input.removeClass('is-invalid');
            input.addClass('is-valid');
            div.append('<div class="valid-feedback valid-cpf">Válido!</div>');
        }
        else
        {
            input.addClass('is-invalid');
            div.append('<div class="invalid-feedback invalid-cpf">CPF Inválido!</div>');
        }
    }

    function ValidarCnpj(campo)
    {
        var input = $(campo);
        var div = $(campo).parent();
        var valorCampo = $(campo).val();
        var retorno = TestaCNPJ(valorCampo);

        $('.invalid-cnpj').remove();
        $('.valid-cnpj').remove();

        if (retorno === true)
        {
            input.removeClass('is-invalid');
            input.addClass('is-valid');
            div.append('<div class="valid-feedback valid-cnpj">Válido!</div>');
        }
        else
        {
            input.addClass('is-invalid');
            div.append('<div class="invalid-feedback invalid-cnpj">CNPJ Inválido!</div>');
        }
    }

</script>
