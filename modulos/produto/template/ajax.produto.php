<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 28/10/2018
 * Time: 17:12
 */

switch ($this->appComando)
{
    case "listar_fornecedor_json":

        $produto = new Produto();
        $retorno = $produto->listarFornecedorJson(trim($_REQUEST['term']));

        echo json_encode($retorno);
        break;

    case "listar_produto_listagem_json":

        $produto = new Produto();
        $dados = $produto->ListarProdutoListagemJson($_REQUEST['id_produto']);

        echo json_encode($dados);
        break;

    case "listar_produto_json":

        $produto = new Produto();
        $dados = $produto->listarProdutoJson(trim($_REQUEST['term']));

        echo json_encode($dados);
        break;
}
?>