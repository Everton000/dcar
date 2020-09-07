<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridServico();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=servico&app_comando=frm_adicionar_servico",
                titulo:      "Adicionar Serviço",
                width:       "45vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoServico(event.data, "index.php?app_modulo=servico&app_comando=adicionar_servico");
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

    function AtualizarGridServico(pagina, busca, filtro, ordem)
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

        $("#conteudo_servico").load("index.php?app_modulo=servico&app_comando=ajax_listar_servico", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=servico&app_comando=deletar_servico&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridServico();
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
