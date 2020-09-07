<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:25
 */
?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        idVeiculo = 0;
        Mascaras();
        Switch();

        $('#data_inicial, #data_final').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        autocomplete("produto", "id_produto", "index.php?app_modulo=produto&app_comando=listar_produto_json");

        autocomplete("fornecedor", "id_fornecedor", "index.php?app_modulo=produto&app_comando=listar_fornecedor_json");

    });

</script>
