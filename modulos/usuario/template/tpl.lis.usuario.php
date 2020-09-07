<?php
require_once ("js.lis.usuario.php");
/*FILTROS PARA A LISTAGEM*/

//DEFINE A PÁGINA ATUAL DA LISTAGEM
$pagina = $_REQUEST["pagina"] ? $_REQUEST["pagina"] : 1;
//VALOR DO CAMPO DE BUSCA PRESENTE NA LISTAGEM
$busca  = $_REQUEST["busca"];
//NUMERO DE REGISTROS POR PÁGINA
$totalRegistrosPaginacao = 50;
//INICIO DA PAGINA ESCOLHIDA
$inicioRegistros = ($pagina - 1) * $totalRegistrosPaginacao;

/*SÓ SE APLICA QUANDO O USUÁRIO CLICAR EM UMA COLUNA COM A INTENÇÃO DE ORDENAR-LA*/
//COLUNA QUE SERÁ ORDENADA
$filtro = $_REQUEST["filtro"];
//DEFINE SE A ORDENAÇÃO SERÁ EM 'ASC' OU 'DESC'
$ordem  = $_REQUEST["ordem"] == 'desc' ? 'asc' : 'desc';


$usuario = new Usuario();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $usuario->listarPaginacao($inicioRegistros, $totalRegistrosPaginacao, $busca, $filtro, $ordem);

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("checkbox" => "#");
$dadosColuna["dados_th"][] = array("nome" => "Nome", "filtro" => "nome", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Usuario", "filtro" => "usuario", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Email", "filtro" => "email", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Status", "filtro" => "status.rotulo", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Master", "filtro" => "master", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "Data Hora Cadastro", "filtro" => "data_hora_cadastro", "ordem" => $ordem);
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados[0]) > 0)
{
    $x = 0;
    foreach ($dados[0] as $linha)
    {
        $dadosLinha["dados_tr"][$x][] = array("checkbox" => $linha["id"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["nome"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["usuario"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["email"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["status"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["master"] == '0' ? 'não' : 'sim');
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $linha["data_hora_cadastro"]);
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
$tabela->funcaoAtualizarListagem = "AtualizarGridUsuario";
$tabela->funcaoModificar = "ModificarUsuario";
$tabela->gerar();
?>