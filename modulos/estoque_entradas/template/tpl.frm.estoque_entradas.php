<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/11/2018
 * Time: 20:47
 */

require_once "js.frm.estoque_entradas.php" ?>

<form method="post" name="form_estoque_entradas" id="form_estoque_entradas">

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="fornecedor" class="error-label">Produto</label>
            <div class="input-group">
                <input name="produto" id="produto" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["produto"]) ? $linha["produto"] : ''?>">
                <input type="hidden" name="id_produto" id="id_produto" value="<?=isset($linha["id_produto"]) ? $linha["id_produto"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="valor" class="error-label">Valor</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                <input type="text" name="valor" id="valor" class="form-control input-money-obrigatorio" readonly value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="quantidade" class="error-label">Quantidade</label>
            <input type="text" id="quantidade" name="quantidade" class="form-control" placeholder="Quantidade" value="<?=isset($linha['quantidade_cadastro']) ? $linha['quantidade_cadastro'] : ''?>">
            <input type="hidden" id="quantidade_historico" name="quantidade_historico" value="<?=isset($linha['quantidade_cadastro']) ? $linha['quantidade_cadastro'] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label for="valor_total" class="error-label">Valor Total</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                <input type="text" name="valor_total" id="valor_total" class="form-control input-money-obrigatorio" readonly value="<?=isset($linha["valor_total"]) ? Utils::convertFloatSistema($linha["valor_total"]) : '0,00'?>">
            </div>
        </div>

    </div>

</form>