<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 23:16
 */

switch ($this->appComando)
{
    case "listar_servico":

        $template = "tpl.geral.servico.php";

        break;

    case "ajax_listar_servico":

        $template = "tpl.lis.servico.php";

        break;

    case "frm_adicionar_servico":

        $template = "tpl.frm.servico.php";

        break;

    case "adicionar_servico":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //VALIDA CAMPOS
            Validacao::validarObrigatorio($_REQUEST["descricao"]);
            Validacao::validarMoneyObrigatorio($_REQUEST["valor"]);

            $formaPagamento = new Servico($pdo);

            $formaPagamento->setDescricao($_REQUEST["descricao"]);
            $formaPagamento->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $formaPagamento->adicionar();

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

    case "frm_editar_servico":

        $formaPagamento = new Servico();
        $formaPagamento->setId($_REQUEST["id"]);

        $linha = $formaPagamento->editar();

        $template = "tpl.frm.servico.php";

        break;

    case "editar_servico":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //VALIDA CAMPOS
            Validacao::validarObrigatorio($_REQUEST["descricao"]);
            Validacao::validarMoneyObrigatorio($_REQUEST["valor"]);

            $formaPagamento = new Servico($pdo);

            $formaPagamento->setId($_REQUEST["id"]);
            $formaPagamento->setDescricao($_REQUEST["descricao"]);
            $formaPagamento->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $formaPagamento->modificar();

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

    case "deletar_servico":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $formaPagamento = new Servico();
            $formaPagamento->deletar($_REQUEST['id']);

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

    case "listar_servico_listagem_json":

        $template = "ajax.servico.php";

        break;
}