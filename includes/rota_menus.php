<script type="text/javascript">

    //DEFINE O HISTÓRICO DE NAVEGAÇÃO DAS PÁGINAS E INCLUI QUANDO SOLICITADO
    window.onpopstate = function () {
        var linkAtual = window.location.href;
        $(".content").load(linkAtual);
    };

    function Dashboard()
    {
        //ALTERA A URL DO BROWSER
        window.history.pushState("object or string", "Title", "index.php?app_modulo=home&app_comando=home");
        //CARREGA OS DADOS VIA AJAX
        $(".content").load("index.php?app_modulo=home&app_comando=home");
    }

    function Agendamento()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=agendamento&app_comando=exibir_agendamento");
        $(".content").load("index.php?app_modulo=agendamento&app_comando=exibir_agendamento");
    }

    function Cliente()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=cliente&app_comando=listar_cliente");
        $(".content").load("index.php?app_modulo=cliente&app_comando=listar_cliente");
    }

    function Fornecedor()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=fornecedor&app_comando=listar_fornecedor");
        $(".content").load("index.php?app_modulo=fornecedor&app_comando=listar_fornecedor");
    }

    function Produto()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=produto&app_comando=listar_produto");
        $(".content").load("index.php?app_modulo=produto&app_comando=listar_produto");
    }

    function Servico()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=servico&app_comando=listar_servico");
        $(".content").load("index.php?app_modulo=servico&app_comando=listar_servico");
    }

    function FormaPagamento()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=forma_pagamento&app_comando=listar_forma_pagamento");
        $(".content").load("index.php?app_modulo=forma_pagamento&app_comando=listar_forma_pagamento");
    }

    function Manutencao()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=manutencao&app_comando=listar_manutencao");
        $(".content").load("index.php?app_modulo=manutencao&app_comando=listar_manutencao");
    }

    function OrdemServico()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=ordem_servico&app_comando=listar_ordem_servico");
        $(".content").load("index.php?app_modulo=ordem_servico&app_comando=listar_ordem_servico");
    }

    function ContasReceber()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=contas_receber&app_comando=listar_contas_receber");
        $(".content").load("index.php?app_modulo=contas_receber&app_comando=listar_contas_receber");
    }

    function ContasPagar()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=contas_pagar&app_comando=listar_contas_pagar");
        $(".content").load("index.php?app_modulo=contas_pagar&app_comando=listar_contas_pagar");
    }

    function ComparacaoPrecos()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=comparacao_precos&app_comando=listar_comparacao_precos");
        $(".content").load("index.php?app_modulo=comparacao_precos&app_comando=listar_comparacao_precos");
    }

    function RelatorioClientes()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=relatorio_clientes&app_comando=listar_relatorio_clientes");
        $(".content").load("index.php?app_modulo=relatorio_clientes&app_comando=listar_relatorio_clientes");
    }

    function RelatorioManutencoes()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=relatorio_manutencoes&app_comando=listar_relatorio_manutencoes");
        $(".content").load("index.php?app_modulo=relatorio_manutencoes&app_comando=listar_relatorio_manutencoes");
    }

    function RelatorioContasReceber()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=relatorio_contas_receber&app_comando=listar_relatorio_contas_receber");
        $(".content").load("index.php?app_modulo=relatorio_contas_receber&app_comando=listar_relatorio_contas_receber");
    }

    function RelatorioContasPagar()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=relatorio_contas_pagar&app_comando=listar_relatorio_contas_pagar");
        $(".content").load("index.php?app_modulo=relatorio_contas_pagar&app_comando=listar_relatorio_contas_pagar");
    }

    function Usuario()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=usuario&app_comando=listar_usuario");
        $(".content").load("index.php?app_modulo=usuario&app_comando=listar_usuario");
    }

    function EstoqueEntradas()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=estoque_entradas&app_comando=listar_estoque_entradas");
        $(".content").load("index.php?app_modulo=estoque_entradas&app_comando=listar_estoque_entradas");
    }

    function EstoqueGerenciar()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=estoque&app_comando=listar_estoque");
        $(".content").load("index.php?app_modulo=estoque&app_comando=listar_estoque");
    }

    function EstoqueMovimentacao()
    {
        window.history.pushState("object or string", "Title", "index.php?app_modulo=estoque_movimentacao&app_comando=listar_estoque_movimentacao");
        $(".content").load("index.php?app_modulo=estoque_movimentacao&app_comando=listar_estoque_movimentacao");
    }

    //ABRE O FORM DE EDIÇÃO DO PERFIL DO USUÁRIO LOGADO
    function PerfilUsuario()
    {
        DialogFormulario({
            urlConteudo: "index.php?app_modulo=usuario&app_comando=frm_editar_usuario&id="+<?=$_SESSION["id_usuario"]?>,
            titulo:      "Modificar Perfil",
            width:       "60vw",
            closeable:   true,
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-primary btn-salvar",
                btntext:  "Salvar",
                callback: function (event)
                {
                    if (ValidarFormulario($("#form_usuario")))
                    {
                        $.post('index.php?app_modulo=usuario&app_comando=editar_usuario&id='+<?=$_SESSION["id_usuario"]?>,
                            $("#form_usuario").serialize(),
                            function (response)
                            {
                                if (response["codigo"] == 1)
                                {
                                    toastr.success(response["mensagem"], "Sucesso");
                                    event.data.close();
                                }
                                else
                                {
                                    toastr.warning(response["mensagem"], "Aviso");
                                }
                            }, 'json'
                        );
                    }
                }
            }]
        });
    }
</script>