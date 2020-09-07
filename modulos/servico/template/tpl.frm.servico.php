<?php require_once "js.frm.servico.php" ?>

<form method="post" name="form_servico" id="form_servico">

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="descricao" class="error-label">Descrição</label>
            <input type="text" name="descricao" id="descricao" class="form-control input-obrigatorio" placeholder="Digite a descrição do serviço" value="<?=isset($linha["descricao"]) ? $linha["descricao"] : ''?>">
        </div>
    </div>
    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="valor" class="error-label">Valor</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                <input type="text" name="valor" id="valor" class="form-control input-money-obrigatorio" placeholder="Digite o valor do serviço" value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
            </div>
        </div>

    </div>

</form>

