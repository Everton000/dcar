<?php

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

//FILTROS
$cliente = $_REQUEST['id_cliente'];
$veiculo = $_REQUEST['id_veiculo'];
$numero_os = $_REQUEST['numero_os'];
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);

$relatorioManutencoes = new RelatorioManutencoes();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $relatorioManutencoes->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $filtro, $ordem, $cliente, $veiculo, $numero_os, $dataInicial, $dataFinal);

$dadosLinha = [];

//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Número O.S", "filtro" => "ordem_servico.id", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "cliente.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Veículo", "filtro" => "placa", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Modelo", "filtro" => "veiculo.modelo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "contas_receber.valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Inicial O.S", "filtro" => "ordem_servico.data_hora_inicio", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Final O.S", "filtro" => "ordem_servico.data_hora_fim", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data de Cadastro", "filtro" => "ordem_servico.data_hora_cadastro", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    $valorTotal = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cliente"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["placa"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["veiculo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertFloatSistema($linha["valor"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_inicio"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_fim"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));

        $valorTotal += $linha['valor'];
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
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->funcaoAtualizarListagem = "AtualizarGridRelatorioManutencoes";
$tabela->permitirCampoBusca = false;
$tabela->gerar();
?>