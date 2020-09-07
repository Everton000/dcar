<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarUsuario(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=usuario&app_comando=frm_editar_usuario&id="+id,
            titulo:      "Modificar Usuário",
            width:       "60vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    ExecutarAcaoUsuario(event.data, "index.php?app_modulo=usuario&app_comando=editar_usuario&id="+id);
                }
            }]
        });
    }
</script>
