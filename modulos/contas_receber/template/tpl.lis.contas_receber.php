<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/11/2018
 * Time: 21:39
 */

require_once "js.lis.contas_receber.php";

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
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);
$dataVencimentoFiltro = Utils::convertDateTimeBanco($_REQUEST['data_vencimento'], 'Y-m-d');

$contasReceber = new ContasReceber();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $contasReceber->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem, $idCliente, $numeroFatura, $formaPagamento, $dataInicial, $dataFinal, $dataVencimentoFiltro);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Número Fatura", "filtro" => "numero_fatura", "ordem" => $ordem);
//$dadosColuna["dados_th"][] = array("nome" => "Número O.S", "filtro" => "ordem_servico.id", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "cliente.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Forma de Pagamento", "filtro" => "forma_pagamento.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "contas_receber.valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Parcela", "filtro" => "parcelas", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Cadastro", "filtro" => "contas_receber.data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Vencimento", "filtro" => "contas_receber_ocorrencia.data_vencimento", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dataVencimento = date('d-m-Y', strtotime($linha['data_vencimento']));

        $classContaAtrasada = strtotime($dataVencimento) < strtotime(date('d-m-Y')) ? 'danger' : '';
        $disabled = strtotime($dataVencimento) >= strtotime(date('d-m-Y')) || $linha['envio_email_cobranca'] == '1' ? 'disabled' : '';

        $baixa = "<a id='baixa' class='fas fa-dollar-sign' data-toggle='tooltip' data-placement='top' title='Gerar Baixa' onclick='Baixa({$linha['id']})' style='color: #0a6aa1; font-size: 125%; cursor: pointer'></a>";
        $estorno = "<a id='estorno' class='far fa-times-circle' data-toggle='tooltip' data-placement='top' title='Estornar' onclick='Estorno({$linha['id_conta']})' style='color: #802d2b; font-size: 125%; cursor: pointer'></a>";

        $dadosLinha["id_tr"][$x]      = array("class"      => $classContaAtrasada);
        $dadosLinha["dados_tr"][$x][] = array("checkbox"   => $linha["id"], 'option' => $disabled);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["numero_fatura"]);
//        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["numero_os"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["cliente"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["forma_pagamento"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => Utils::convertFloatSistema($linha["valor_parcelado"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["parcelas"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => Utils::convertDateTimeSistema($linha["data_hora_cadastro"], 'd/m/Y H:i:s'));
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $linha["data_vencimento"] ? Utils::convertDateTimeSistema($linha["data_vencimento"], 'd/m/Y') : '-');
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $baixa);
        $dadosLinha["dados_tr"][$x][] = array("dados"      => $estorno);

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
$tabela->funcaoAtualizarListagem = "AtualizarGridContasReceber";
$tabela->gerar();
?>