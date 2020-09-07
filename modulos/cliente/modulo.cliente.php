<?php

switch ($this->appComando)
{
    case "listar_cliente":

        $template = "tpl.geral.cliente.php";

        break;

    case "ajax_listar_cliente":

        $template = "tpl.lis.cliente.php";

        break;

    case "frm_adicionar_cliente":

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = "";

        $template = "tpl.frm.cliente.php";

        break;

    case "adicionar_cliente":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            if ($_REQUEST['veiculo_listagem'] == '0')
                throw new Exception('Por favor, Adicione um veículo.');

            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["nome"],
                    $_REQUEST["cpf"],
                    $_REQUEST["telefone"],
                    $_REQUEST["endereco"],
                    $_REQUEST["numero"],
                    $_REQUEST["bairro"],
                    $_REQUEST["cidade"],
                    $_REQUEST["estado"]
                ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            //DADOS CLIENTE
            $cliente = new Cliente($pdo);

            $cliente->setNome($_REQUEST["nome"]);
            $cliente->setEmail($_REQUEST["email"] ? : null);
            $cliente->setCpf($_REQUEST["cpf"]);
            $cliente->setTelefone($_REQUEST["telefone"]);
            $cliente->setCep($_REQUEST["cep"] ? : null);
            $cliente->setEndereco($_REQUEST["endereco"]);
            $cliente->setNumero($_REQUEST["numero"]);
            $cliente->setBairro($_REQUEST["bairro"]);
            $cliente->setCidade($_REQUEST["cidade"]);
            $cliente->setEstado($_REQUEST["estado"]);
            //VALOR 1 = INATIVO / 2 = ATIVO
            $cliente->setIdStatus(isset($_REQUEST["ativo"]) ? 2 : 1);
            $cliente->setIdUsuario($_SESSION["id_usuario"]);

            $idCliente = $cliente->adicionar();

            //DADOS VEICULO(S)
            $veiculo = new Veiculo($pdo);
            $veiculo->setIdCliente($idCliente);
            $veiculo->setIdUsuario($_SESSION["id_usuario"]);

            //FAZ REFRENCIA AO INDICE DO VEICULO
            $x = 0;
            //ADICIONA VEICULOS
            foreach ($_REQUEST["linha_modelo"] as $modelo)
            {
                while (!(isset($_REQUEST["linha_marca"][$x])))
                {
                    $x++;
                }
                $veiculo->setModelo($modelo);
                $veiculo->setMarca($_REQUEST["linha_marca"][$x]);
                $veiculo->setPlaca(strtoupper($_REQUEST["linha_placa"][$x]));
                $veiculo->setChassis($_REQUEST["linha_chassis"][$x]);
                $veiculo->setAno($_REQUEST["linha_ano"][$x]);
                $veiculo->setCor($_REQUEST["linha_cor"][$x]);
                $veiculo->setKm($_REQUEST["linha_km"][$x]);
                $veiculo->setIdStatus($_REQUEST["linha_veiculo_ativo"][$x] == 'ativo' ? 2 : 1);

                $veiculo->adicionar();
                $x++;
            }

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;

    case "frm_editar_cliente":

        $cliente = new Cliente();
        $cliente->setId($_REQUEST["id"]);
        $linha = $cliente->editar();

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = $linha['id_status'] == 2 ? 'checked' : '';

        $template = "tpl.frm.cliente.php";

        break;

    case "editar_cliente":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            if ($_REQUEST['veiculo_listagem'] == '0')
                throw new Exception('Por favor, Adicione um veículo.');

            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["nome"],
                    $_REQUEST["cpf"],
                    $_REQUEST["telefone"],
                    $_REQUEST["endereco"],
                    $_REQUEST["numero"],
                    $_REQUEST["bairro"],
                    $_REQUEST["cidade"],
                    $_REQUEST["estado"]
                ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $cliente = new Cliente($pdo);

            //VALIDAR CONTAS EM ABERTO PARA INATIVAR CLIENTE
            if (!(isset($_REQUEST['ativo'])))
            {
                $cliente->verificarContasInativacao($_REQUEST["id"]);
            }

            //DADOS CLIENTE
            $cliente->setId($_REQUEST["id"]);
            $cliente->setNome($_REQUEST["nome"]);
            $cliente->setEmail($_REQUEST["email"] ? : null);
            $cliente->setCpf($_REQUEST["cpf"]);
            $cliente->setTelefone($_REQUEST["telefone"]);
            $cliente->setCep($_REQUEST["cep"] ? : null);
            $cliente->setEndereco($_REQUEST["endereco"]);
            $cliente->setNumero($_REQUEST["numero"]);
            $cliente->setBairro($_REQUEST["bairro"]);
            $cliente->setCidade($_REQUEST["cidade"]);
            $cliente->setEstado($_REQUEST["estado"]);
            //VALOR 1 = INATIVO / 2 = ATIVO
            $cliente->setIdStatus(isset($_REQUEST["ativo"]) ? 2 : 1);

            $cliente->modificar();

            //DADOS VEICULO(S)
            $veiculo = new Veiculo($pdo);
            $veiculo->setIdCliente($_REQUEST["id"]);

            //FAZ REFRENCIA AO INDICE DO VEICULO
            $x = 0;
            //ADICIONA VEICULOS
            if (isset($_REQUEST["linha_modelo"]) > 0 && count($_REQUEST["linha_modelo"]) > 0)
            {
                $veiculo->setIdUsuario($_SESSION["id_usuario"]);

                foreach ($_REQUEST["linha_modelo"] as $modelo)
                {
                    while (!(isset($_REQUEST["linha_marca"][$x])))
                    {
                        $x++;
                    }

                    $veiculo->setModelo($modelo);
                    $veiculo->setMarca($_REQUEST["linha_marca"][$x]);
                    $veiculo->setPlaca(strtoupper($_REQUEST["linha_placa"][$x]));
                    $veiculo->setChassis($_REQUEST["linha_chassis"][$x]);
                    $veiculo->setAno($_REQUEST["linha_ano"][$x]);
                    $veiculo->setCor($_REQUEST["linha_cor"][$x]);
                    $veiculo->setKm($_REQUEST["linha_km"][$x]);
                    $veiculo->setIdStatus($_REQUEST["linha_veiculo_ativo"][$x] == 'ativo' ? 2 : 1);

                    $veiculo->adicionar();
                    $x++;
                }
            }
            //MODIFICA VEICULOS
            if (isset($_REQUEST["id_veiculo_historico"]) && count($_REQUEST["id_veiculo_historico"]) > 0)
            {
                $y = 0;
                foreach ($_REQUEST["id_veiculo_historico"] as $idVeiculo)
                {
                    if (isset($_REQUEST["linha_edita_id_veiculo"][$y]))
                    {
                        $indice = $_REQUEST["linha_edita_id_veiculo"][$y];
                        $veiculo->setId($indice);
                        $veiculo->setModelo($_REQUEST["linha_edita_modelo"][$indice]);
                        $veiculo->setMarca($_REQUEST["linha_edita_marca"][$indice]);
                        $veiculo->setPlaca(strtoupper($_REQUEST["linha_edita_placa"][$indice]));
                        $veiculo->setChassis($_REQUEST["linha_edita_chassis"][$indice]);
                        $veiculo->setAno($_REQUEST["linha_edita_ano"][$indice]);
                        $veiculo->setCor($_REQUEST["linha_edita_cor"][$indice]);
                        $veiculo->setKm($_REQUEST["linha_edita_km"][$indice]);
                        $veiculo->setIdStatus($_REQUEST["linha_edita_veiculo_ativo"][$indice] == 'ativo' ? 2 : 1);

                        $veiculo->modificar();
                    }
                    else
                    {
                        $veiculo->deletar($idVeiculo);
                    }
                    $y++;
                }
            }


            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;

    case "validar_exclusao":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $contasReceber = new OrdemServicoClienteVeiculo($pdo);
            $contasReceber->listarOrdemServicoCliente($_REQUEST['id']);

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;

    case "deletar_cliente":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $cliente = new Cliente();
            $cliente->deletar($_REQUEST['id']);

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;

    case "listar_cliente_json":

        $template = "ajax.cliente.php";

        break;
}