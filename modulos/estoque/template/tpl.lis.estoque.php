<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:20
 */

require_once ("js.lis.estoque.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS
$idProduto = $_REQUEST['id_produto'];
$idFornecedor = $_REQUEST['id_fornecedor'];
$idStatus = $_REQUEST['id_status'];

$estoque = new Estoque();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $estoque->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $filtro, $ordem, $idProduto, $idFornecedor, $idStatus);

$dadosLinha = [];

//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Produto", "filtro" => "produto.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Fornecedor", "filtro" => "fornecedor.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Quantidade Disponível", "filtro" => "quantidade_disponivel", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor Unitário", "filtro" => "valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor Total", "filtro" => "valor_total", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "produto_estoque.id_status", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    $valor = 0;
    $valorTotal = 0;
    $totalQuantidadeCadastro = 0;
    $totalQuantidadeDisponivel = 0;
    $valorTotalListagem = 0;
    foreach ($dados[0] as $linha)
    {
        //VALOR TOTAL
        $valor = $linha['quantidade_disponivel'] > 0 ? Utils::convertFloatSistema($linha['valor']) : '0,00';
        $valorTotal = Utils::convertFloatSistema($linha['valor_total']);

        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["produto"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["fornecedor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha['quantidade_disponivel']);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valor);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valorTotal);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha['status']);

        $totalQuantidadeDisponivel += $linha['quantidade_disponivel'];
        $valorTotalListagem += $linha['valor_total'];
        $x++;
    }
    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>Total Paginação</b>', 'colspan' => 2);
    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>'.$totalQuantidadeDisponivel.'</b>', 'colspan' => 2);
    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>'.Utils::convertFloatSistema($valorTotalListagem).'</b>', 'colspan' => 2);

    $x++;

    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>Total Geral</b>', 'colspan' => 2);
    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>'.$dados[1]['quantidade_total_disponivel'].'</b>', 'colspan' => 2);
    $dadosLinha["dados_tr"][$x][] = array("dados" => '<b>'.Utils::convertFloatSistema($dados[1]['valor_total']).'</b>', 'colspan' => 2);
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->dadosLinha = $dadosLinha;
$tabela->totalRegistros = $dados[1]["total"];
$tabela->totalRegistrosPaginacao = $totalRegistrosPaginacao;
$tabela->pagina = $pagina;
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->permitirCampoBusca = false;
$tabela->funcaoAtualizarListagem = "AtualizarGridEstoque";
$tabela->gerar();
?>