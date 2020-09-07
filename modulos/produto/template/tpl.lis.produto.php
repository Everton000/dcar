<?php
require_once("js.lis.produto.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$produto = new Produto();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $produto->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Código", "filtro" => "rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Rótulo", "filtro" => "rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Fornecedor", "filtro" => "rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["codigo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["rotulo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["fornecedor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertFloatSistema($linha["valor"]));
        $dadosLinha["dados_tr"][$x][] = array("editar"   => $linha["id"]);

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
$tabela->busca = $busca;
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->funcaoAtualizarListagem = "AtualizarGridProduto";
$tabela->funcaoModificar = "ModificarProduto";
$tabela->gerar();
?>