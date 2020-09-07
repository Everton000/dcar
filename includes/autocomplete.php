<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 28/10/2018
 * Time: 16:46
 */
?>

<script type="text/javascript">

    function autocomplete(campo, campoId, url, filtro, funcao)
    {
        $( "#"+campo ).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url: url,
                    dataType: "json",
                    data: {
                        term: request.term,
                        filtro: $(filtro).val()
                    },
                    success: function( data )
                    {
                        if (data.length === 0)
                        {
                            response({label : 'Nenhum Registro Encontrado!'});
                        }
                        else
                        {
                            response(data);
                        }
                    }
                });
            },
            focus: function (event, ui)
            {
                if (ui.item.label !== 'Nenhum Registro Encontrado!')
                {
                    $("#" + campo).val(ui.item.label);
                    $("#" + campoId).val(ui.item.value);
                    if (funcao !== undefined)
                        eval(funcao)(ui.item.param);
                }
                return false;
            },
            select: function (event, ui)
            {
                if (ui.item.label !== 'Nenhum Registro Encontrado!')
                {
                    $("#" + campo).val(ui.item.label);
                    $("#" + campoId).val(ui.item.value);
                    if (funcao !== undefined)
                        eval(funcao)(ui.item.param);
                }
                return false;
            },
            change: function (event, ui)
            {
                if ($("#" + campo).val() === "")
                    $("#" + campoId).val('');
            }
        });
    }

</script>
