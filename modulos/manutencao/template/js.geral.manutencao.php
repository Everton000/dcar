<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridManutencao();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=manutencao&app_comando=frm_adicionar_manutencao",
                titulo:      "Adicionar Manutencão",
                width:       "65vw",
                ofset:       "10",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button' id='btn_salvar' style='display: none'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoManutencao(event.data, "index.php?app_modulo=manutencao&app_comando=adicionar_manutencao");
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
            }, true);
        });


        $("#excluir").click(function ()
        {
            var id = [];
            var x = 0;

            $(".checkbox-lis").each(function ()
            {
                if ($(this).is(":checked") === true)
                {
                    id[x] = $(this).val();
                    x++;
                }
            });

            if (id != "")
            {
                $.post('index.php?app_modulo=manutencao&app_comando=validar_exclusao&id='+id,
                    function (response)
                    {
                        if(response['codigo'] == 1)
                        {
                            ConfirmModal('Aviso', 'Tem certeza que deseja executar essa ação?', 'Excluir', id);
                        }
                        else
                        {
                            Alerta('Atenção', response['mensagem']);
                        }
                    }, "json"
                );

            } else {
                toastr.warning('Nenhum registro foi selecionado!', 'Atenção');
            }
        });
    });

    function AtualizarGridManutencao(pagina, busca, filtro, ordem)
    {
        if (pagina === undefined) pagina = "";
        if (ordem === undefined)  ordem = "";
        if (busca === undefined)  busca = "";
        if (filtro === undefined) filtro = "";

        var post = {
            pagina : pagina,
            busca  : busca,
            filtro : filtro,
            ordem : ordem
        };

        $("#conteudo_manutencao").load("index.php?app_modulo=manutencao&app_comando=ajax_listar_manutencao", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=manutencao&app_comando=deletar_manutencao&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridManutencao();
                    toastr.success(response["mensagem"], "Sucesso");
                }
                else
                {
                    toastr.warning(response["mensagem"], "Erro");
                }
            }, "json"
        );
    }

</script>
