<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/11/2018
 * Time: 20:47
 */

require_once "js.frm.estoque.php" ?>

<form method="post" name="form_estoque" id="form_estoque">

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="fornecedor">Produto</label>
            <div class="input-group">
                <input name="produto" id="produto" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["produto"]) ? $linha["produto"] : ''?>">
                <input type="hidden" name="id_produto" id="id_produto" value="<?=isset($linha["id_produto"]) ? $linha["id_produto"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="fornecedor">Fornecedor</label>
            <div class="input-group">
                <input name="fornecedor" id="fornecedor" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["fornecedor"]) ? $linha["fornecedor"] : ''?>">
                <input type="hidden" name="id_fornecedor" id="id_fornecedor" value="<?=isset($linha["id_fornecedor"]) ? $linha["id_fornecedor"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="status">Status</label>
            <?php
            $estoque = new Estoque();
            $produtoStatus = $estoque->listarProdutoStatus();

            Select::selectDefault("id_status", "id_status", $produtoStatus, '', 'form-control');
            ?>
        </div>

    </div>

    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridEstoque()">Listar</button>
    </div>

</form>