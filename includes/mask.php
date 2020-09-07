<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 18/10/2018
 * Time: 20:09
 */
?>
<script type="text/javascript">

function Mascaras()
{
    $('.mask-date-time').mask('99/99/9999 99:99');
    $('.mask-date').mask('99/99/9999');
    $('.mask-cpf').mask('999.999.999-99', {placeholder: '', clearIfNotMatch : false});
    $('.mask-cnpj').mask('99.999.999/9999-99', {placeholder: ''});
    $(".mask-cep").mask("99.999-999", {placeholder: '', clearIfNotMatch : false});
    $(".mask-numero").mask("9#", {clearIfNotMatch : false});
    $(".mask-parcelas").mask("99", {clearIfNotMatch : false});
    $('.mask-km').maskMoney({ decimal: ',', thousands: '.', precision: 0 });

    $('.mask-telefone').focusout(function(){
        var phone, element;
        element = $(this);
        element.unmask();
        phone = element.val().replace(/\D/g, '');
        if(phone.length > 10) {
            element.mask("(99) 99999-9999");
        } else {
            element.mask("(99) 9999-99999");
        }
    }).trigger('focusout');

    $(".mask-ano").mask("9999", {placeholder: ''});
    $(".mask-uf").mask("SS", {placeholder: ''});
    $(".mask-letras").on("keyup", function() {
        this.value = this.value.replace(/[^a-zA-Z]/g,'');
    });
    $(".mask-placa").on("keyup", function()
    {
        var _this = $(this).val();
        if (_this.replace(/[^a-zA-Z]/g,'').length <= 3 && _this.replace(/[^0-9]/g,'').length <= 4)
            this.value = _this.replace(/[^a-zA-Z0-9]/g,'').toUpperCase();
        else
            this.value = _this.substr(0, (_this.length - 1)).toUpperCase();
    });
}

</script>
