<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridContasPagar();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=contas_pagar&app_comando=frm_adicionar_contas_pagar",
                titulo:      "Adicionar Contas a Pagar",
                width:       "60vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoContasPagar(event.data, "index.php?app_modulo=contas_pagar&app_comando=adicionar_contas_pagar");
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

    function AtualizarGridContasPagar(pagina, busca, filtro, ordem)
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

        $("#conteudo_contas_pagar").load("index.php?app_modulo=contas_pagar&app_comando=ajax_listar_contas_pagar", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=contas_pagar&app_comando=deletar_contas_pagar&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridContasPagar();
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
