<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridRelatorioClientes();
    });

    function AtualizarGridRelatorioClientes(pagina, busca, filtro, ordem)
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
            cidade : $("#cidade").val(),
            bairro : $("#bairro").val(),
            estado : $("#estado").val(),
            status : $("#status").val(),
            data_inicial : $("#data_inicial").val(),
            data_final   : $("#data_final").val()
        };

        $("#conteudo_relatorio_clientes").load("index.php?app_modulo=relatorio_clientes&app_comando=ajax_listar_relatorio_clientes", post);
    }

</script>
