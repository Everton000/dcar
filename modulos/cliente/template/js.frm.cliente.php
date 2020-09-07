<script type="text/javascript">
    $(document).ready(function ()
    {
//        $('[data-toggle="tooltip"]').tooltip();

        $("#tabela_veiculo").find("tbody").find("td").css('color', '#707478');

        idVeiculo = 0;
        Mascaras();
        Switch();

        if ($("#id_cliente").val() === '')
        {
            CheckedSwitch($("#ativo"), true);
            CheckedSwitch($("#veiculo_ativo"), true);
        }
        else
        {
            $("#veiculo_listagem").val(1);
        }
    });

    function ExecutarAcaoCliente(form, url)
    {
        if ($("#linha_modelo").length || $("#linha_edita_modelo").length)
        {
            RemoverClasseObrigatorio();
        }
        if (ValidarFormulario($("#form_cliente")))
        {
            $.post(url,
                $("#form_cliente").serialize(),
                function (response)
                {
                    if (response["codigo"] == 1)
                    {
                        AtualizarGridCliente();
                        toastr.success(response["mensagem"], "Sucesso");
                        form.close();
                    }
                    else {
                        toastr.warning(response["mensagem"], "Aviso");
                    }
                }, 'json'
            );
        }
    }

    function AdicionarVeiculo()
    {
        if (ValidarFormulario($("#div_veiculo")))
        {
            $("#veiculo_listagem").val(1);

            var dadosLinha = {
                'modelo' : $("#modelo").val(),
                'marca'  : $("#marca").val(),
                'placa'  : $("#placa").val(),
                'km'     : $("#km").val(),
                'chassis' : $("#chassis").val(),
                'ano'    : $("#ano").val(),
                'cor'    : $("#cor").val(),
                'ativo'    : $("#veiculo_ativo").prop('checked') === true ? 'ativo' : 'inativo'
            };

            var linha = "<tr id='"+idVeiculo+"'>";

            linha += "<td>"+dadosLinha.modelo+"</td>";
            linha += "<td>"+dadosLinha.marca+"</td>";
            linha += "<td>"+dadosLinha.placa+"</td>";
            linha += "<td>"+dadosLinha.chassis+"</td>";
            linha += "<td>"+dadosLinha.ano+"</td>";
            linha += "<td>"+dadosLinha.cor+"</td>";
            linha += "<td>"+dadosLinha.km+"</td>";
            linha += "<td>-</td>";
            linha += "<td>"+dadosLinha.ativo+"</td>";
            linha += "<td><span style='color: #0a6aa1; font-size: 125%; cursor: pointer' class='fa fa-edit' data-toggle='tooltip' title='Modificar' onclick='EditarVeiculo(this)'></span></td>";
            linha += "<td><span style='color: #ff4441; font-size: 125%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='ExcluirVeiculo(this)'></span></td>";

            linha += "<input type='hidden' id='linha_modelo' name='linha_modelo["+idVeiculo+"]' value='"+dadosLinha.modelo+"'>";
            linha += "<input type='hidden' id='linha_marca' name='linha_marca["+idVeiculo+"]' value='"+dadosLinha.marca+"'>";
            linha += "<input type='hidden' id='linha_placa' name='linha_placa["+idVeiculo+"]' value='"+dadosLinha.placa+"'>";
            linha += "<input type='hidden' id='linha_chassis' name='linha_chassis["+idVeiculo+"]' value='"+dadosLinha.chassis+"'>";
            linha += "<input type='hidden' id='linha_ano' name='linha_ano["+idVeiculo+"]' value='"+dadosLinha.ano+"'>";
            linha += "<input type='hidden' id='linha_cor' name='linha_cor["+idVeiculo+"]' value='"+dadosLinha.cor+"'>";
            linha += "<input type='hidden' id='linha_km' name='linha_km["+idVeiculo+"]' value='"+dadosLinha.km+"'>";
            linha += "<input type='hidden' id='linha_veiculo_ativo' name='linha_veiculo_ativo["+idVeiculo+"]' value='"+dadosLinha.ativo+"'>";

            linha += "</tr>";

            var tabela = $("#tabela_veiculo");

            if (tabela.find("tbody").find("td").text() === "Nenhum Registro Encontrado!" || tabela.find("tbody").find("td").text() === '-')
            {
                tabela.find("tbody").html(linha);
            }
            else
            {
                tabela.find("tbody").append(linha);
            }
            tabela.find("tbody").find("td").css('color', '#707478');

            idVeiculo++;

            LimparInputs();
        }
    }

    function EditarVeiculo(linha, baseDados = false)
    {
        var conteudo = new Object();
        var id;
        var edita;

        //POPULA OBJETO COM OS DADOS DA LINHA
        $(linha).parent().parent().find("input").each(function ()
        {
            conteudo[this.id] = this.value;
            id = this.id;
        });

        //BUSCA PELO ID DA TR PARA SETA-LA NO CAMPO COMO UM IDENTIFICADOR DO REGISTRO QUE SERÁ MODIFICADO
        $(linha).parent().parent().each(function ()
        {
            idEditar = this.id;
        });

        //MODIFICA REGISTROS QUE ESTÃO SENDO ADICIONADOS
        if (id.substr(6, 5) === 'edita')
        {
            //MODIFICA REGISTROS JÁ SALVOS NA BASE DE DADOS
            $("#id_veiculo_edicao").val(idEditar);
            $("#modelo").val(conteudo['linha_edita_modelo']);
            $("#marca").val(conteudo['linha_edita_marca']);
            $("#placa").val(conteudo['linha_edita_placa']);
            $("#km").val(conteudo['linha_edita_km']);
            $("#chassis").val(conteudo['linha_edita_chassis']);
            $("#ano").val(conteudo['linha_edita_ano']);
            $("#cor").val(conteudo['linha_edita_cor']);

            if (conteudo['linha_edita_veiculo_ativo'] === "ativo")
                CheckedSwitch($("#veiculo_ativo"), true);
            else
                CheckedSwitch($("#veiculo_ativo"), false);
        }
        else
        {
            //ATRIBUI OS VALORES AOS CAMPOS PARA A EDIÇÃO
            $("#id_veiculo_edicao").val(idEditar);
            $("#modelo").val(conteudo['linha_modelo']);
            $("#marca").val(conteudo['linha_marca']);
            $("#placa").val(conteudo['linha_placa']);
            $("#km").val(conteudo['linha_km']);
            $("#chassis").val(conteudo['linha_chassis']);
            $("#ano").val(conteudo['linha_ano']);
            $("#cor").val(conteudo['linha_cor']);

            if (conteudo['linha_veiculo_ativo'] === "ativo")
                CheckedSwitch($("#veiculo_ativo"), true);
            else
                CheckedSwitch($("#veiculo_ativo"), false);
        }

        //MANIPULA OS BOTÕES
        $("#adicionar_veiculo").prop('disabled', true);
        $("#adicionar_veiculo").css('cursor', 'not-allowed');
        $("#modificar_veiculo").prop('disabled', false);
        $("#modificar_veiculo").css('cursor', 'pointer');
    }

    function ModificarVeiculo()
    {
        if (ValidarFormulario($("#div_veiculo")))
        {
            var tabela = $("#tabela_veiculo");
            var idVeiculoAtual = $("#id_veiculo_edicao").val();
            var conteudo = new Object();
            var id;
            var name = new Object();
            var edita;

            $("#"+idVeiculoAtual).find('input').each(function ()
            {
                conteudo[this.id] = this.value;
                name[this.id] = this.name;
                id = this.id;
            });

            var dadosLinha = {
                'modelo' : $("#modelo").val(),
                'marca'  : $("#marca").val(),
                'placa'  : $("#placa").val(),
                'km'     : $("#km").val(),
                'chassis' : $("#chassis").val(),
                'ano'    : $("#ano").val(),
                'cor'    : $("#cor").val(),
                'ativo'    : $("#veiculo_ativo").prop('checked') === true ? 'ativo' : 'inativo'
            };

            var dataHora = conteudo['linha_edita_data_hora_cadastro'] ? conteudo['linha_edita_data_hora_cadastro'] : '-';
            linha  = "<td>"+dadosLinha.modelo+"</td>";
            linha += "<td>"+dadosLinha.marca+"</td>";
            linha += "<td>"+dadosLinha.placa+"</td>";
            linha += "<td>"+dadosLinha.chassis+"</td>";
            linha += "<td>"+dadosLinha.ano+"</td>";
            linha += "<td>"+dadosLinha.cor+"</td>";
            linha += "<td>"+dadosLinha.km+"</td>";
            linha += "<td>"+dataHora+"</td>";
            linha += "<td>"+dadosLinha.ativo+"</td>";
            linha += "<td><span style='color: #0a6aa1; font-size: 125%; cursor: pointer' class='fa fa-edit' data-toggle='tooltip' title='Modificar' onclick='EditarVeiculo(this)'></span></td>";
            linha += "<td><span style='color: #ff4441; font-size: 125%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='ExcluirVeiculo(this)'></span></td>";


            if (id.substr(6, 5) === 'edita')
            {
                edita = 'edita_';

                linha += "<input type='hidden' id='linha_edita_data_hora_cadastro' name='linha_edita_data_hora_cadastro["+idVeiculoAtual+"]' value='"+conteudo['linha_edita_data_hora_cadastro']+"'>";
                linha += "<input type='hidden' id='linha_edita_id_veiculo' name='"+name['linha_edita_id_veiculo']+"' value='"+conteudo['linha_edita_id_veiculo']+"'>";

                linha += "<input type='hidden' id='linha_"+edita+"modelo' name='linha_"+edita+"modelo["+idVeiculoAtual+"]' value='"+dadosLinha.modelo+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"marca' name='linha_"+edita+"marca["+idVeiculoAtual+"]' value='"+dadosLinha.marca+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"placa' name='linha_"+edita+"placa["+idVeiculoAtual+"]' value='"+dadosLinha.placa+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"chassis' name='linha_"+edita+"chassis["+idVeiculoAtual+"]' value='"+dadosLinha.chassis+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"ano' name='linha_"+edita+"ano["+idVeiculoAtual+"]' value='"+dadosLinha.ano+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"cor' name='linha_"+edita+"cor["+idVeiculoAtual+"]' value='"+dadosLinha.cor+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"km' name='linha_"+edita+"km["+idVeiculoAtual+"]' value='"+dadosLinha.km+"'>";
                linha += "<input type='hidden' id='linha_"+edita+"veiculo_ativo' name='linha_"+edita+"veiculo_ativo["+idVeiculoAtual+"]' value='"+dadosLinha.ativo+"'>";

            }
            else
            {
                linha += "<input type='hidden' id='linha_modelo' name='linha_modelo[" + idVeiculoAtual + "]' value='" + dadosLinha.modelo + "'>";
                linha += "<input type='hidden' id='linha_marca' name='linha_marca[" + idVeiculoAtual + "]' value='" + dadosLinha.marca + "'>";
                linha += "<input type='hidden' id='linha_placa' name='linha_placa[" + idVeiculoAtual + "]' value='" + dadosLinha.placa + "'>";
                linha += "<input type='hidden' id='linha_chassis' name='linha_chassis[" + idVeiculoAtual + "]' value='" + dadosLinha.chassis + "'>";
                linha += "<input type='hidden' id='linha_ano' name='linha_ano[" + idVeiculoAtual + "]' value='" + dadosLinha.ano + "'>";
                linha += "<input type='hidden' id='linha_cor' name='linha_cor[" + idVeiculoAtual + "]' value='" + dadosLinha.cor + "'>";
                linha += "<input type='hidden' id='linha_km' name='linha_km[" + idVeiculoAtual + "]' value='" + dadosLinha.km + "'>";
                linha += "<input type='hidden' id='linha_veiculo_ativo' name='linha_veiculo_ativo[" + idVeiculoAtual + "]' value='" + dadosLinha.ativo + "'>";
            }
            $("#"+idVeiculoAtual).html(linha);

            tabela.find("tbody").find("td").css('color', '#707478');

            LimparInputs();

            //MANIPULA OS BOTÕES
            $("#adicionar_veiculo").prop('disabled', false);
            $("#adicionar_veiculo").css('cursor', 'pointer');
            $("#modificar_veiculo").prop('disabled', true);
            $("#modificar_veiculo").css('cursor', 'not-allowed');
        }
    }

    function ExcluirVeiculo(_this)
    {
        $(_this).parent().parent().remove();

        var text = $("#tabela_veiculo").find('tbody').find('td').text();
        if (text === "Nenhum Registro Encontrado!" || text === "-" || text === "" || text === undefined)
        {
            $("#veiculo_listagem").val(0);
        }
    }

    function LimparInputs(buttonLimpar)
    {
        $("#modelo").val("");
        $("#marca").val("");
        $("#placa").val("");
        $("#km").val("");
        $("#chassis").val("");
        $("#ano").val("");
        $("#cor").val("");
        $("#id_veiculo_edicao").val("");

        CheckedSwitch($("#veiculo_ativo"), false);

        //CASO O EVENTO OCORRA NO CLIQUE DO BOTÃO LIMPAR
        if (buttonLimpar)
        {
            //MANIPULA OS BOTÕES
            $("#adicionar_veiculo").prop('disabled', false);
            $("#adicionar_veiculo").css('cursor', 'pointer');
            $("#modificar_veiculo").prop('disabled', true);
            $("#modificar_veiculo").css('cursor', 'not-allowed');
        }
    }

    function RemoverClasseObrigatorio()
    {
        $("#modelo").removeClass("input-obrigatorio");
        $("#marca").removeClass("input-obrigatorio");
        $("#placa").removeClass("placa-obrigatorio");
        $("#km").removeClass("input-obrigatorio");
        $("#chassis").removeClass("input-obrigatorio");
        $("#ano").removeClass("input-obrigatorio");
        $("#cor").removeClass("input-obrigatorio");
    }

</script>