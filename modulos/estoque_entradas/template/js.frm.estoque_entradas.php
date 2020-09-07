<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:25
 */
?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        idVeiculo = 0;
        Mascaras();
        Switch();

        $("#valor").maskMoney({thousands:'.', decimal:',', symbolStay: true});

        autocomplete("produto", "id_produto", "index.php?app_modulo=produto&app_comando=listar_produto_json", '', 'AtualizarValor');

        $("#quantidade").on('change', function ()
        {
            if ($("#valor").val() !== '0,00')
            {
                var quantidade = parseInt($("#quantidade").val());
                var campoValor = parseFloat($("#valor").val().replace(',', '.'));
                campoValor = (campoValor).toFixed(2);
                var campoValorTotal = (campoValor * quantidade).toFixed(2);

                $("#valor_total").val(campoValorTotal.replace('.', ','));
            }
        });
    });

    function ExecutarAcaoEstoqueEntradas(form, url)
    {
        if (ValidarFormulario($("#form_estoque_entradas")))
        {
            $.post(url,
                $("#form_estoque_entradas").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridEstoqueEntradas();
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

    function AtualizarValor(valor)
    {
        if ($("#quantidade").val() == '')
            $("#quantidade").val(1);

        var quantidade = parseInt($("#quantidade").val());
        var campoValor = parseFloat(valor.replace(',', '.'));
        campoValor = (campoValor).toFixed(2);
        var campoValorTotal = (campoValor * quantidade).toFixed(2);

        $("#valor").val(campoValor.replace('.', ','));
        $("#valor_total").val(campoValorTotal.replace('.', ','));
    }
</script>
