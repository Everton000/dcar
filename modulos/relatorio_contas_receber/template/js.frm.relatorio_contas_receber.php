<script type="text/javascript">

    $(document).ready(function ()
    {
        Switch();
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

        $("#receber").on('change', function ()
        {
            if ($(this).is(':checked'))
                $(this).val(1);
            else
                $(this).val(0);

            if (!$("#recebidas").is(':checked'))
                CheckedSwitch(this, true);
        });

        $("#recebidas").on('change', function ()
        {
            if ($(this).is(':checked'))
                $(this).val(1);
            else
                $(this).val(0);

            if (!$("#receber").is(':checked'))
               CheckedSwitch(this, true);
        });
    });

    function Imprimir(form)
    {
        form.target = '_blank';
        form.action = 'index_pdf.php?app_modulo=relatorio_contas_receber&app_comando=listar_relatorio_contas_receber_pdf';
        form.submit();
    }

</script>