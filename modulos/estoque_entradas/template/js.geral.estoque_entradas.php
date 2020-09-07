<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridEstoqueEntradas();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=estoque_entradas&app_comando=frm_adicionar_estoque_entradas",
                titulo:      "Adicionar Produto",
                width:       "60vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button' id='btn_salvar'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoEstoqueEntradas(event.data, "index.php?app_modulo=estoque_entradas&app_comando=adicionar_estoque_entradas");
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

    function AtualizarGridEstoqueEntradas(pagina, busca, filtro, ordem)
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

        $("#conteudo_estoque_entradas").load("index.php?app_modulo=estoque_entradas&app_comando=ajax_listar_estoque_entradas", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=estoque_entradas&app_comando=deletar_estoque_entradas&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridEstoqueEntradas();
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
