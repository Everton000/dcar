<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 02:51
 */

$idOrdemServico = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$produto = new OrdemServicoProduto();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$dados = $produto->listar($idOrdemServico);

unset($dadosLinha);
unset($dadosColuna);
$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Produto");
$dadosColuna["dados_th"][] = array("nome" => "Valor Unitário");
$dadosColuna["dados_th"][] = array("nome" => "Quantidade");
$dadosColuna["dados_th"][] = array("nome" => "Valor Total");
$dadosColuna["dados_th"][] = array("nome" => "#");

//DADOS DAS LINHAS
if (count($dados) > 0)
{
    $x = 0;
    foreach ($dados as $linhas)
    {
        $quantidadeDisponivel = $produto->quantidadeProdutoDispinivel($linhas['id_produto_estoque']);

        if ($quantidadeDisponivel > 0)
            $quantidadeDisponivel += $linhas['quantidade'];
        else
            $quantidadeDisponivel = $linhas['quantidade'];

        $dadosHidden .= "<input type='hidden' id='linha_id_ordem_servico_produto' name='linha_id_ordem_servico_produto[]' value='{$linhas["id_ordem_servico_produto"]}'>";
        $dadosHidden .= "<input type='hidden' id='linha_id_ordem_servico_produto_estoque' name='linha_id_ordem_servico_produto_estoque[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas["id_produto_estoque"]}'>";
        $dadosHidden .= "<input type='hidden' id='linha_ordem_servico_quantidade_produto' name='linha_ordem_servico_quantidade_produto[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas["quantidade"]}'>";

        $hidden  = "<input type='hidden' id='linha_edita_id_produto_estoque' name='linha_edita_id_produto_estoque[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas["id_produto_estoque"]}'>";
        $hidden  .= "<input type='hidden' class='id_produto' id='linha_edita_id_produto' name='linha_edita_id_produto[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas["id"]}'>";
        $hidden  .= "<input type='hidden' id='linha_edita_quantidade[{$linhas["id_ordem_servico_produto"]}]' name='linha_edita_quantidade[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas["quantidade"]}'>";
        $hidden  .= "<input type='hidden' id='linha_edita_quantidade_disponivel[{$linhas["id_ordem_servico_produto"]}]' name='linha_edita_quantidade_disponivel[{$linhas["id_ordem_servico_produto"]}]' value='{$quantidadeDisponivel}'>";
//        $hidden  .= "<input type='hidden' id='linha_valor_produto[{$linhas["id_produto_estoque"]}]' name='linha_valor_produto[{$linhas["id_produto_estoque"]}]' value='{$linhas["valor"]}'>";
//        $hidden  .= "<input type='hidden' id='linha_valor_total_produto[{$linhas["id_produto_estoque"]}]' name='linha_valor_total_produto[{$linhas["id_produto_estoque"]}]' value='{$linhas["valor"]}'>";

        $valor = "<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' class='form-control mask-money linha-valor-produto' id=\"linha_edita_valor_produto[".$linhas["id_ordem_servico_produto"]."]\" name='linha_edita_valor_produto[{$linhas["id_ordem_servico_produto"]}]' value='".Utils::convertFloatSistema($linhas["valor_unitario"])."' onblur='AtualizarTotalProduto(this, {$linhas['id_ordem_servico_produto']}, true)'/></div>";
        $valorTotal = "<div class='input-group'><div class='input-group-prepend'><span class='input-group-text'>R$</span></div><input type='text' readonly class='form-control mask-money linha-valor-total-produto' id=\"linha_edita_valor_total_produto[".$linhas["id_ordem_servico_produto"]."]\" name='linha_edita_valor_total_produto[{$linhas["id_ordem_servico_produto"]}]' value='".Utils::convertFloatSistema($linhas["valor"])."'/></div>";
        $quantidade = "<div class='input-group'><input type='text' class='form-control' id=\"edita_quantidade_produto[".$linhas["id_ordem_servico_produto"]."]\" name='edita_quantidade_produto[{$linhas["id_ordem_servico_produto"]}]' value='{$linhas['quantidade']}' onchange='ValidarQuantidadeProduto(this, {$quantidadeDisponivel}, {$linhas['id_ordem_servico_produto']}, true)'/><div class='input-group-prepend'><span class='input-group-text'>{$quantidadeDisponivel} disponíveis</span></div>";

        $dadosLinha["dados_tr"][$x][] = array("dados"    => $hidden . $linhas["rotulo"]);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valor);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $quantidade);
        $dadosLinha["dados_tr"][$x][] = array("dados"    => $valorTotal);
        $dadosLinha["dados_tr"][$x][] = array("dados"   => "<span style='color: #ff4441; font-size: 150%; margin-top: 25%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='$(this).parent().parent().remove()'></span>");

        $x++;
    }
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->dadosHidden = $dadosHidden;
$tabela->permitiPaginacao = false;
$tabela->idTabela = "tabela_produto";
$tabela->txtSemRegistro = '-';
$tabela->gerar();
?>