<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarContasPagar(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=contas_pagar&app_comando=frm_editar_contas_pagar&id="+id,
            titulo:      "Modificar Contas a Pagar",
            width:       "60vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoContasPagar(event.data, "index.php?app_modulo=contas_pagar&app_comando=editar_contas_pagar&id="+id);
                }
            }]
        });
    }
</script>
