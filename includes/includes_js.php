<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 02/10/2018
 * Time: 18:50
 */

require_once "rota_menus.php";
require_once "validacao.php";
require_once "dialog.php";
require_once "autocomplete.php";
require_once "mask.php";
require_once "cep.php";
require_once "cpf.php";
require_once "cnpj.php";
?>

<script type="text/javascript">

    var maskHeight = '300vw';
    var maskWidth = '300vw';

    //FUNÇÃO QUE SELECIONA TODOS OS CHECKBOX
    function AllCheckbox(checkbox)
    {
        $(".checkbox-lis").each(function ()
        {
            if (!($(this).is(':disabled')))
            {
                if ($(checkbox).is(':checked'))
                    $(this).prop('checked', true);
                else
                    $(this).prop('checked', false);
            }
        });
    }

    //CRIA SWICH PERSONALIZADO DO BOOTSTRAP
    function Switch()
    {
        var clickButton = $('.js-switch');
        var x = 0;
        clickButton.each(function () {
            var init = new Switchery(clickButton[x]);

            // Adiciona no elemento criado pelo Switchery, todos os atributos que fazem o tooltip funcionar
            $(init.switcher).attr({
                title: clickButton.attr('title'),
                'data-toggle': clickButton.attr('data-toggle')
            });
            x++;
        });
    }

    //CHECKED OR UNCHECKED SWITCHER
    function CheckedSwitch(el, value)
    {
        if($(el).is(':checked') !== value)
            $(el).trigger("click");
    }

</script>