<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:21
 */
?>
<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarEstoqueEntradas(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=estoque_entradas&app_comando=frm_editar_estoque_entradas&id="+id,
            titulo:      "Modificar Produto",
            width:       "60vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoEstoqueEntradas(event.data, "index.php?app_modulo=estoque_entradas&app_comando=editar_estoque_entradas&id="+id);
                }
            }]
        });
    }

</script>
