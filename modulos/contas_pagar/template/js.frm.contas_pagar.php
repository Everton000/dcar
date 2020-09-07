<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();

        $('#vencimento').datetimepicker({
            format: 'DD/MM/YYYY'
        });
        $('#data_pagamento').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });

        $("#valor").maskMoney({thousands:'.', decimal:',', symbolStay: true});

        $("#status").on('change', function ()
        {
            var div = $("#div_data_pagamento");
            if ($(this).val() === '1')
            {
                div.css('display', 'block');
                $("#data_pagamento").addClass('input-obrigatorio');
            }
            else
            {
                div.css('display', 'none');
                $("#data_pagamento").removeClass('input-obrigatorio');
            }
        });

        if ($("#contas_pagar").val())
        {
            var div = $("#div_data_pagamento");
            if ($("#status").val() === '1')
            {
                div.css('display', 'block');
                $("#data_pagamento").addClass('input-obrigatorio');
            }
            else
            {
                div.css('display', 'none');
                $("#data_pagamento").removeClass('input-obrigatorio');
            }
        }
    });

    function ExecutarAcaoContasPagar(form, url)
    {
        if (ValidarFormulario($("#form_contas_pagar")))
        {
            $.post(url,
                $("#form_contas_pagar").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridContasPagar();
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