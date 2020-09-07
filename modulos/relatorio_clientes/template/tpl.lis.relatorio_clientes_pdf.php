<?php

$pagina = isset($_REQUEST["pagina"]) ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50000;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] ? 'asc' : 'desc';

//FILTROS
$cliente = $_REQUEST['id_cliente'];
$nomeCliente = $_REQUEST['cliente'];
$cidade = $_REQUEST['cidade'];
$bairro = $_REQUEST['bairro'];
$estado = $_REQUEST['estado'];
$status = $_REQUEST['status'];
$dataInicial = Utils::convertDateTimeBanco($_REQUEST['data_inicial']);
$dataFinal = Utils::convertDateTimeBanco($_REQUEST['data_final']);

$relatorioClientes = new RelatorioClientes();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $relatorioClientes->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $filtro, $ordem, $cliente, $cidade, $bairro, $estado, $status, $dataInicial, $dataFinal);

$dadosLinha = [];

//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "E-mail", "filtro" => "email", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Endereço", "filtro" => "endereco", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Número", "filtro" => "numero", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Bairro", "filtro" => "bairro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cidade", "filtro" => "cidade", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Estado", "filtro" => "estado", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "CEP", "filtro" => "cep", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Telefone", "filtro" => "telefone", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data de Cadastro", "filtro" => "data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "status.rotulo", "ordem" => $ordem);

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["nome"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["email"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["endereco"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["numero"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["bairro"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cidade"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["estado"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cep"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["telefone"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["status"]);

        $x++;
    }
}

$filtros = [];
if ($cliente)     $filtros[] = ['Cliente' => $nomeCliente];
if ($cidade)      $filtros[] = ['Cidade' => $cidade];
if ($bairro)      $filtros[] = ['Bairro' => $bairro];
if ($dataInicial) $filtros[] = ['Data Inicial' => Utils::convertDateTimeSistema($_REQUEST['data_inicial'])];
if ($dataFinal)   $filtros[] = ['Data Final' => Utils::convertDateTimeSistema($_REQUEST['data_final'])];

//GERAR TABELA LISTAGEM
$tabela = new TabelaPdf();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->titulo = 'Relatório de Clientes';
$tabela->filtros = $filtros;
$tabela->retornarHtml = true;
$html = $tabela->gerar();

// CREATE AN INSTANCE OF THE CLASS:
$mpdf = new \Mpdf\Mpdf();
// WRITE SOME HTML CODE:
$mpdf->WriteHTML($html);
// OUTPUT A PDF FILE DIRECTLY TO THE BROWSER
$mpdf->Output();
?>