<script type="text/javascript">

    $(document).ready(function ()
    {
        autocomplete("cliente", "id_cliente", "index.php?app_modulo=cliente&app_comando=listar_cliente_json");

        $('#data_inicial, #data_final').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $('#data_garantia, #data_vencimento').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        $("#cliente").on('change',function(){
           if ($(this).val() == '')
               $("#id_cliente").val('');
        });


    });

</script>