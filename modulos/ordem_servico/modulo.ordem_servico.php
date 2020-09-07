<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/11/2018
 * Time: 21:17
 */

switch ($this->appComando)
{
    case "listar_ordem_servico":

        $template = "tpl.geral.ordem_servico.php";

        break;

    case "ajax_listar_ordem_servico":

        $template = "tpl.lis.ordem_servico.php";

        break;

    case "frm_editar_ordem_servico":

        $ordemServico = new OrdemServico();
        $ordemServico->setId($_REQUEST["id"]);

        $linha = $ordemServico->editar();

        $template = "tpl.frm.ordem_servico.php";

        break;

    case "editar_ordem_servico":

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
                $_REQUEST["data_inicial"]
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
                    $servicoOrdemServico->setValorServico($_REQUEST['linha_valor_servico'][$idServico]);
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
                    $servicoOrdemServico->setValorServico($_REQUEST['linha_valor'][$idServicoOrdemServico]);
                    $servicoOrdemServico->modificar();
                }
                //EXCLUIR SERVIÇOS
                else
                {
                    $servicoOrdemServico->deletar();
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

    case "imprimir_os":

        $ordemServico = new OrdemServico();
        $ordemServico->setId($_REQUEST['numero_os']);
        $dados = $ordemServico->editar();

        $servicoOrdemServico = new ServicoOrdemServico();
        $ordemServicoProduto = new OrdemServicoProduto();
        $servicos = $servicoOrdemServico->listarServicoOrdemServico($_REQUEST['numero_os']);
        $produtos = $ordemServicoProduto->listar($_REQUEST['numero_os']);

        $template = "tpl.ordem_servico.print.php";

        break;
}