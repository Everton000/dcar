<script type="text/javascript">
    $(document).ready(function ()
    {
        Switch();
        Mascaras();

        $("#valor").maskMoney({thousands:'.', decimal:',', symbolStay: true});

        autocomplete("fornecedor", "id_fornecedor", "index.php?app_modulo=produto&app_comando=listar_fornecedor_json");
    });

    function ExecutarAcaoProduto(form, url)
    {
        if (ValidarFormulario($("#form_produto")))
        {
            $.post(url,
                $("#form_produto").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridProduto();
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