<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridEstoque();

    });

    function AtualizarGridEstoque(pagina, busca, filtro, ordem)
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
            id_status : $("#id_status").val()
        };

        $("#conteudo_estoque").load("index.php?app_modulo=estoque&app_comando=ajax_listar_estoque", post);
    }

</script>
