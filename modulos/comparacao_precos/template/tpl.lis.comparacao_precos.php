<?php

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS
$codigo = $_REQUEST['codigo'];

$comparacaoPrecos = new ComparacaoPrecos();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $comparacaoPrecos->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $filtro, $ordem, $codigo);

$dadosLinha = [];

//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Fornecedor", "filtro" => "fornecedor.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Produto", "filtro" => "produto.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Código", "filtro" => "produto.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "produto.valor", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    $valorTotal = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["nome"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["rotulo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["codigo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertFloatSistema($linha["valor"]));

        $x++;
    }
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->totalRegistros = $dados[1]["total"];
$tabela->totalRegistrosPaginacao = $totalRegistrosPaginacao;
$tabela->pagina = $pagina;
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->funcaoAtualizarListagem = "AtualizarGridComparacaoPrecos";
$tabela->permitirCampoBusca = false;
$tabela->gerar();
?>