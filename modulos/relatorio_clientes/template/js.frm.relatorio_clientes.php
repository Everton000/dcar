<script type="text/javascript">

    $(document).ready(function ()
    {
        Mascaras();

        autocomplete("cliente", "id_cliente", "index.php?app_modulo=cliente&app_comando=listar_cliente_json");

        $('#data_inicial').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        }).on('dp.change', function(e) {
            $('#data_final').data("DateTimePicker").minDate(e.date)
        });
        $('#data_final').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });
    });

    function Imprimir(form)
    {
        form.target = '_blank';
        form.action = 'index_pdf.php?app_modulo=relatorio_clientes&app_comando=listar_relatorio_clientes_pdf';
        form.submit();
    }

</script>