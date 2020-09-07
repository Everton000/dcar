<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 22/11/2018
 * Time: 01:56
 */

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS DA TELA
$id_categoria = $_REQUEST['id_categoria'];
$vencimento = Utils::convertDateTimeBanco($_REQUEST['vencimento'], 'Y-m-d');
$id_status = $_REQUEST['id_status'];
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);
$contaspagar = new RelatorioContasPagar();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $contaspagar->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem, $id_categoria, $vencimento, $dataInicial, $dataFinal, $id_status);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Descriçao ", "filtro" => "descricao", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Categoria", "filtro" => "categoria.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "contas_pagar_status", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Vencimento", "filtro" => "vencimento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Pagamento", "filtro" => "vencimento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Cadastro", "filtro" => "contas_pagar.data_hora_cadastro", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    $valorTotal = 0;

    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["descricao"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["categoria"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["valor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["contas_pagar_status"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["vencimento"] ? Utils::convertDateTimeSistema($linha["vencimento"], 'd/m/Y') : '-');
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["data_hora_pagamento"] ? Utils::convertDateTimeSistema($linha["data_hora_pagamento"], 'd/m/Y') : '-');
        $dadosLinha["dados_tr"][$x][] = array("dados"      => Utils::convertDateTimeSistema($linha["data_hora_cadastro"], 'd/m/Y H:i:s'));

        $valorTotal += (float)$linha['valor'];

        $x++;
    }

    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>Total Paginação</b>", "colspan" => '2');
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>".Utils::convertFloatSistema($valorTotal)."</b>", "colspan" => '5');
    $x++;
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>Total Geral</b>", "colspan" => '2');
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>".Utils::convertFloatSistema($dados[1]['valor_total'])."</b>", "colspan" => '5');

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
$tabela->funcaoAtualizarListagem = "AtualizarGridRelatorioContasPagar";
$tabela->permitirCampoBusca = false;
$tabela->gerar();
?>