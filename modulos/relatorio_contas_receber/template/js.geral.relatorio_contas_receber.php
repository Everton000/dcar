<script type="text/javascript">

    $(document).ready(function ()
    {
        $('#data_inicial, #data_final').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#data_garantia, #data_vencimento').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        AtualizarGridRelatorioContasReceber();
    });

    function AtualizarGridRelatorioContasReceber(pagina, busca, filtro, ordem)
    {
        if (pagina === undefined) pagina = "";
        if (ordem === undefined)  ordem = "";
        if (busca === undefined)  busca = "";
        if (filtro === undefined) filtro = "";

        var post = {
            pagina : pagina,
            busca  : busca,
            filtro : filtro,
            ordem : ordem,
            id_cliente : $("#id_cliente").val(),
            numero_fatura : $("#numero_fatura").val(),
            forma_pagamento : $("#forma_pagamento").val(),
            data_inicial : $("#data_inicial").val(),
            data_final : $("#data_final").val(),
            data_vencimento : $("#data_vencimento").val(),
            receber : $("#receber").val(),
            recebidas : $("#recebidas").val()
        };

        $("#conteudo_relatorio_contas_receber").load("index.php?app_modulo=relatorio_contas_receber&app_comando=ajax_listar_relatorio_contas_receber", post);
    }

</script>
