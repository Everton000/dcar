<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */

switch ($this->appComando)
{
    case "listar_estoque_entradas":

        $template = "tpl.geral.estoque_entradas.php";

        break;

    case "ajax_listar_estoque_entradas":

        $template = "tpl.lis.estoque_entradas.php";

        break;

    case "frm_adicionar_estoque_entradas":

        $template = "tpl.frm.estoque_entradas.php";

        break;

    case "adicionar_estoque_entradas":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $camposObrigatórios =
                [
                    $_REQUEST["quantidade"],
                    $_REQUEST["valor"],
                    $_REQUEST["valor_total"],
                    $_REQUEST["id_produto"]
                ];

            //VALIDA CAMPOS
            Validacao::validarObrigatorio($camposObrigatórios);

            $estoqueEntradas = new EstoqueEntradas($pdo);

            $estoqueEntradas->setIdProduto($_REQUEST["id_produto"]);
            $estoqueEntradas->setQuantidadeCadastro($_REQUEST["quantidade"]);
            $estoqueEntradas->setQuantidadeDisponivel($_REQUEST["quantidade"]);
            $estoqueEntradas->setIdUsuario($_SESSION['id_usuario']);
            $idProdutoEstoque = $estoqueEntradas->adicionar();

            //HISTÓRICO DE MOVIMENTAÇÕES
            $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
            $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
            $estoqueMovimentacao->setIdProdutoEstoque($idProdutoEstoque);
            $estoqueMovimentacao->setQuantidade($_REQUEST["quantidade"]);
            $estoqueMovimentacao->setTipo('E'); //ENTRADA
            $estoqueMovimentacao->adicionar();

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


    case "frm_editar_estoque_entradas":

        $estoqueEntradas = new EstoqueEntradas();
        $estoqueEntradas->setId($_REQUEST['id']);
        $linha = $estoqueEntradas->editar();

        $template = "tpl.frm.estoque_entradas.php";

        break;

    case "editar_estoque_entradas":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $camposObrigatórios =
                [
                    $_REQUEST["quantidade"],
                    $_REQUEST["valor"],
                    $_REQUEST["valor_total"],
                    $_REQUEST["id_produto"]
                ];

            //VALIDA CAMPOS
            Validacao::validarObrigatorio($camposObrigatórios);

            $estoqueEntradas = new EstoqueEntradas($pdo);

            $estoqueEntradas->setId($_REQUEST["id"]);
            $estoqueEntradas->setIdProduto($_REQUEST["id_produto"]);
            $estoqueEntradas->setQuantidadeCadastro($_REQUEST["quantidade"]);
            $estoqueEntradas->setQuantidadeDisponivel($_REQUEST["quantidade"]);
            $estoqueEntradas->modificar();

            //QUANTIDADE HISTÓRICO E QUANTIDADE ATUAL
            $novaQuantidade = $_REQUEST["quantidade"] - $_REQUEST['quantidade_historico'];
            //ALTERAÇÃO NA QUANTIDADE DE PRODUTO
            if ($novaQuantidade != 0)
            {
                $novaQuantidade = str_replace('-', '', $novaQuantidade);
                //CASO ADICIONE MAIS PRODUTOS É ADICIONADO AO HISTÓRICO DE MOVIMENTAÇÕES
                if ($_REQUEST['quantidade'] > $_REQUEST['quantidade_historico'])
                    $tipo = 'E';//ENTRADA
                else
                    $tipo = 'S';//SAIDA

                //HISTÓRICO DE MOVIMENTAÇÕES
                $estoqueMovimentacao = new EstoqueMovimentacao($pdo);
                $estoqueMovimentacao->setIdUsuario($_SESSION['id_usuario']);
                $estoqueMovimentacao->setIdProdutoEstoque($_REQUEST["id"]);
                $estoqueMovimentacao->setQuantidade($novaQuantidade);
                $estoqueMovimentacao->setTipo($tipo); //ENTRADA
                $estoqueMovimentacao->adicionar();
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

    case "deletar_estoque_entradas":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $cliente = new EstoqueEntradas();
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
}