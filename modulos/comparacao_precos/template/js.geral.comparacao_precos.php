<script type="text/javascript">

    $(document).ready(function ()
    {
    });

    function AtualizarGridComparacaoPrecos(pagina, busca, filtro, ordem)
    {
        if (ValidarFormulario($("#form_comparacao")))
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
                codigo : $("#codigo").val()
            };

            $("#grafico").load("index.php?app_modulo=comparacao_precos&app_comando=listar_grafico");
            $("#conteudo_comparacao_precos").load("index.php?app_modulo=comparacao_precos&app_comando=ajax_listar_comparacao_precos", post);
        }
    }

</script>
