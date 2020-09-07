<?php
switch ($this->appComando)
{
    case "listar_usuario":

        $template = "tpl.geral.usuario.php";

        break;

    case "ajax_listar_usuario":

        $template = "tpl.lis.usuario.php";

        break;

    case "frm_adicionar_usuario":

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = "";
        $checked['master'] = "";
        $senhaObrigatorio = 'error-label';

        $template = "tpl.frm.usuario.php";

        break;

    case "adicionar_usuario":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["nome"],
                    $_REQUEST["email"],
                    $_REQUEST["usuario"],
                    $_REQUEST["senha"],
                    $_REQUEST["pergunta_senha"],
                    $_REQUEST["resposta_senha"]
                ];

            //VALIDA SENHAS
            if ($_REQUEST["senha"] != $_REQUEST["confirma_senha"])
                throw new Exception("As senhas são diferentes!");

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $usuario = new Usuario($pdo);

            $usuario->setNome($_REQUEST["nome"]);
            $usuario->setEmail($_REQUEST["email"]);
            $usuario->setUsuario($_REQUEST["usuario"]);
            $usuario->setSenha($_REQUEST["senha"]);
            $usuario->setPerguntaSenha($_REQUEST["pergunta_senha"]);
            $usuario->setRespostaSenha($_REQUEST["resposta_senha"]);
            $usuario->setMaster(isset($_REQUEST["master"]) ? 1 : 0);
            //VALOR 1 = INATIVO / 2 = ATIVO
            $usuario->setAtivo(isset($_REQUEST["ativo"]) ? 2 : 1);

            $usuario->adicionar();

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

    case "frm_editar_usuario":

        //BUSCA OS DADOS DO USUÁRIO PARA EXIBIR NO FORMULÁRIO
        $usuario = new Usuario();
        $usuario->setId($_REQUEST["id"]);
        $linha = $usuario->editar();

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = $linha['id_status'] == 2 ? 'checked' : '';
        $checked['master'] = $linha['master'] == 1 ? 'checked' : '';
        $senhaObrigatorio = '';

        $template = "tpl.frm.usuario.php";

        break;

    case "editar_usuario":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [
                    $_REQUEST["nome"],
                    $_REQUEST["email"],
                    $_REQUEST["usuario"],
                    $_REQUEST["pergunta_senha"],
                    $_REQUEST["resposta_senha"]
                ];

            //VALIDA SENHAS
            if ($_REQUEST["senha"] != $_REQUEST["confirma_senha"])
                throw new Exception("As senhas são diferentes!");

            //VALIDA CAMPOS
            Validacao::validarObrigatorio($camposObrigatórios);

            $usuario = new Usuario($pdo);

            $usuario->setId($_REQUEST["id"]);
            $usuario->setNome($_REQUEST["nome"]);
            $usuario->setEmail($_REQUEST["email"]);
            $usuario->setUsuario($_REQUEST["usuario"]);
            $usuario->setSenha($_REQUEST["senha"]);
            $usuario->setPerguntaSenha($_REQUEST["pergunta_senha"]);
            $usuario->setRespostaSenha($_REQUEST["resposta_senha"]);
            $usuario->setMaster(isset($_REQUEST["master"]) ? 1 : 0);
            //VALOR 1 = INATIVO / 2 = ATIVO
            $usuario->setAtivo(isset($_REQUEST["ativo"]) ? 2 : 1);

            $usuario->modificar();

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

    case "deletar_usuario":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $usuario = new Usuario();
            $usuario->deletar($_REQUEST['id']);

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