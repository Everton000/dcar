<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridFormaPagamento();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=forma_pagamento&app_comando=frm_adicionar_forma_pagamento",
                titulo:      "Adicionar Forma de Pagamento",
                width:       "40vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoFormaPagamento(event.data, "index.php?app_modulo=forma_pagamento&app_comando=adicionar_forma_pagamento");
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

            if (id != "") {
                ConfirmModal('Aviso', 'Tem certeza que deseja executar essa ação?', 'Excluir', id);
            } else {
                toastr.warning('Nenhum registro foi selecionado!', 'Atenção');
            }
        });
    });

    function AtualizarGridFormaPagamento(pagina, busca, filtro, ordem)
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

        $("#conteudo_forma_pagamento").load("index.php?app_modulo=forma_pagamento&app_comando=ajax_listar_forma_pagamento", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=forma_pagamento&app_comando=deletar_forma_pagamento&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridFormaPagamento();
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
