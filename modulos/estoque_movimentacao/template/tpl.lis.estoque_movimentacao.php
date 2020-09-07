<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:20
 */

require_once ("js.lis.estoque_movimentacao.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS
$idProduto = $_REQUEST['id_produto'];
$idFornecedor = $_REQUEST['id_fornecedor'];
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);

$estoqueMovimentacao = new EstoqueMovimentacao();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $estoqueMovimentacao->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $filtro, $ordem, $idProduto, $idFornecedor, $dataInicial, $dataFinal);

$dadosLinha = [];

//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Produto", "filtro" => "produto.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Fornecedor", "filtro" => "fornecedor.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Quantidade", "filtro" => "quantidade_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data da Movimentação", "filtro" => "data_hora_movimentacao", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Usuário", "filtro" => "usuario.nome", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $classTipo = $linha['tipo'] === 'E' ? 'success' : 'danger';

        $dadosLinha["id_tr"][$x]      = array("class"    => $classTipo);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["produto"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["fornecedor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha['quantidade']);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha['data_hora_movimentacao']));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha['usuario']);

        $x++;
    }
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
$tabela->legenda = true;
$tabela->funcaoAtualizarListagem = "AtualizarGridEstoqueMovimentacao";
$tabela->gerar();
?>