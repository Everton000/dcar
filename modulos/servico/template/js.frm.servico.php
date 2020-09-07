<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();

        $("#valor").maskMoney({thousands:'.', decimal:',', symbolStay: true});

    });

    function ExecutarAcaoServico(form, url)
    {
        if (ValidarFormulario($("#form_servico")))
        {
            $.post(url,
                $("#form_servico").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridServico();
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