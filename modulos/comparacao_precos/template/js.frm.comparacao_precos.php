<script type="text/javascript">

    $(document).ready(function ()
    {
        Mascaras();

        autocomplete("fornecedor", "id_fornecedor", "index.php?app_modulo=produto&app_comando=listar_fornecedor_json");

        autocomplete("produto", "id_produto", "index.php?app_modulo=produto&app_comando=listar_produto_json", '');


    });

    function Imprimir(form)
    {
        form.target = '_blank';
        form.action = 'index_pdf.php?app_modulo=relatorio_manutencoes&app_comando=listar_relatorio_manutencoes_pdf';
        form.submit();
    }

</script>