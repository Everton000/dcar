<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/11/2018
 * Time: 22:30
 */

switch ($this->appComando)
{
    case "listar_contas_receber":

        $template = "tpl.geral.contas_receber.php";

        break;

    case "ajax_listar_contas_receber":

        $template = "tpl.lis.contas_receber.php";

        break;

    case "gerar_baixa":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $contasReceber = new ContasReceber();
            $contasReceber->gerarBaixa($_REQUEST['id']);

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

    case "enviar_email_cobranca":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $ids = $_REQUEST['ids'];

            $cliente = new ContasReceber($pdo);
            $cliente->setId(implode(',', $ids));
            $dadosCliente = $cliente->listarClienteEmailCobranca();

            $cliente->emailCobrancaEnviado();

            $dia = date('d');
            $mes = Utils::mesAtual();
            $ano = date('Y');


            foreach ($dadosCliente as $cliente)
            {
                require_once 'modulos/contas_receber/template/tpl_email_cobranca.php';

                $mailer = new Mailer($cliente['email'], $cliente['nome'], "Cobrança de pagamento", "Cobrança", $html);
                $mailer->send();
            }

            $msg["mensagem"] = "E-mail (s) enviado com sucesso!";
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

    case "estornar_conta":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $contasReceber = new ContasReceber();
            $contasReceber->estornarConta($_REQUEST['id_conta']);

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