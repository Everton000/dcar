<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarServico(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=servico&app_comando=frm_editar_servico&id="+id,
            titulo:      "Modificar Servico",
            width:       "40vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoServico(event.data, "index.php?app_modulo=servico&app_comando=editar_servico&id="+id);
                }
            }]
        });
    }
</script>
