<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 25/11/2018
 * Time: 01:33
 */

require_once "js.frm.relatorio_contas_pagar.php";
?>
<form method="post" name="form_relatorio_contas_pagar" id="form_relatorio_contas_receber">

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="id_categoria">Categoria</label>
            <?php
            $contaspagar = new ContasPagar();
            $id_categoria = $contaspagar->ListarCategoria();

            Select::selectDefault("id_categoria", "id_categoria", $id_categoria, '', 'form-control select-obrigatorio');
            ?>
        </div>
        <div class="form-group col-md-6">
            <label for="status">Status</label>
            <?php
            $contaspagar = new ContasPagar();
            $status = $contaspagar->ListarStatus();

            Select::selectDefault("id_status", "id_status", $status, isset($linha['id_contas_pagar_status']) ? $linha['id_contas_pagar_status'] : '', 'form-control select-obrigatorio');

            ?>
        </div>


    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="data_inicial">Data Inicial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control mask-date" placeholder="Data Inicial">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="data_final"> Data Final</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control mask-date" placeholder="Data Final">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="data_vencimento"> Data de Vencimento</label>
            <div class="input-group">
                <input type="text" name="vencimento" id="vencimento" class="form-control mask-date" placeholder="Data de Vencimento">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

    </div>

    <br>
    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridRelatorioContasPagar()">Listar</button>
        <button type="button" id="enviar_email_cobranca" class="btn btn-warning" onclick="Imprimir(document.form_relatorio_contas_pagar)">Imprimir</button>
    </div>

</form>