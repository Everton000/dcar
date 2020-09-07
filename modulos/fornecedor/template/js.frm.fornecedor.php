<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();
        Mascaras();

        if ($("#id_fornecedor").val() === '')
            CheckedSwitch($("#ativo"), true);
    });

    function ExecutarAcaoFornecedor(form, url)
    {
        if (ValidarFormulario($("#form_fornecedor")))
        {
            $.post(url,
                $("#form_fornecedor").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridFornecedor();
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

</script>