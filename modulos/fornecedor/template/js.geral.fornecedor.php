<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridFornecedor();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=fornecedor&app_comando=frm_adicionar_fornecedor",
                titulo:      "Adicionar Fornecedor",
                width:       "65vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoFornecedor(event.data, "index.php?app_modulo=fornecedor&app_comando=adicionar_fornecedor");
                    }
                }]
            });
        });

        $("#excluir").click(function ()
        {
            var idFornecedor = [];
            var x = 0;

            $(".checkbox-lis").each(function ()
            {
                if ($(this).is(":checked") === true)
                {
                    idFornecedor[x] = $(this).val();
                    x++;
                }
            });

            if (idFornecedor != "")
            {
                $.post('index.php?app_modulo=fornecedor&app_comando=validar_exclusao&id='+idFornecedor,
                    function (response)
                    {
                        if(response['codigo'] == 1)
                        {
                            ConfirmModal('Aviso', 'Tem certeza que deseja excluir esse(s) Fornecedores(s)?', 'Excluir', idFornecedor);
                        }
                        else
                        {
                            Alerta('Atenção', response['mensagem']);
                        }
                    }, "json"
                );
            } else {
                toastr.warning('Nenhum registro foi selecionado.', 'Atenção');
            }
        });
    });

    function AtualizarGridFornecedor(pagina, busca, filtro, ordem)
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

        $('#conteudo_fornecedor').load('index.php?app_modulo=fornecedor&app_comando=ajax_listar_fornecedor', post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=fornecedor&app_comando=deletar_fornecedor&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridFornecedor();
                    toastr.success(response["mensagem"], "Sucesso");
                }
                else
                {
                    toastr.warning(response["mensagem"], "Alerta");
                }
            }, "json"
        );
    }
</script>