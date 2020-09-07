<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarFormaPagamento(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=forma_pagamento&app_comando=frm_editar_forma_pagamento&id="+id,
            titulo:      "Modificar Forma de Pagamento",
            width:       "40vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoFormaPagamento(event.data, "index.php?app_modulo=forma_pagamento&app_comando=editar_forma_pagamento&id="+id);
                }
            }]
        });
    }
</script>
