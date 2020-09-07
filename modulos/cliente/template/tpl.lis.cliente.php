<?php
require_once ("js.lis.cliente.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$cliente = new Cliente();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $cliente->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Nome", "filtro" => "nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "CPF", "filtro" => "cpf", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Telefone", "filtro" => "telefone", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Endereço", "filtro" => "endereco", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cidade", "filtro" => "cidade", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Hora Cadastro", "filtro" => "data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "status", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["nome"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cpf"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["telefone"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["endereco"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cidade"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));
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
$tabela->funcaoAtualizarListagem = "AtualizarGridCliente";
$tabela->funcaoModificar = "ModificarCliente";
$tabela->gerar();
?>