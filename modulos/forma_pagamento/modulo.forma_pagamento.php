<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 23:16
 */

switch ($this->appComando)
{
    case "listar_forma_pagamento":

        $template = "tpl.geral.forma_pagamento.php";

        break;

    case "ajax_listar_forma_pagamento":

        $template = "tpl.lis.forma_pagamento.php";

        break;

    case "frm_adicionar_forma_pagamento":

        $template = "tpl.frm.forma_pagamento.php";

        break;

    case "adicionar_forma_pagamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($_REQUEST["rotulo"]);

            $formaPagamento = new FormaPagamento($pdo);

            $formaPagamento->setRotulo($_REQUEST["rotulo"]);
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

    case "frm_editar_forma_pagamento":

        $formaPagamento = new FormaPagamento();
        $formaPagamento->setId($_REQUEST["id"]);

        $linha = $formaPagamento->editar();

        $template = "tpl.frm.forma_pagamento.php";

        break;

    case "editar_forma_pagamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //VALIDA CAMPOS
            Validacao::validarObrigatorio($_REQUEST["rotulo"]);

            $formaPagamento = new FormaPagamento($pdo);

            $formaPagamento->setId($_REQUEST["id"]);
            $formaPagamento->setRotulo($_REQUEST["rotulo"]);
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

    case "deletar_forma_pagamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $formaPagamento = new FormaPagamento();
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
}