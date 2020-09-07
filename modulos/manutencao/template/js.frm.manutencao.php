<script type="text/javascript">

    $(document).ready(function ()
    {
        $("#tabela_servico").find("tbody").find("td").css('color', '#707478');
        $("#tabela_produto").find("tbody").find("td").css('color', '#707478');
//        $('[data-toggle="tooltip"]').tooltip();

        Mascaras();

        autocomplete("cliente", "id_cliente", "index.php?app_modulo=cliente&app_comando=listar_cliente_json");

        autocomplete("veiculo", "id_veiculo", "index.php?app_modulo=veiculo&app_comando=listar_veiculo_json", $("#id_cliente"));

        $(".mask-money").maskMoney({thousands:'.', decimal:',', symbolStay: true});

        $('#data_inicial').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        }).on('dp.change', function(e) {
            $('#data_final').data("DateTimePicker").minDate(e.date)
        });
        $('#data_final').datetimepicker({
            format: 'DD/MM/YYYY HH:mm'
        });

        $('#data_garantia, #data_vencimento').datetimepicker({
            format: 'DD/MM/YYYY',
            minDate: moment()
        });

        if ($("#id_manutencao").val())
        {
            CalcularTotal();
            $("#cliente").attr('disabled', 'disabled');
        }

        $("#parcelas").on('change', function ()
        {
            if (ValidarParcelas())
                CalcularTotal();
        });
    });

    function ExecutarAcaoManutencao(form, url)
    {
        if (ValidarFormulario($("#form_manutencao")))
        {
            if (($("#erro").val() === '0'))
            {
                $.post(url,
                    $("#form_manutencao").serialize(),
                    function (response) {
                        if (response["codigo"] == 1)
                        {
                            AtualizarGridManutencao();
                            toastr.success(response["mensagem"], "Sucesso");
                            form.close();
                        }
                        else {
                            toastr.warning(response["mensagem"], "Aviso");
                        }
                    }, 'json'
                );
            }
            else
                toastr.warning('Quantidade de produtos indisponível!', "Aviso");
        }
    }

    function AdicionarServico()
    {
        var servico = $("#servico").val();
        var servicoRepetido = false;

        if (servico)
        {
            $(".id_servico").each(function ()
            {
                if ($(this).val() === servico)
                    servicoRepetido = true;
            });

            if (servicoRepetido === false)
            {
                $.ajax({
                    url: "index.php?app_modulo=servico&app_comando=listar_servico_listagem_json",
                    data: {id_servico : servico},
                    dataType :  'json',
                    success: function (data)
                    {
                        var dados = data[0];
                        var tabela = $("#tabela_servico");
                        var valor = dados.valor.replace(".", ",");

                        var linha = "<tr>";

                        linha += "<input type='hidden' class='id_servico' id='linha_id_servico' name='linha_id_servico[]' value='" + dados.id + "'>";
                        linha += "<td>" + dados.descricao + "</td>";
                        linha += "<td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' class='form-control linha-valor-servico' id='linha_valor_servico["+dados.id+"]' name='linha_valor_servico["+dados.id+"]' value='" + valor + "' onblur='AtualizarTotalServico()'/></div></td>";
                        linha += "<td><span style='color: #ff4441; font-size: 150%; margin-top: 10%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='$(this).parent().parent().remove()'></span></td>";

                        linha += "</tr>";

                        if (tabela.find("tbody").find("td").text() === "Nenhum Registro Encontrado!" || tabela.find("tbody").find("td").text() === '-')
                            tabela.find("tbody").html(linha);
                        else
                            tabela.find("tbody").append(linha);

                        $("#linha_valor_servico\\["+dados.id+"\\]").maskMoney({thousands:'.', decimal:',', symbolStay: true});
                        tabela.find("tbody").find("td").css('color', '#707478');

                        //INCLUI O VALOR NA ABA FINANCEIRO
                        var _this = parseFloat($("#valor").val().replace(',', '.'));
                        var valorProduto = parseFloat(valor.replace(',', '.'));
                        soma = (_this + valorProduto).toFixed(2);

                        $("#valor").val(soma.replace('.', ','));
                        $("#valor_parcelado").val(soma.replace('.', ','));
                    }
                });
            }
        }
    }

    function AdicionarProduto()
    {
        var produto = $("#produto").val();
        var produtoRepetido = false;

        if (produto)
        {
            $(".id_produto").each(function ()
            {
                if ($(this).val() === produto)
                    produtoRepetido = true;
            });

            if (produtoRepetido === false)
            {
                $.ajax({
                    url: "index.php?app_modulo=produto&app_comando=listar_produto_listagem_json",
                    data: {id_produto : produto},
                    dataType :  'json',
                    success: function (data)
                    {
                        var dados = data[0];
                        var tabela = $("#tabela_produto");
                        var valor = dados.valor.replace(".", ",");
                        var linha = "<tr>";

                        linha += "<input type='hidden' class='id_produto' id='linha_id_produto' name='linha_id_produto[]' value='" + dados.id + "'>";
                        linha += "<input type='hidden' id='linha_id_produto_estoque' name='linha_id_produto_estoque[]' value='" + dados.id_produto_estoque + "'>";
                        linha += "<input type='hidden' id='linha_quantidade[" + dados.id_produto_estoque + "]' name='linha_quantidade[" + dados.id_produto_estoque + "]' value='" + dados.quantidade_disponivel + "'>";
                        linha += "<td>" + dados.rotulo + "</td>";
                        linha += "<td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' class='form-control linha-valor-produto' id='linha_valor_produto["+dados.id_produto_estoque+"]' name='linha_valor_produto["+dados.id_produto_estoque+"]' value='" + valor + "'  onblur='AtualizarTotalProduto(this, "+dados.id_produto_estoque+")'/></div></td>";
                        linha += "<td><div class='input-group'><input type='text' class='form-control' id='quantidade_produto["+dados.id_produto_estoque+"]' name='quantidade_produto["+dados.id_produto_estoque+"]' value='1' onchange='ValidarQuantidadeProduto(this, "+dados.quantidade_disponivel+", "+dados.id_produto_estoque+")'/><div class='input-group-prepend'><span class='input-group-text'>"+dados.quantidade_disponivel+" disponíveis</span></div> </td>";
                        linha += "<td><div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' class='form-control linha-valor-total-produto' readonly id='linha_valor_total_produto["+dados.id_produto_estoque+"]' name='linha_valor_total_produto["+dados.id_produto_estoque+"]' value='" + valor + "'/></div></td>";
                        linha += "<td><span style='color: #ff4441; font-size: 150%; margin-top: 25%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='$(this).parent().parent().remove()'></span></td>";

                        linha += "</tr>";

                        if (tabela.find("tbody").find("td").text() === "Nenhum Registro Encontrado!" || tabela.find("tbody").find("td").text() === '-')
                            tabela.find("tbody").html(linha);
                        else
                            tabela.find("tbody").append(linha);

                        $("#linha_valor_produto\\["+dados.id_produto_estoque+"\\]").maskMoney({thousands:'.', decimal:',', symbolStay: true});
                        tabela.find("tbody").find("td").css('color', '#707478');

                        //INCLUI O VALOR NA ABA FINANCEIRO
                        var _this = parseFloat($("#valor").val().replace(',', '.'));
                        var valorProduto = parseFloat(valor.replace(',', '.'));
                        soma = (_this + valorProduto).toFixed(2);

                        $("#valor").val(soma.replace('.', ','));
                        $("#valor_parcelado").val(soma.replace('.', ','));
                    }
                });
            }
        }
    }

    function AtualizarTotalServico()
    {
        var soma = '0,00';
        //INCLUI O VALOR NA ABA FINANCEIRO
        $(".linha-valor-servico").each(function ()
        {
            var _this = parseFloat($(this).val().replace(',', '.'));
            var valor = parseFloat(soma.replace(',', '.'));
            soma = (_this + valor).toFixed(2);
        });

        var valorParcela = (soma / parseInt($("#parcelas").val())).toFixed(2);
        $("#valor").val(soma.replace('.', ','));
        $("#valor_parcelado").val(valorParcela.replace('.', ','));

        AtualizarValorTotal();
    }

    function AtualizarTotalProduto(_this, idProduto, edicao = false)
    {
        if (edicao === false)
            quantidade = parseInt($("#quantidade_produto\\["+idProduto+"\\]").val());
        else
            quantidade = parseInt($("#edita_quantidade_produto\\["+idProduto+"\\]").val());

        var valorUnitario = parseFloat($(_this).val().replace(',', '.'));
        var valorTotal = (valorUnitario * quantidade).toFixed(2);

        if (edicao === false)
            $("#linha_valor_total_produto\\["+idProduto+"\\]").val(valorTotal.replace('.', ','));
        else
            $("#linha_edita_valor_total_produto\\["+idProduto+"\\]").val(valorTotal.replace('.', ','));

        AtualizarValorTotal();
    }

    function ValidarQuantidadeProduto(_this, quantidadeDisponivel, idProduto, edicao = false)
    {
        var input = $(_this);
        var divError = $(_this).parent();

        if ($("#quantidade_indisponivel").length)
            $("#quantidade_indisponivel").remove();

        if ($(_this).val() === '0' || $(_this).val() > quantidadeDisponivel)
        {
            $("#erro").val(1);
            input.addClass('is-invalid');
            divError.append('<div class="invalid-feedback" id="quantidade_indisponivel">Quantidade Indisponível!</div>');
        }
        else
        {
            $("#erro").val(0);
            input.removeClass('is-invalid');
        }

        var valorUnitario;
        var valorTotal;

        if (edicao === false)
        {
            quantidade = parseInt($("#quantidade_produto\\[" + idProduto + "\\]").val());
            valorUnitario = parseFloat($("#linha_valor_produto\\["+idProduto+"\\]").val().replace(',', '.'));
            valorTotal = (valorUnitario * quantidade).toFixed(2);

            $("#linha_valor_total_produto\\["+idProduto+"\\]").val(valorTotal.replace('.', ','));
        }
        else
        {
            quantidade = parseInt($("#edita_quantidade_produto\\[" + idProduto + "\\]").val());
            valorUnitario = parseFloat($("#linha_edita_valor_produto\\[" + idProduto + "\\]").val().replace(',', '.'));
            valorTotal = (valorUnitario * quantidade).toFixed(2);

            $("#linha_edita_valor_total_produto\\["+idProduto+"\\]").val(valorTotal.replace('.', ','));
        }

        AtualizarValorTotal();
    }

    function ValidarParcelas()
    {
        var retorno = true;
        var input = $("#parcelas");
        var divError = $("#parcelas").parent();
        var parcelas = parseInt($("#parcelas").val());

        if (parcelas === undefined || parcelas === 0 || parcelas > 12)
        {
            if (!($("#numero_parcelas").length))
            {
                input.addClass('is-invalid');
                divError.append('<div class="invalid-feedback" id="numero_parcelas">Por favor, escolha o número de parcelas entre 1 á 12!</div>');
            }
            retorno = false;
        }
        else
        {
            input.removeClass('is-invalid');
            if ($("#numero_parcelas").length) {
                $("#numero_parcelas").remove();
            }
            //VALOR FORMATADO
            $("#parcelas").val(parcelas);
        }
        return retorno;
    }

    function CalcularTotal()
    {
        //INCLUI O VALOR NA ABA FINANCEIRO
        var campoValor = parseFloat($("#valor").val().replace(',', '.'));
        var campoParcelas = parseFloat($("#parcelas").val());

        if (campoParcelas)
        {
            resultado = (campoValor / campoParcelas).toFixed(2);
            $("#valor_parcelado").val(resultado.replace('.', ','));
        }
        else
        {
            $("#valor_parcelado").val(campoValor.replace('.', ','));
        }
    }

    function AtualizarValorTotal()
    {
        var soma = '0,00';
        //INCLUI O VALOR NA ABA FINANCEIRO
        $(".linha-valor-servico").each(function ()
        {
            var _this = parseFloat($(this).val().replace(',', '.'));
            var valor = parseFloat(soma.replace(',', '.'));
            soma = (_this + valor).toFixed(2);
        });
        $(".linha-valor-total-produto").each(function ()
        {
            var _this = parseFloat($(this).val().replace(',', '.'));
            var valor = parseFloat(soma.replace(',', '.'));
            soma = (_this + valor).toFixed(2);
        });

        var valorParcela = (soma / parseInt($("#parcelas").val())).toFixed(2);
        $("#valor").val(soma.replace('.', ','));
        $("#valor_parcelado").val(valorParcela.replace('.', ','));
    }

    function LimparVeiculo()
    {
        $("#id_veiculo").val('');
        $("#veiculo").val('');
    }
</script>