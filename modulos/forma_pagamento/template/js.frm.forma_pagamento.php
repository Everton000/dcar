<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();
    });

    function ExecutarAcaoFormaPagamento(form, url)
    {
        if (ValidarFormulario($("#form_forma_pagamento")))
        {
            $.post(url,
                $("#form_forma_pagamento").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridFormaPagamento();
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