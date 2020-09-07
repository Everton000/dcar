<?php
switch ($this->appComando)
{
    case "tpl_login":

        $template = "tpl.login.php";

        break;

    case "login":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {

            if ($_REQUEST['usuario'] == "")
                throw new Exception("Informe um Usuário!");
            if ($_REQUEST['senha'] == "")
                throw new Exception("Informe a senha!");

            $login = new Login($pdo);
            $login->setUsuario($_REQUEST['usuario']);
            $login->setSenha($_REQUEST['senha']);

            $login->logar();

            $msg["mensagem"] = "Bem vindo!";
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

    case "logout":

        $login = new Login();
        $login->logout();

        break;
}
