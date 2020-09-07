<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:20
 */

require_once ("js.lis.estoque_entradas.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';

$estoqueEntradas = new EstoqueEntradas();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $estoqueEntradas->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Produto", "filtro" => "produto.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Fornecedor", "filtro" => "fornecedor.nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Quantidade", "filtro" => "quantidade_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor Unitário", "filtro" => "valor", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Valor Total", "filtro" => "valor_total", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data de Cadastro", "filtro" => "data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        //VALOR TOTAL
        $valor = Utils::convertFloatSistema($linha['valor']);
        $valorTotal = Utils::convertFloatSistema($linha['valor_total']);

        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["produto"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["fornecedor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha['quantidade_cadastro']);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valor);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valorTotal);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => Utils::convertDateTimeSistema($linha['data_hora_cadastro']));
        $dadosLinha["dados_tr"][$x][] = array("editar"   => $linha["id"]);

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
$tabela->funcaoAtualizarListagem = "AtualizarGridEstoqueEntradas";
$tabela->funcaoModificar = "ModificarEstoqueEntradas";
$tabela->gerar();
?>