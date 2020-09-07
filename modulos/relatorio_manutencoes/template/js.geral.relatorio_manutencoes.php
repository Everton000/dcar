<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridRelatorioManutencoes();
    });

    function AtualizarGridRelatorioManutencoes(pagina, busca, filtro, ordem)
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
            id_veiculo : $("#id_veiculo").val(),
            numero_os : $("#numero_os").val(),
            data_inicial : $("#data_inicial").val(),
            data_final   : $("#data_final").val()
        };

        $("#conteudo_relatorio_manutencoes").load("index.php?app_modulo=relatorio_manutencoes&app_comando=ajax_listar_relatorio_manutencoes", post);
    }

</script>
