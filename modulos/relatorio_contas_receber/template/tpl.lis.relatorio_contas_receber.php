<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/11/2018
 * Time: 21:39
 */

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS DA TELA
$idCliente = $_REQUEST['id_cliente'];
$numeroFatura = $_REQUEST['numero_fatura'];
$formaPagamento = $_REQUEST['forma_pagamento'];
$receber = $_REQUEST['receber'];
$recebidas = $_REQUEST['recebidas'];
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);
$dataVencimentoFiltro = Utils::convertDateTimeBanco($_REQUEST['data_vencimento'], 'Y-m-d');
$contasReceber = new RelatorioContasReceber();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $contasReceber->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem, $idCliente, $numeroFatura, $formaPagamento, $receber, $recebidas, $dataInicial, $dataFinal, $dataVencimentoFiltro);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Número Fatura", "filtro" => "numero_fatura", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "cliente.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Forma de Pagamento", "filtro" => "forma_pagamento.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Parcela", "filtro" => "parcelas", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "contas_receber.valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Cadastro", "filtro" => "contas_receber.data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Vencimento", "filtro" => "contas_receber_ocorrencia.data_vencimento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Pagamento", "filtro" => "contas_receber_ocorrencia.data_hora_pagamento", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    $valorTotal = 0;
    foreach ($dados[0] as $linha)
    {
        $dataVencimento = date('d-m-Y', strtotime($linha['data_vencimento']));

        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["numero_fatura"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["cliente"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["forma_pagamento"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["parcelas"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => Utils::convertFloatSistema($linha["valor_parcelado"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"      => Utils::convertDateTimeSistema($linha["data_hora_cadastro"], 'd/m/Y H:i:s'));
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["data_vencimento"] ? Utils::convertDateTimeSistema($linha["data_vencimento"], 'd/m/Y') : '-');
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["data_hora_pagamento"] ? Utils::convertDateTimeSistema($linha["data_hora_pagamento"], 'd/m/Y') : '-');

        $valorTotal += (float)$linha['valor_parcelado'];
        $x++;
    }

    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>Total Paginação</b>", "colspan" => '4');
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>".Utils::convertFloatSistema($valorTotal)."</b>", "colspan" => '4');
    $x++;
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>Total Geral</b>", "colspan" => '4');
    $dadosLinha["dados_tr"][$x][] = array("dados"      => "<b>".Utils::convertFloatSistema($dados[1]['valor_total'])."</b>", "colspan" => '4');
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
$tabela->funcaoAtualizarListagem = "AtualizarGridRelatorioContasReceber";
$tabela->permitirCampoBusca = false;
$tabela->gerar();
?>