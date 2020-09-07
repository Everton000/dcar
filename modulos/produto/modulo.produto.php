<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 23:16
 */

switch ($this->appComando)
{
    case "listar_produto":

        $template = "tpl.geral.produto.php";

        break;

    case "ajax_listar_produto":

        $template = "tpl.lis.produto.php";

        break;

    case "frm_adicionar_produto":

        $template = "tpl.frm.produto.php";

        break;

    case "adicionar_produto":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $camposObrigatórios =
                [
                    $_REQUEST["rotulo"],
                    $_REQUEST["valor"],
                    $_REQUEST["id_fornecedor"],
                    $_REQUEST["codigo"]
                ];

            //VALIDA CAMPOS
            Validacao::validarObrigatorio($camposObrigatórios);

            $produto = new Produto($pdo);

            $produto->setRotulo($_REQUEST["rotulo"]);
            $produto->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $produto->setIdFornecedor($_REQUEST["id_fornecedor"]);
            $produto->setCodigo($_REQUEST["codigo"]);
            $produto->adicionar();

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

    case "frm_editar_produto":

        $produto = new Produto();
        $produto->setId($_REQUEST["id"]);

        $linha = $produto->editar();

        $template = "tpl.frm.produto.php";

        break;

    case "editar_produto":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $camposObrigatórios =
                [
                    $_REQUEST["rotulo"],
                    $_REQUEST["valor"],
                    $_REQUEST["id_fornecedor"],
                    $_REQUEST["codigo"]
                ];

            //VALIDA CAMPOS
            Validacao::validarObrigatorio($camposObrigatórios);

            $produto = new Produto($pdo);

            $produto->setId($_REQUEST["id"]);
            $produto->setRotulo($_REQUEST["rotulo"]);
            $produto->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $produto->setIdFornecedor($_REQUEST["id_fornecedor"]);
            $produto->setCodigo($_REQUEST["codigo"]);
            $produto->modificar();

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
            $produto = new Produto($pdo);
            $produto->listarProdutosEstoque($_REQUEST['id']);

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

    case "deletar_produto":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $produto = new Produto();
            $produto->deletar($_REQUEST['id']);

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

    case "listar_fornecedor_json":

        $template = "ajax.produto.php";

        break;

    case "listar_produto_listagem_json":

        $template = "ajax.produto.php";

        break;

    case "listar_produto_json":

        $template = "ajax.produto.php";

        break;
}