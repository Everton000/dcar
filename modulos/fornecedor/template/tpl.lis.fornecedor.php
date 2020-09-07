<?php
require_once ("js.lis.fornecedor.php");

$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
$busca  = $_REQUEST["busca"];
$totalRegistrosPaginacao = 50;
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;
$filtro = $_REQUEST["filtro"];
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';
$fornecedor = new Fornecedor();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $fornecedor->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Nome", "filtro" => "nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "CNPJ", "filtro" => "cnpj", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Email", "filtro" => "email", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Endereço", "filtro" => "endereco", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Número", "filtro" => "numero", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Cidade", "filtro" => "cidade", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Telefone", "filtro" => "telefone", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "status.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");


//DADOS DAS LINHAS
if (count($dados{0}) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id_fornecedor"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["nome"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cnpj"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["email"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["endereco"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["numero"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["cidade"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["telefone"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["status"]);
        $dadosLinha["dados_tr"][$x][] = array("editar"   => $linha["id_fornecedor"]);

        $x++;
    }
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->dadosLinha = $dadosLinha;
$tabela->totalRegistros = 0;
$tabela->pagina = $pagina;
$tabela->busca = $busca;
$tabela->filtro = $filtro;
$tabela->ordem = $ordem;
$tabela->totalRegistros = $dados[1]['total'];
$tabela->totalRegistrosPaginacao = $totalRegistrosPaginacao;
$tabela->funcaoAtualizarListagem = "AtualizarGridFornecedor";
$tabela->funcaoModificar = "ModificarFornecedor";
$tabela->gerar();
?>