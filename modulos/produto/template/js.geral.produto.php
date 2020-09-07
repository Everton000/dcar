<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridProduto();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=produto&app_comando=frm_adicionar_produto",
                titulo:      "Adicionar Produto",
                width:       "60vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoProduto(event.data, "index.php?app_modulo=produto&app_comando=adicionar_produto");
                    }
                }]
            });
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
                $.post('index.php?app_modulo=produto&app_comando=validar_exclusao&id='+id,
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

    function AtualizarGridProduto(pagina, busca, filtro, ordem)
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

        $("#conteudo_produto").load("index.php?app_modulo=produto&app_comando=ajax_listar_produto", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=produto&app_comando=deletar_produto&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridProduto();
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
