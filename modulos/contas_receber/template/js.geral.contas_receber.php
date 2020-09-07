<script type="text/javascript">

    $(document).ready(function ()
    {
        AtualizarGridContasReceber();

        $("#enviar_email_cobranca").click(function ()
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
                ConfirmModal('Aviso', 'Tem certeza que deseja enviar e-mail(s) de cobrança?', 'EnviarEmailCobranca', id);
            } else {
                toastr.warning('Nenhum registro foi selecionado!', 'Atenção');
            }
        });
    });

    function EnviarEmailCobranca(ids)
    {
        $.post('index.php?app_modulo=contas_receber&app_comando=enviar_email_cobranca', {ids:ids},
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridContasReceber();
                    toastr.success(response["mensagem"], "Sucesso");
                }
                else
                {
                    toastr.warning(response["mensagem"], "Erro");
                }
            }, "json"
        );
    }

    function AtualizarGridContasReceber(pagina, busca, filtro, ordem)
    {
        if (pagina === undefined) pagina = "";
        if (ordem === undefined)  ordem = "";
        if (busca === undefined)  busca = "";
        if (filtro === undefined) filtro = "";

        var post = {
            pagina : pagina,
            busca  : busca,
            filtro : filtro,
            ordem : ordem,
            id_cliente : $("#id_cliente").val(),
            numero_fatura : $("#numero_fatura").val(),
            forma_pagamento : $("#forma_pagamento").val(),
            data_inicial : $("#data_inicial").val(),
            data_final : $("#data_final").val(),
            data_vencimento : $("#data_vencimento").val()
        };

        $("#conteudo_contas_receber").load("index.php?app_modulo=contas_receber&app_comando=ajax_listar_contas_receber", post);
    }

    function Baixa(id)
    {
        ConfirmModal('Aviso', 'Após a baixa essa conta será contabilizada como recebida.<br><br> Tem certeza que deseja executar essa ação?', 'GerarBaixa', id);
    }

    function Estorno(idConta)
    {
        ConfirmModal('Aviso', 'Se confirmar esta ação todas as contas desta fatura serão estornadas.<br><br> Tem certeza que deseja executar essa ação?', 'EstornarConta', idConta);
    }

    function GerarBaixa(id)
    {
        $.post("index.php?app_modulo=contas_receber&app_comando=gerar_baixa&id="+id,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridContasReceber();
                    toastr.success(response["mensagem"], "Sucesso");
                }
                else
                {
                    toastr.warning(response["mensagem"], "Erro");
                }
            }, "json"
        );
    }

    function EstornarConta(idConta)
    {
        $.post("index.php?app_modulo=contas_receber&app_comando=estornar_conta&id_conta="+idConta,
            function (response)
            {
                if(response['codigo'] == 1)
                {
                    AtualizarGridContasReceber();
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