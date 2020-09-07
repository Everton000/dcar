<?php require_once "js.frm.ordem_servico.php";?>

<form method="post" name="form_ordem_servico" id="form_ordem_servico">

    <input type="hidden" id="id_cliente_veiculo" name="id_cliente_veiculo" value="<?=isset($linha['id_cliente_veiculo']) ? $linha['id_cliente_veiculo'] : ''?>">

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="cliente" class="error-label">Cliente</label>
            <input type="hidden" name="id_cliente" id="id_cliente" class="input-obrigatorio" value="<?=isset($linha["id_cliente"]) ? $linha["id_cliente"] : ''?>">
            <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Cliente" value="<?=isset($linha["cliente"]) ? $linha["cliente"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label for="veiculo" class="error-label">Veículo</label>
            <input type="hidden" name="id_veiculo" id="id_veiculo" class="input-obrigatorio" value="<?=isset($linha["id_veiculo"]) ? $linha["id_veiculo"] : ''?>">
            <input type="text" name="veiculo" id="veiculo" class="form-control" placeholder="Veículo" value="<?=isset($linha["veiculo"]) ? $linha["veiculo"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label for="km" class="error-label">Quilometragem</label>
            <input type="text" name="km" id="km" class="form-control mask-km input-obrigatorio" placeholder="Quilometragem atual do veículo" value="<?=isset($linha["quilometragem"]) ? $linha["quilometragem"] : ''?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="data_inicial" class="error-label">Data Hora Inicial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control input-obrigatorio" placeholder="Data e Hora Inicial" value="<?=isset($linha["data_hora_inicio"]) ? Utils::convertDateTimeSistema($linha["data_hora_inicio"]) : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="data_final"> Data Hora Final</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control" placeholder="Data e Hora Final" value="<?=isset($linha["data_hora_fim"]) ? Utils::convertDateTimeSistema($linha["data_hora_fim"]) : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="data_garantia"> Data de Garantia</label>
            <div class="input-group">
                <input type="text" name="data_garantia" id="data_garantia" class="form-control" placeholder="Data Final da Garantia de Serviço" value="<?=isset($linha["data_garantia"]) ? Utils::convertDateTimeSistema($linha["data_garantia"],'d/m/Y') : ''?>">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-8">
            <label for="descricao">Descrição</label>
            <input name="descricao" id="descricao" class="form-control" placeholder="Digite uma descrição." value="<?=isset($linha["descricao"]) ? $linha["descricao"] : ''?>"/>
        </div>

        <div class="form-group col-md-4">
            <label for="ordem_status" class="error-label">Status O.S</label>
            <?php
            $ordemServico = new OrdemServico();
            $ordemStatus = $ordemServico->ListarOrdemStatus();

            Select::selectDefault("ordem_status", "ordem_status", $ordemStatus, isset($linha['id_ordem_servico_status']) ? $linha['id_ordem_servico_status'] : '', 'form-control select-obrigatorio');
            ?>
        </div>

    </div>
    <br><h4 style="color: #49b6d6">SERVIÇOS</h4><br>

    <div class="form-row">
        <div class="form-group col-md-10">
            <?php
            $servico = new Servico();
            $servicos = $servico->ListarSelect();

            Select::selectDefault("servico", "servico", $servicos, '')
            ?>
        </div>
        <div class="form-group col-md-2">
            <button type="button" id="adicionar_servico" class="btn btn-info col-md-12" onclick="AdicionarServico()">Adicionar</button>
        </div>
    </div>

    <?php require_once "tpl.lis.servico.php"?>

</form>