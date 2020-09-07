<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 13/11/2018
 * Time: 00:53
 */
require_once "js.frm.contas_pagar.php" ?>

<form method="post" name="form_contas_pagar" id="form_contas_pagar">

    <input type="hidden" id="contas_pagar" name="contas_pagar" value="<?=$linha['id']?>">
    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="descricao" class="error-label">Descrição</label>
            <input type="text" name="descricao" id="decricao" class="form-control input-obrigatorio" placeholder="Digite a descrição da Conta" value="<?=isset($linha["descricao"]) ? $linha["descricao"] : ''?>">
        </div>
        <div class="form-group col-md-6">
            <label for="valor" class="error-label">Valor</label>
            <div class="input-group">
                <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                <input type="text" name="valor" id="valor" class="form-control input-money-obrigatorio" placeholder="Digite o valor " value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="vencimento">Vencimento</label>
            <input type="text" name="vencimento" id="vencimento" class="form-control" placeholder="Informe o Vencimento" value="<?=isset($linha["vencimento"]) ? Utils::convertDateTimeSistema($linha["vencimento"],'d/m/Y'): ''?>">
        </div>
        <div class="form-group col-md-6">
            <label for="categoria" class="error-label">Categoria</label>
            <?php
            $contaspagar = new ContasPagar();
            $id_categoria = $contaspagar->ListarCategoria();

            Select::selectDefault("categoria", "categoria", $id_categoria, isset($linha['id_categoria']) ? $linha['id_categoria'] : '', 'form-control select-obrigatorio');

            ?>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="status" class="error-label">Status</label>
            <?php
            $contaspagar = new ContasPagar();
            $status = $contaspagar->ListarStatus();

            Select::selectDefault("status", "status", $status, isset($linha['id_status']) ? $linha['id_status'] : '', 'form-control select-obrigatorio');

            ?>
        </div>
    </div>
    <div class="form-row" id="div_data_pagamento" style="display: none">
        <div class="form-group col-md-12">
            <label for="data_pagamento" class="error-label">Data Pagamento</label>
            <input type="text" name="data_pagamento" id="data_pagamento" class="form-control" placeholder="Informe a data de pagamento" value="<?=isset($linha["data_hora_pagamento"]) ? Utils::convertDateTimeSistema($linha["data_hora_pagamento"],'d/m/Y'): ''?>">
        </div>
    </div>
</form>