<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 13/11/2018
 * Time: 00:27
 */

require_once ("js.lis.contas_pagar.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$contaspagar = new ContasPagar();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $contaspagar->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Descricao", "filtro" => "descricao", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Categoria", "filtro" => "categoria", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Vencimento", "filtro" => "vencimento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data do Pagamento", "filtro" => "data_hora_pagamento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "status", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");


//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {

        $dadosLinha["dados_tr"][$x][] = array("checkbox"    => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["descricao"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["categoria"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["valor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["vencimento"],'d/m/Y'));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_pagamento"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["status"]);
        $dadosLinha["dados_tr"][$x][] = array("editar"   => $linha["id"]);


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
$tabela->busca = $busca;
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->funcaoAtualizarListagem = "AtualizarGridContasPagar";
$tabela->funcaoModificar = "ModificarContasPagar";
$tabela->gerar();
?>
