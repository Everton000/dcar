<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 04:26
 */
?>
<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarAgendamento(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=agendamento&app_comando=frm_editar_agendamento&id="+id,
            titulo:      "Modificar Agendamento",
            width:       "65vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoAgendamento(event.data, "index.php?app_modulo=agendamento&app_comando=editar_agendamento&id="+id, true);
                }
            }]
        });
    }
</script>

