<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 12/11/2018
 * Time: 23:13
 */
require_once "js.frm.relatorio_clientes.php";
?>
<form method="post" name="form_relatorio_clientes" id="form_relatorio_clientes">

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
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control" placeholder="Cidade">
        </div>

        <div class="form-group col-md-4">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control" placeholder="Bairro">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="data_inicial">Data Inicial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control input-obrigatorio" placeholder="Data Inicial" value="<?=isset($linha["data_hora_inicio"]) ? $linha["data_hora_inicio"] : ''?>">
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

        <div class="form-group col-md-2">
            <label for="estado">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control mask-uf" placeholder="Estado">
        </div>

        <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="">Todos</option>
                <option value="2">Ativo</option>
                <option value="1">Inativo</option>
            </select>
        </div>

    </div>

    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridRelatorioClientes()">Listar</button>
        <button type="button" id="enviar_email_cobranca" class="btn btn-warning" onclick="Imprimir(document.form_relatorio_clientes)">Imprimir</button>
    </div>
</form>