<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridCliente();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=cliente&app_comando=frm_adicionar_cliente",
                titulo:      "Adicionar Cliente",
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
                        ExecutarAcaoCliente(event.data, "index.php?app_modulo=cliente&app_comando=adicionar_cliente");
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
                $.post('index.php?app_modulo=cliente&app_comando=validar_exclusao&id='+id,
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

    function AtualizarGridCliente(pagina, busca, filtro, ordem)
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

        $("#conteudo_cliente").load("index.php?app_modulo=cliente&app_comando=ajax_listar_cliente", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=cliente&app_comando=deletar_cliente&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridCliente();
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
