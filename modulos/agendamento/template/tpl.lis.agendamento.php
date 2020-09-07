<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 04:26
 */

require_once ("js.lis.agendamento.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$agendamento = new Agendamento();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $agendamento->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "agenda_manutencao_status.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cliente", "filtro" => "cliente.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Veiculo", "filtro" => "veiculo.modelo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Inicial", "filtro" => "agenda_manutencao.data_hora_inicio", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Final", "filtro" => "agenda_manutencao.data_hora_fim", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Cadastro", "filtro" => "agenda_manutencao.data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Observacao", "filtro" => "agenda_manutencao.observacao", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        if (strtotime($linha['data_inicial']) < strtotime(date("Y-m-d H:i:s")))
            $icone = "<a id='editar' class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Visualizar' onclick='ModificarAgendamento({$linha["id"]})' style='font-size: 125%; cursor: pointer'></a>";
        else
            $icone = "<a id='editar' class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Modificar' onclick='ModificarAgendamento({$linha["id"]})' style='color: #0a6aa1; font-size: 125%; cursor: pointer'></a>";

        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["status"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cliente"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["veiculo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_inicial"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_final"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["observacao"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"   => $icone);

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
$tabela->funcaoAtualizarListagem = "AtualizarGridAgendamento";
$tabela->funcaoModificar = "ModificarAgendamento";
$tabela->gerar();
?>