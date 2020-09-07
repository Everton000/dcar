<?php
require_once ("js.lis.manutencao.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$manutencao = new Manutencao();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $manutencao->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Número O.S", "filtro" => "ordem_servico.id", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "cliente.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Veículo", "filtro" => "veiculo.placa", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Modelo", "filtro" => "veiculo.modelo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor", "filtro" => "contas_receber.valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Manutenção", "filtro" => "ordem_servico.data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Cadastro", "filtro" => "ordem_servico.data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status O.S", "filtro" => "ordem_servico_status.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["numero"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["numero"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cliente"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => strtoupper($linha["veiculo"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["modelo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["valor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_cadastro_manutençao"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["ordem_servico_status"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => '<a class="fas fa-print" data-toggle="tooltip" title="Imprimir" style="font-size: 125%; color: #0a6aa1" href="javascript:" onclick="ImprimirOs('."{$linha['numero']}".')">');
        $dadosLinha["dados_tr"][$x][] = array("editar"   => $linha["numero"]);

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
$tabela->funcaoAtualizarListagem = "AtualizarGridManutencao";
$tabela->funcaoModificar = "ModificarManutencao";
$tabela->gerar();
?>