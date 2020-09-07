<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridOrdemServico();
    });

    function AtualizarGridOrdemServico(pagina, busca, filtro, ordem)
    {
        if (pagina === undefined) pagina = "";
        if (ordem === undefined)  ordem = "";
        if (busca === undefined)  busca = "";
        if (filtro === undefined) filtro = "";

        var post = {
            pagina : pagina,
            busca  : busca,
            filtro : filtro,
            ordem : ordem
        };

        $("#conteudo_ordem_servico").load("index.php?app_modulo=ordem_servico&app_comando=ajax_listar_ordem_servico", post);
    }

</script>