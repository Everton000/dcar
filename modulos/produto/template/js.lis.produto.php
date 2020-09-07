<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarProduto(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=produto&app_comando=frm_editar_produto&id="+id,
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
                    ExecutarAcaoProduto(event.data, "index.php?app_modulo=produto&app_comando=editar_produto&id="+id);
                }
            }]
        });
    }
</script>
