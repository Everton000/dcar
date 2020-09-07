<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();

        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();

        //QUANDO ESTIVER EDITANDO UM USUÁRIO É REMOVIDO A OBRIGATORIEDADE DOS CAMPOS DE SENHA
        if ($("#id_usuario").val())
        {
            $("#confirma_senha").removeClass("confirma-senha-obrigatorio");
        }
    });

    function ExecutarAcaoUsuario(form, url)
    {
        if (ValidarFormulario($("#form_usuario")))
        {
            $.post(url,
                $("#form_usuario").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridUsuario();
                        toastr.success(response["mensagem"], "Sucesso");
                        form.close();
                    }
                    else {
                        toastr.warning(response["mensagem"], "Aviso");
                    }
                }, 'json'
            );
        }
    }

    function validarSenha()
    {
        var valorConfirmaSenha = $("#confirma_senha").val();
        var valorSenha = $("#senha").val();
        var confirmaSenha = $("#confirma_senha");
        var senha = $("#senha");
        var divConfirmaSenha = $("#confirma_senha").parent();
        var divSenha = $("#senha").parent();

        $('.invalid-senha').remove();
        $('.valid-senha').remove();

        senha.removeClass('is-invalid');
        senha.removeClass('is-valid');
        confirmaSenha.removeClass('is-invalid');
        confirmaSenha.removeClass('is-valid');

        //OBRIGATÓRIO
        if (valorSenha === "")
        {
            senha.addClass('is-invalid');
            divSenha.append('<div class="invalid-feedback invalid-senha">Obrigatório!</div>');
        }
        if (valorConfirmaSenha === "")
        {
            confirmaSenha.addClass('is-invalid');
            divConfirmaSenha.append('<div class="invalid-feedback invalid-senha">Obrigatório!</div>');
        }
        else if (valorConfirmaSenha !== valorSenha && valorSenha !== "" && valorConfirmaSenha !== "")
        {
            confirmaSenha.addClass('is-invalid');
            divConfirmaSenha.append('<div class="invalid-feedback invalid-senha">As senhas são diferentes!</div>');
        }
        else if (valorConfirmaSenha === valorSenha)
        {
            senha.addClass('is-valid');
            divSenha.append('<div class="valid-feedback valid-senha">Válido!</div>');
            confirmaSenha.addClass('is-valid');
            divConfirmaSenha.append('<div class="valid-feedback valid-senha">Válido!</div>');
        }
    }
</script>