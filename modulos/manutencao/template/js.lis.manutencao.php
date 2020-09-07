<script type="text/javascript">

    $(document).ready(function ()
    {
        //CRIA O TOOLTIP DO BOOSTRAP EM TODOS OS ELEMENTOS COM O ATRIBUTO DATA-TOGGLE="TOOLTIP"
        $('[data-toggle="tooltip"]').tooltip();
    });

    function ModificarManutencao(id)
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=manutencao&app_comando=frm_editar_manutencao&id="+id,
            titulo:      "Modificar Manutenção",
            width:       "65vw",
            closeable:   true,
            ofset:       '10',
            botoes:      [{
                item:     "<button type='button' id='btn_salvar' style='display: none'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    var idClienteVeiculo = $("#id_cliente_veiculo").val();
                    ExecutarAcaoManutencao(event.data, "index.php?app_modulo=manutencao&app_comando=editar_manutencao&id="+id+"&id_cliente_veiculo="+idClienteVeiculo);
                }
            },
                {
                    item:     "<button type='button' id='btn_proximo'></button>",
                    event:    "click",
                    btnclass: "btn btn-info btn-salvar",
                    btntext:  "Próximo",
                    callback: function ()
                    {
                        if ($("#nav").val() === "0")
                        {
                            if (ValidarFormulario($("#form_os")))
                            {
                                if ($(".id_servico").val())
                                {
                                    $("#tab_os").addClass('disabled');
                                    $("#tab_financeiro").addClass('disabled');
                                    $("#tab_produto").removeClass('disabled');
                                    $("#myTab a:eq(1)").tab('show');
                                    $("#nav").val("1");
                                    $("#btn_anterior").css('display', 'inline');
                                }
                                else
                                {
                                    toastr.warning('Por favor, selecione ao menos um serviço.', "Atenção");
                                }
                            }
                        }
                        else if ($("#nav").val() === "1")
                        {
                            if (ValidarFormulario($("#form_produto")))
                            {
                                $("#tab_os").addClass('disabled');
                                $("#tab_produto").addClass('disabled');
                                $("#tab_financeiro").removeClass('disabled');
                                $("#myTab a:eq(2)").tab('show');
                                $("#nav").val("2");
                                $("#btn_proximo").css('display', 'none');
                                $("#btn_salvar").css('display', 'inline');
                                $("#btn_anterior").css('display', 'inline');
                            }
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
                        if ($("#nav").val() === "1")
                        {
                            $("#tab_produto").addClass('disabled');
                            $("#tab_financeiro").addClass('disabled');
                            $("#tab_os").removeClass('disabled');
                            $("#myTab a:eq(0)").tab('show');
                            $("#nav").val("0");
                            $("#btn_anterior").css('display', 'none');
                        }
                        else if ($("#nav").val() === "2")
                        {
                            $("#tab_os").addClass('disabled');
                            $("#tab_financeiro").addClass('disabled');
                            $("#tab_produto").removeClass('disabled');
                            $("#myTab a:eq(1)").tab('show');
                            $("#nav").val("1");
                        }
                        $("#btn_proximo").css('display', 'inline');
                        $("#btn_salvar").css('display', 'none');
                    }
                }]
        });
    }

    function ImprimirOs(idOs)
    {
        window.open('index_pdf.php?app_modulo=ordem_servico&app_comando=imprimir_os&numero_os='+idOs);
    }

</script>
