<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/11/2018
 * Time: 20:47
 */

require_once "js.frm.estoque_movimentacao.php" ?>

<form method="post" name="form_estoque_movimentacao" id="form_estoque_movimentacao">

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="fornecedor">Produto</label>
            <div class="input-group">
                <input name="produto" id="produto" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["produto"]) ? $linha["produto"] : ''?>">
                <input type="hidden" name="id_produto" id="id_produto" value="<?=isset($linha["id_produto"]) ? $linha["id_produto"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="fornecedor">Fornecedor</label>
            <div class="input-group">
                <input name="fornecedor" id="fornecedor" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["fornecedor"]) ? $linha["fornecedor"] : ''?>">
                <input type="hidden" name="id_fornecedor" id="id_fornecedor" value="<?=isset($linha["id_fornecedor"]) ? $linha["id_fornecedor"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="data_inicial">Data Inicial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control input-obrigatorio" placeholder="Data Inicial" value="<?=isset($linha["data_hora_inicio"]) ? $linha["data_hora_inicio"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="data_final"> Data Final</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control" placeholder="Data Final" value="<?=isset($linha["data_hora_fim"]) ? $linha["data_hora_fim"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

    </div>

    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridEstoqueMovimentacao()">Listar</button>
    </div>

</form>