<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarCliente(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=cliente&app_comando=frm_editar_cliente&id="+id,
            titulo:      "Modificar Cliente",
            width:       "65vw",
            height:      "38vw",
            closeable:   true,
            ofset:       '10',
            botoes:      [{
                item:     "<button type='button' id='btn_salvar' style='display: none'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                        ExecutarAcaoCliente(event.data, "index.php?app_modulo=cliente&app_comando=editar_cliente&id="+id);
                }
            },
                {
                    item:     "<button type='button' id='btn_proximo'></button>",
                    event:    "click",
                    btnclass: "btn btn-info btn-salvar",
                    btntext:  "Próximo",
                    callback: function ()
                    {
                        if (ValidarFormulario($("#div_cliente")))
                        {
                            $("#tab_cliente").addClass('disabled');
                            $("#tab_veiculo").removeClass('disabled');
                            $("#myTab a:eq(1)").tab('show');
                            $("#btn_anterior").css('display', 'inline');
                            $("#btn_salvar").css('display', 'inline');
                            $("#btn_proximo").css('display', 'none');
                        }
                    }
                },
                {
                    item:     "<button type='button' id='btn_anterior' style='display: none'></button>",
                    event:    "click",
                    btnclass: "btn btn-info btn-salvar",
                    btntext:  "Anterior",
                    callback: function ()
                    {

                        $("#tab_veiculo").addClass('disabled');
                        $("#tab_cliente").removeClass('disabled');
                        $("#myTab a:eq(0)").tab('show');
                        $("#btn_anterior").css('display', 'none');
                        $("#btn_proximo").css('display', 'inline');
                        $("#btn_salvar").css('display', 'none');
                    }
                }]
        });
    }
</script>
