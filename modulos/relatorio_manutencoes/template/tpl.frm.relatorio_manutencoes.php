<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 12/11/2018
 * Time: 23:13
 */
require_once "js.frm.relatorio_manutencoes.php";
?>
<form method="post" name="form_relatorio_manutencoes" id="form_relatorio_manutencoes">

    <div class="form-row">

        <div class="form-group col-md-8">
            <label for="fornecedor">Cliente</label>
            <div class="input-group">
                <input name="cliente" id="cliente" class="form-control" placeholder="Digite algo para iniciar a busca">
                <input type="hidden" name="id_cliente" id="id_cliente">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="veiculo">Veículo</label>
            <div class="input-group">
                <input type="hidden" name="id_veiculo" id="id_veiculo" class="input-obrigatorio" value="<?=isset($linha["id_veiculo"]) ? $linha["id_veiculo"] : ''?>">
                <input type="text" name="veiculo" id="veiculo" class="form-control" placeholder="Veículo" value="<?=isset($linha["veiculo"]) ? $linha["veiculo"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="data_inicial">Data Inicial O.S</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control mask-date-time" placeholder="Data Inicial O.S" value="<?=isset($linha["data_hora_inicio"]) ? $linha["data_hora_inicio"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="data_final"> Data Final O.S</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control mask-date-time" placeholder="Data Final O.S" value="<?=isset($linha["data_hora_fim"]) ? $linha["data_hora_fim"] : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="numero_os">Número O.S</label>
            <input type="text" name="numero_os" id="numero_os" class="form-control" placeholder="Número da Ordem de Serviço">
        </div>

    </div>

    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridRelatorioManutencoes()">Listar</button>
        <button type="button" id="enviar_email_cobranca" class="btn btn-warning" onclick="Imprimir(document.form_relatorio_manutencoes)">Imprimir</button>
    </div>
</form>