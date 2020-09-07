<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 12/11/2018
 * Time: 23:13
 */
require_once "js.frm.relatorio_contas_receber.php";
?>
<form method="post" name="form_relatorio_conta_receber" id="form_relatorio_conta_receber">

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="fornecedor">Cliente</label>
            <div class="input-group">
                <input name="cliente" id="cliente" class="form-control" placeholder="Digite algo para iniciar a busca">
                <input type="hidden" name="id_cliente" id="id_cliente">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="numero_fatura">Número Fatura</label>
            <input type="text" name="numero_fatura" id="numero_fatura" class="form-control input-obrigatorio" placeholder="Número da Fatura">
        </div>

        <div class="form-group col-md-4">
            <label for="forma_pagamento">Forma de Pagamento</label>
            <?php
            $formaPagamento = new FormaPagamento();
            $dadosFormaPagamento = $formaPagamento->ListarSelect();

            Select::selectDefault("forma_pagamento", "forma_pagamento", $dadosFormaPagamento, '', 'form-control select-obrigatorio');
            ?>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="data_inicial">Data Inicial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control mask-date" placeholder="Data Inicial" value="<?=isset($linha["data_hora_inicio"]) ? $linha["data_hora_inicio"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="data_final"> Data Final</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control mask-date" placeholder="Data Final" value="<?=isset($linha["data_hora_fim"]) ? $linha["data_hora_fim"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="data_vencimento"> Data de Vencimento</label>
            <div class="input-group">
                <input type="text" name="data_vencimento" id="data_vencimento" class="form-control mask-date" placeholder="Data de Vencimento" value="<?=isset($linha["data_vencimento"]) ? Utils::convertDateTimeSistema($linha["data_vencimento"], 'd-m-Y') : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-1">
            <label for="receber">A Receber</label><br>
            <input type="checkbox" name="receber" id="receber" class="js-switch" checked value="1">
        </div>

        <div class="form-group col-md-4">
            <label for="recebidas">Recebidas</label><br>
            <input type="checkbox" name="recebidas" id="recebidas" class="js-switch" checked value="1">
        </div>

    </div>
    <br>
    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridRelatorioContasReceber()">Listar</button>
        <button type="button" id="enviar_email_cobranca" class="btn btn-warning" onclick="Imprimir(document.form_relatorio_conta_receber)">Imprimir</button>
    </div>

</form>