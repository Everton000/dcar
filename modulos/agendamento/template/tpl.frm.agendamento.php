<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/11/2018
 * Time: 01:38
 */
require_once "js.frm.agendamento.php";
?>

<form method="post" name="form_agendamento" id="form_agendamento">

    <input type="hidden" name="visualicao" id="visualicao" value="<?=isset($visualização) ? $visualização : ''?>">

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="cliente" class="error-label">Cliente</label>
            <div class="input-group">
                <input type="hidden" name="id_cliente" id="id_cliente" class="input-obrigatorio" onchange="LimparVeiculo()" value="<?=isset($linha["id_cliente"]) ? $linha["id_cliente"] : ''?>">
                <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Cliente" onchange="LimparVeiculo()" value="<?=isset($linha["cliente"]) ? $linha["cliente"] : ''?>" <?=$disabled?>>
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="veiculo" class="error-label">Veículo</label>
            <div class="input-group">
                <input type="hidden" name="id_veiculo" id="id_veiculo" class="input-obrigatorio" value="<?=isset($linha["id_veiculo"]) ? $linha["id_veiculo"] : ''?>">
                <input type="text" name="veiculo" id="veiculo" class="form-control" placeholder="Veículo" value="<?=isset($linha["veiculo"]) ? $linha["veiculo"] : ''?>" <?=$disabled?>>
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
            </div>
        </div>

        <div class="form-group col-md-4">
            <label for="ordem_status" class="error-label">Status</label>
            <?php
            if (isset($linha) && strtotime($linha['data_inicial']) < strtotime(date("Y-m-d H:i:s")))
            {
                $agendamentoStatus = array(['id' => '0', 'value' => 'Excedido']);
                Select::selectDefault("status", "status", $agendamentoStatus, $agendamentoStatus[0]['id'], 'form-control select-obrigatorio', 'disabled="disabled"');
            }
            else
            {
                $agendamento = new Agendamento();
                $agendamentoStatus = $agendamento->listarStatus();
                Select::selectDefault("status", "status", $agendamentoStatus, isset($linha['id_status']) ? $linha['id_status'] : '', 'form-control select-obrigatorio');
            }
            ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="data_inicial" class="error-label"> Data Hora Inícial</label>
            <div class="input-group">
                <input type="text" name="data_inicial" id="data_inicial" class="form-control input-obrigatorio" placeholder="Data e Hora Inicial" value="<?=isset($linha["data_inicial"]) ? Utils::convertDateTimeSistema($linha["data_inicial"]) : $_REQUEST["data_inicial"]?>" <?=$disabled?>>
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="data_final" class="error-label"> Data Hora Final</label>
            <div class="input-group">
                <input type="text" name="data_final" id="data_final" class="form-control input-obrigatorio" placeholder="Data e Hora Final" value="<?=isset($linha["data_final"]) ? Utils::convertDateTimeSistema($linha["data_final"]) : $_REQUEST["data_final"]?>" <?=$disabled?>>
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="observacao">Observação</label>
            <textarea type="text" rows="3" class="form-control" id="observacao" name="observacao" placeholder="Informe a observação do agendamento." <?=$disabled?>><?=isset($linha['observacao']) ? $linha['observacao'] : ''?></textarea>
        </div>

    </div>

</form>
