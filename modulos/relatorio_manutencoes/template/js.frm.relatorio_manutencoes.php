<script type="text/javascript">

    $(document).ready(function ()
    {
        Mascaras();

        autocomplete("cliente", "id_cliente", "index.php?app_modulo=cliente&app_comando=listar_cliente_json");

        autocomplete("veiculo", "id_veiculo", "index.php?app_modulo=veiculo&app_comando=listar_veiculo_json", $("#id_cliente"));

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
        form.action = 'index_pdf.php?app_modulo=relatorio_manutencoes&app_comando=listar_relatorio_manutencoes_pdf';
        form.submit();
    }

</script>