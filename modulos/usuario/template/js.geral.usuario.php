<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridUsuario();

        $("#adicionar").click(function ()
        {
            DialogFormulario({
                urlConteudo: "index.php?app_modulo=usuario&app_comando=frm_adicionar_usuario",
                titulo:      "Adicionar Usuário",
                width:       "60vw",
                closeable:   true,
                botoes:      [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-primary btn-salvar",
                    btntext:  "Salvar",
                    callback: function (event)
                    {
                        ExecutarAcaoUsuario(event.data, "index.php?app_modulo=usuario&app_comando=adicionar_usuario");
                    }
                }]
            });
        });

        $("#excluir").click(function ()
        {
            var idUsuario = [];
            var x = 0;

            $(".checkbox-lis").each(function ()
            {
                if ($(this).is(":checked") === true)
                {
                    idUsuario[x] = $(this).val();
                    x++;
                }
            });

            if (idUsuario != "") {
                ConfirmModal('Aviso', 'Tem certeza que deseja executar essa ação?', 'Excluir', idUsuario);
            } else {
                toastr.warning('Nenhum registro foi selecionado!', 'Atenção');
            }
        });
    });

    function AtualizarGridUsuario(pagina, busca, filtro, ordem)
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

        $("#conteudo_usuario").load("index.php?app_modulo=usuario&app_comando=ajax_listar_usuario", post);
    }

    function Excluir(id)
    {
        $.post("index.php?app_modulo=usuario&app_comando=deletar_usuario&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridUsuario();
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
