<?php

$idOrdemServico = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$servico = new ServicoOrdemServico();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $servico->listarServicoOrdemServico($idOrdemServico);

unset($dadosLinha);
unset($dadosColuna);
$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Serviço");
$dadosColuna["dados_th"][] = array("nome" => "Valor");
$dadosColuna["dados_th"][] = array("nome" => "#");

$dadosHidden = '';
//DADOS DAS LINHAS
if (count($dados) > 0)
{
    $x = 0;
    foreach ($dados as $linhas)
    {
        $dadosHidden .= "<input type='hidden' id='linha_id_servico_ordem_servico' name='linha_id_servico_ordem_servico[]' value='{$linhas["id_servico_ordem_servico"]}'>";
        $hidden   = "<input type='hidden' class='id_servico' id='linha_edita_id_servico' name='linha_edita_id_servico[{$linhas["id_servico_ordem_servico"]}]' value='{$linhas["id"]}'>";

        $valor = "<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' class='form-control mask-money linha-valor-servico' id=\"linha_valor[".$linhas["id"]."\" name='linha_valor[{$linhas["id_servico_ordem_servico"]}]' onblur='AtualizarTotalServico()' value='".Utils::convertFloatSistema($linhas["valor"])."'/></div>";
        $dadosLinha["dados_tr"][$x][] = array("dados"   => $hidden . $linhas["descricao"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"   => $valor);
        $dadosLinha["dados_tr"][$x][] = array("dados"   => "<span style='color: #ff4441; font-size: 150%; margin-top: 10%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='$(this).parent().parent().remove()'></span>");

        $x++;
    }
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->dadosHidden = $dadosHidden;
$tabela->permitiPaginacao = false;
$tabela->permitiUl = false;
$tabela->idTabela = "tabela_servico";
$tabela->txtSemRegistro = '-';
$tabela->gerar();
?>