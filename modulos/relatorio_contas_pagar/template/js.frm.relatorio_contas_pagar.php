<script type="text/javascript">

    $(document).ready(function ()
    {
        Mascaras();

        autocomplete("id_categoria", "id_status", "index.php?app_modulo=contas_pagar&app_comando=listar_contas_pagar_json");

        $('#data_inicial').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        }).on('dp.change', function(e) {
            $('#data_final').data("DateTimePicker").minDate(e.date)
        });
        $('#data_final').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });

        $('#vencimento, #data_pagamento').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });

    function Imprimir(form)
    {
        form.target = '_blank';
        form.action = 'index_pdf.php?app_modulo=relatorio_contas_pagar&app_comando=listar_relatorio_contas_pagar_pdf';
        form.submit();
    }

</script>