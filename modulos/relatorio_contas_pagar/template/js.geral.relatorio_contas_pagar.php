<script type="text/javascript">

    $(document).ready(function ()
    {
        $('#data_inicial, #data_final').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('vencimento').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        AtualizarGridRelatorioContasPagar();
    });

    function AtualizarGridRelatorioContasPagar(pagina, busca, filtro, ordem)
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

            id_categoria : $("#id_categoria").val(),
            vencimento : $("#vencimento").val(),
            valor : $("#valor").val(),
            id_status : $("#id_status").val(),
            data_inicial : $("#data_inicial").val(),
            data_final : $("#data_final").val(),

            pagar : $("#pagar").val(),
            pagas : $("#pagas").val()
        };

        $("#conteudo_relatorio_contas_pagar").load("index.php?app_modulo=relatorio_contas_pagar&app_comando=ajax_listar_relatorio_contas_pagar", post);
    }

</script>
