<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarFornecedor(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=fornecedor&app_comando=frm_editar_fornecedor&id="+id,
            titulo:      "Modificar Fornecedor",
            width:       "65vw",
            closeable:   true,
            botoes:      [{
                 item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoFornecedor(event.data, "index.php?app_modulo=fornecedor&app_comando=editar_fornecedor&id="+id);
                }
            }]
        });
    }
</script>
