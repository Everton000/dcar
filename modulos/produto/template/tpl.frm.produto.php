<?php require_once "js.frm.produto.php" ?>

<form method="post" name="form_produto" id="form_produto">

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="rotulo" class="error-label">Rótulo</label>
            <input type="text" name="rotulo" id="rotulo" class="form-control input-obrigatorio" placeholder="Digite a descrição do produto" value="<?=isset($linha["rotulo"]) ? $linha["rotulo"] : ''?>">
        </div>

        <div class="form-group col-md-6">
            <label for="codigo" class="error-label">Código</label>
            <input type="text" name="codigo" id="codigo" class="form-control input-obrigatorio" placeholder="Digite o código do produto" value="<?=isset($linha["codigo"]) ? $linha["codigo"] : ''?>">
        </div>

    </div>
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="fornecedor" class="error-label">Fornecedor</label>
            <div class="input-group">
                <input name="fornecedor" id="fornecedor" class="form-control input-obrigatorio" placeholder="Digite algo para iniciar a busca" value="<?=isset($linha["fornecedor"]) ? $linha["fornecedor"] : ''?>">
                <input type="hidden" name="id_fornecedor" id="id_fornecedor" value="<?=isset($linha["id_fornecedor"]) ? $linha["id_fornecedor"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-6">
            <label for="valor" class="error-label">Valor</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                <input type="text" name="valor" id="valor" class="form-control input-money-obrigatorio" placeholder="Digite o valor do produto" value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
            </div>
        </div>

    </div>

</form>

