<script type="text/javascript">

    $(document).ready(function ()
    {
        $("#tabela_servico").find("tbody").find("td").css('color', '#707478');

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
        $('#data_garantia').datepicker({
            format: 'DD/MM/YYYY',
            language: 'pt-BR',
            minDate: moment()
        });
    });

    function ExecutarAcaoOrdemServico(form, url)
    {
        if (ValidarFormulario($("#form_ordem_servico")))
        {
            if ($(".id_servico").val())
            {
                $.post(url,
                    $("#form_ordem_servico").serialize(),
                    function (response) {
                        if (response["codigo"] == 1) {
                            AtualizarGridOrdemServico();
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
            {
                toastr.warning('Por favor, selecione ao menos um serviço.', "Atenção");
            }
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
    }
</script>
