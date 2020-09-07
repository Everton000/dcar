<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridEstoqueMovimentacao();

    });

    function AtualizarGridEstoqueMovimentacao(pagina, busca, filtro, ordem)
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
            id_produto : $("#id_produto").val(),
            id_fornecedor : $("#id_fornecedor").val(),
            data_inicial : $("#data_inicial").val(),
            data_final   : $("#data_final").val()
        };

        $("#conteudo_estoque_movimentacao").load("index.php?app_modulo=estoque_movimentacao&app_comando=ajax_listar_estoque_movimentacao", post);
    }

</script>
