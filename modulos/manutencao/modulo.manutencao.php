<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 31/10/2018
 * Time: 01:16
 */

switch ($this->appComando)
{
    case "listar_manutencao":

        $template = "tpl.geral.manutencao.php";

        break;

    case "ajax_listar_manutencao":

        $template = "tpl.lis.manutencao.php";

        break;

    case "frm_adicionar_manutencao":

        $template = "tpl.frm.manutencao.php";

        break;

    case "adicionar_manutencao":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["id_cliente"],
                    $_REQUEST["id_veiculo"],
                    $_REQUEST["km"],
                    $_REQUEST["ordem_status"],
                    $_REQUEST["data_inicial"],
                    $_REQUEST["linha_id_servico"],
                    $_REQUEST["forma_pagamento"],
                    $_REQUEST["valor"],
                    $_REQUEST["parcelas"],
                    $_REQUEST["valor_parcelado"],
                ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);


            //REGISTRA A DATA DE MANUTENCAO COMO ÚLTIMA
            $veiculo = new Veiculo();
            $veiculo->setId($_REQUEST['id_veiculo']);
            $veiculo->atualizarDataUltimaManutencao();

            //CONTA A RECEBER
            $contasReceber = new ContasReceber($pdo);

            //BUSCA O ULTIMO NUMERO DE FATURA E INCREMENTA + 1
            $numeroUltimaFatura = $contasReceber->buscarUltimaFatura();
            $numeroFatura = (int)$numeroUltimaFatura + 1;

            $contasReceber->setNumeroFatura($numeroFatura);
            $contasReceber->setIdFormaPagamento($_REQUEST["forma_pagamento"]);
            $contasReceber->setIdUsuario($_SESSION["id_usuario"]);
            $contasReceber->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));

            $idContaReceber = $contasReceber->adicionar();

            //OCORRÊNCIAS DA CONTA
            $contasReceberOcorrencia = new ContasReceberOcorrencia($pdo);
            $contasReceberOcorrencia->setIdContasReceber($idContaReceber);

            $contParcelas = 0;
            $numeroOcorrencia = 1;
            $dataVencimento = date('Y-m-d', strtotime(Utils::convertDateTimeBanco($_REQUEST['data_vencimento'], 'Y-m-d')));

            while ($_REQUEST['parcelas'] > $contParcelas)
            {
                $contasReceberOcorrencia->setNumeroOcorrencia($numeroOcorrencia);
                $contasReceberOcorrencia->setIdStatus(2); // A PAGAR
                $contasReceberOcorrencia->setDataVencimento(Utils::convertDateTimeBanco($dataVencimento));
                $contasReceberOcorrencia->setValor(Utils::convertFloatBanco($_REQUEST['valor_parcelado']));
                $contasReceberOcorrencia->adicionar();
                $contParcelas++;
                $numeroOcorrencia++;
                $dataVencimento = date('Y-m-d', strtotime("+1 month", strtotime($dataVencimento)));

            }

            $ordemServico = new OrdemServico($pdo);

            //ORDEM DE SERVIÇO
            $ordemServico->setIdUsuario($_SESSION["id_usuario"]);
            $ordemServico->setIdContaReceber($idContaReceber);
            $ordemServico->setIdOrdemServicoStatus($_REQUEST["ordem_status"]);
            $ordemServico->setDescricao($_REQUEST["descricao"] ? $_REQUEST["descricao"] : NULL);
            $ordemServico->setQuilometragem($_REQUEST["km"]);
            $ordemServico->setDataInicio(Utils::convertDateTimeBanco($_REQUEST['data_inicial']));
            $ordemServico->setDataFim(Utils::convertDateTimeBanco($_REQUEST['data_final']));
            $ordemServico->setDataGarantia(Utils::convertDateTimeBanco($_REQUEST['data_final'], 'Y-m-d'));

            $idOrdemServico = $ordemServico->adicionar();
            $ordemServico->setId($idOrdemServico);

            //ORDEM DE SERVIÇO PRODUTO CLIENTE
            $ordemServicoClienteVeiculo = new OrdemServicoClienteVeiculo($pdo);
            $ordemServicoClienteVeiculo->setIdOrdemServico($idOrdemServico);
            $ordemServicoClienteVeiculo->setIdCliente($_REQUEST["id_cliente"]);
            $ordemServicoClienteVeiculo->setIdVeiculo($_REQUEST["id_veiculo"]);
            $ordemServicoClienteVeiculo->adicionar();

            //SERVIÇOS
            $servicoOrdemServico = new ServicoOrdemServico($pdo);
            $servicoOrdemServico->setIdOrdemServico($idOrdemServico);

            foreach ($_REQUEST["linha_id_servico"] as $idServico)
            {
                $servicoOrdemServico->setIdServico($idServico);
                $servicoOrdemServico->setValorServico(Utils::convertFloatBanco($_REQUEST['linha_valor_servico'][$idServico]));
                $servicoOrdemServico->adicionar();
            }

            //PRODUTOS
            $ordemServicoProduto = new OrdemServicoProduto($pdo);
            $ordemServicoProduto->setIdOrdemServico($idOrdemServico);

            if (isset($_REQUEST['linha_id_produto_estoque']) && count($_REQUEST['linha_id_produto_estoque']) > 0)
            {
                foreach ($_REQUEST['linha_id_produto_estoque'] as $idProduto)
                {
                    $qtd = 0;
                    while ($_REQUEST['quantidade_produto'][$idProduto] > $qtd)
                    {
                        $ordemServicoProduto->setIdProdutoEstoque($idProduto);
                        $ordemServicoProduto->setValorProduto(Utils::convertFloatBanco($_REQUEST['linha_valor_produto'][$idProduto]));
                        $ordemServicoProduto->adicionar();

                        //HISTÓRICO DE MOVIMENTAÇÕES
                        $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
                        $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
                        $estoqueMovimentacao->setIdProdutoEstoque($idProduto);
                        $estoqueMovimentacao->setQuantidade('1');
                        $estoqueMovimentacao->setTipo('S'); //SAIDA
                        $estoqueMovimentacao->adicionar();

                        $qtd++;
                    }
                    //MUDA O STATUS PARA VENDIDO CASO ZERE O ESTOQUE DESTE PRODUTO
                    if ($_REQUEST['linha_quantidade'][$idProduto] == $_REQUEST['quantidade_produto'][$idProduto])
                    {
                        $ordemServicoProduto->atualizaStatusProdutoVendido();
                    }
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

    case "frm_editar_manutencao":

        $manutencao = new Manutencao();
        $manutencao->setId($_REQUEST["id"]);

        $linha = $manutencao->editar();

        $template = "tpl.frm.manutencao.php";

        break;

    case "editar_manutencao":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["id_cliente"],
                    $_REQUEST["id_veiculo"],
                    $_REQUEST["km"],
                    $_REQUEST["ordem_status"],
                    $_REQUEST["data_inicial"],
//                    $_REQUEST["linha_edita_id_servico"],
                $_REQUEST["forma_pagamento"],
                $_REQUEST["valor"],
                $_REQUEST["parcelas"],
                $_REQUEST["valor_parcelado"],
            ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $ordemServico = new OrdemServico($pdo);

            //ORDEM DE SERVIÇO
            $ordemServico->setId($_REQUEST["id"]);
            $ordemServico->setIdOrdemServicoStatus($_REQUEST["ordem_status"]);
            $ordemServico->setDescricao($_REQUEST["descricao"] ? $_REQUEST["descricao"] : NULL);
            $ordemServico->setQuilometragem($_REQUEST["km"]);
            $ordemServico->setDataInicio(Utils::convertDateTimeBanco($_REQUEST['data_inicial']));
            $ordemServico->setDataFim(Utils::convertDateTimeBanco($_REQUEST['data_final']));
            $ordemServico->setDataGarantia(Utils::convertDateTimeBanco($_REQUEST['data_final'], 'Y-m-d'));

            $ordemServico->modificar();

            //ORDEM DE SERVIÇO PRODUTO CLIENTE
            $ordemServicoClienteVeiculo = new OrdemServicoClienteVeiculo($pdo);

            $ordemServicoClienteVeiculo->setId($_REQUEST["id_cliente_veiculo"]);
            $ordemServicoClienteVeiculo->setIdCliente($_REQUEST["id_cliente"]);
            $ordemServicoClienteVeiculo->setIdVeiculo($_REQUEST["id_veiculo"]);
            $ordemServicoClienteVeiculo->modificar();

            $servicoOrdemServico = new ServicoOrdemServico($pdo);
            $servicoOrdemServico->setIdOrdemServico($_REQUEST["id"]);

            //ADICIONAR NOVOS SERVICOS
            if (isset($_REQUEST['linha_id_servico']) && count($_REQUEST['linha_id_servico']) > 0)
            {
                foreach ($_REQUEST["linha_id_servico"] as $idServico)
                {
                    $servicoOrdemServico->setIdServico($idServico);
                    $servicoOrdemServico->setValorServico(Utils::convertFloatBanco($_REQUEST['linha_valor_servico'][$idServico]));
                    $servicoOrdemServico->adicionar();
                }
            }

            //SERVIÇOS CADASTRADOS
            foreach ($_REQUEST['linha_id_servico_ordem_servico'] as $idServicoOrdemServico)
            {
                $servicoOrdemServico->setId($idServicoOrdemServico);

                //EDITAR SERVIÇOS CADASTRADOS
                if (isset($_REQUEST['linha_edita_id_servico'][$idServicoOrdemServico]))
                {
                    $servicoOrdemServico->setIdServico($_REQUEST['linha_edita_id_servico'][$idServicoOrdemServico]);
                    $servicoOrdemServico->setValorServico(Utils::convertFloatBanco($_REQUEST['linha_valor'][$idServicoOrdemServico]));
                    $servicoOrdemServico->modificar();
                }
                //EXCLUIR SERVIÇOS
                else
                {
                    $servicoOrdemServico->deletar();
                }
            }

            $ordemServicoProduto = new OrdemServicoProduto($pdo);
            $ordemServicoProduto->setIdOrdemServico($_REQUEST['id']);

            //ADICIONA NOVOS PRODUTOS
            if (isset($_REQUEST['linha_id_produto_estoque']) && count($_REQUEST['linha_id_produto_estoque']) > 0)
            {
                foreach ($_REQUEST['linha_id_produto_estoque'] as $idProduto)
                {
                    $qtd = 0;
                    while ($_REQUEST['quantidade_produto'][$idProduto] > $qtd)
                    {
                        $ordemServicoProduto->setIdProdutoEstoque($idProduto);
                        $ordemServicoProduto->setValorProduto(Utils::convertFloatBanco($_REQUEST['linha_valor_produto'][$idProduto]));
                        $ordemServicoProduto->adicionar();

                        //HISTÓRICO DE MOVIMENTAÇÕES
                        $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
                        $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
                        $estoqueMovimentacao->setIdProdutoEstoque($idProduto);
                        $estoqueMovimentacao->setQuantidade('1');
                        $estoqueMovimentacao->setTipo('S'); //SAIDA
                        $estoqueMovimentacao->adicionar();

                        $qtd++;
                    }
                    //MUDA O STATUS PARA VENDIDO CASO ZERE O ESTOQUE DESTE PRODUTO
                    if ($_REQUEST['linha_quantidade'][$idProduto] == $_REQUEST['quantidade_produto'][$idProduto])
                    {
                        $ordemServicoProduto->atualizaStatusProdutoVendido();
                    }
                }
            }

            //MODIFICA PRODUTOS
            if (isset($_REQUEST['linha_id_ordem_servico_produto']) && count($_REQUEST['linha_id_ordem_servico_produto']) > 0)
            {
                foreach ($_REQUEST['linha_id_ordem_servico_produto'] as $idOrdemServicoProduto)
                {
                    if (isset($_REQUEST['linha_edita_id_produto_estoque'][$idOrdemServicoProduto]))
                    {
                        $qtdHistoricoProduto = $_REQUEST['linha_edita_quantidade'][$idOrdemServicoProduto];
                        $qtdProduto = $_REQUEST['edita_quantidade_produto'][$idOrdemServicoProduto];

                        $ordemServicoProduto->setId($idOrdemServicoProduto);
                        $ordemServicoProduto->setIdProdutoEstoque($_REQUEST['linha_edita_id_produto_estoque'][$idOrdemServicoProduto]);
                        $ordemServicoProduto->setValorProduto(Utils::convertFloatBanco($_REQUEST['linha_edita_valor_produto'][$idOrdemServicoProduto]));

                        //QUANTIDADE IGUAL A SALVA NA BASE DE DADOS - MODIFICO O VALOR
                        if ($qtdHistoricoProduto == $qtdProduto)
                        {
                            $ordemServicoProduto->modificar();
                        }
                        //QUANTIDADE ALTERADA - EXCLUO OS REGISTROS DO PRODUTO E ADICIONO NOVAMENTE COM A QUANTIDADE ATUAL
                        else
                        {
                            //EXCLUIO PRODUTO (COM TODA A QUANTIDADE SALVA)
                            $ordemServicoProduto->deletar($qtdHistoricoProduto);

                            $qtd = 0;
                            //ADICIONO OS PRODUTOS
                            while ($qtdProduto > $qtd)
                            {
                                $ordemServicoProduto->adicionar();
                                $qtd++;
                            }

                            $quantidadeMovimentacao = str_replace('-', '',$qtdHistoricoProduto - $qtdProduto);

                            //CASO ADICIONE MAIS PRODUTOS É ADICIONADO AO HISTÓRICO DE MOVIMENTAÇÕES
                            if ($qtdProduto > $qtdHistoricoProduto)
                                $tipo = 'S';//ENTRADA
                            else
                                $tipo = 'E';//SAIDA

                            //HISTÓRICO DE MOVIMENTAÇÕES
                            $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
                            $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
                            $estoqueMovimentacao->setIdProdutoEstoque($_REQUEST['linha_edita_id_produto_estoque'][$idOrdemServicoProduto]);
                            $estoqueMovimentacao->setQuantidade($quantidadeMovimentacao);
                            $estoqueMovimentacao->setTipo($tipo); //SAIDA
                            $estoqueMovimentacao->adicionar();
                        }

                        //MUDA O STATUS PARA VENDIDO CASO ZERE O ESTOQUE DESTE PRODUTO
                        if ($qtdProduto == $_REQUEST['linha_edita_quantidade_disponivel'][$idOrdemServicoProduto])
                        {
                            $ordemServicoProduto->atualizaStatusProdutoVendido();
                        }
                    }
                    else
                    {
                        //EXCLUI PRODUTO (COM TODA A QUANTIDADE SALVA)
                        $ordemServicoProduto->setIdProdutoEstoque($_REQUEST['linha_id_ordem_servico_produto_estoque'][$idOrdemServicoProduto]);
                        $ordemServicoProduto->deletar($_REQUEST['linha_ordem_servico_quantidade_produto'][$idOrdemServicoProduto]);

//                      //HISTÓRICO DE MOVIMENTAÇÕES
                        $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
                        $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
                        $estoqueMovimentacao->setIdProdutoEstoque($_REQUEST['linha_id_ordem_servico_produto_estoque'][$idOrdemServicoProduto]);
                        $estoqueMovimentacao->setQuantidade($_REQUEST['linha_ordem_servico_quantidade_produto'][$idOrdemServicoProduto]);
                        $estoqueMovimentacao->setTipo('E'); //SAIDA
                        $estoqueMovimentacao->adicionar();
                    }
                }
            }

            //CONTA A RECEBER
            $contasReceber = new ContasReceber($pdo);

            $contasReceber->setId($_REQUEST["id_contas_receber"]);
            $contasReceber->setIdFormaPagamento($_REQUEST["forma_pagamento"]);
            $contasReceber->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));

            $contasReceber->modificar();

            //OCORRÊNCIAS DA CONTA
            $contasReceberOcorrencia = new ContasReceberOcorrencia($pdo);
            $contasReceberOcorrencia->setIdContasReceber($_REQUEST['id_contas_receber']);

            $contParcelas = 0;
            $parcelas = $_REQUEST['parcelas'];
            $parcelasHistorico = $_REQUEST['parcelas_historico'];

            $dataVencimento = date('Y-m-d', strtotime(Utils::convertDateTimeBanco($_REQUEST['data_vencimento'], 'Y-m-d')));

            //MODIFICO PARCELAS
            if ($parcelas == $parcelasHistorico)
            {
                $contasReceberOcorrencia->setDataVencimento($dataVencimento);
                $contasReceberOcorrencia->setValor(Utils::convertFloatBanco($_REQUEST['valor_parcelado']));
                $contasReceberOcorrencia->modificar();
            }
            //CASO MODIFIQUE O NÚMERO DE OCORRÊNCIAS - EXCLUO AS OCORRÊNCIAS DA CONTA E ADICIONO AS NOVAS OCORRÊNCIAS
            else
            {
                $contasReceberOcorrencia->deletar();

                $contParcelas = 0;
                $numeroOcorrencia = 1;
                while ($_REQUEST['parcelas'] > $contParcelas)
                {
                    $contasReceberOcorrencia->setNumeroOcorrencia($numeroOcorrencia);
                    $contasReceberOcorrencia->setIdStatus(2); // A PAGAR
                    $contasReceberOcorrencia->setDataVencimento($dataVencimento);
                    $contasReceberOcorrencia->setValor(Utils::convertFloatBanco($_REQUEST['valor_parcelado']));
                    $contasReceberOcorrencia->adicionar();
                    $contParcelas++;
                    $numeroOcorrencia++;
                    $dataVencimento = date('Y-m-d', strtotime("+1 month", strtotime($dataVencimento)));

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
            $contasReceber = new ContasReceber($pdo);
            $contasReceber->listarContasOrdemServico($_REQUEST['id']);

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

    case "deletar_manutencao":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $manutencao = new Manutencao();
            $manutencao->deletar($_REQUEST['id']);
            $manutencao->atualizarEstoqueExclusao($_REQUEST['id']);

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

}