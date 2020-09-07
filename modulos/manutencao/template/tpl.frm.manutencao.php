<?php require_once "js.frm.manutencao.php";?>

<form method="post" name="form_manutencao" id="form_manutencao">

    <input type="hidden" id="id_manutencao" name="id_manutencao" value="<?=isset($linha['id']) ? $linha['id'] : ''?>">
    <input type="hidden" id="id_cliente_veiculo" name="id_cliente_veiculo" value="<?=isset($linha['id_cliente_veiculo']) ? $linha['id_cliente_veiculo'] : ''?>">
    <input type="hidden" id="id_contas_receber" name="id_contas_receber" value="<?=isset($linha['id_contas_receber']) ? $linha['id_contas_receber'] : ''?>">
    <input type="hidden" id="nav" name="nav" value="0">
    <input type="hidden" id="erro" name="erro" value="0">

    <ul class="nav nav-pills" id="myTab">
        <li class="nav-items">
            <a href="#nav-pills-tab-1" data-toggle="tab" class="nav-link active" id="tab_os">
                <span class="d-sm-none"></span>
                <span class="d-sm-block d-none">Ordem De Serviço</span>
            </a>
        </li>
        <li class="nav-items">
            <a href="#nav-pills-tab-2" data-toggle="tab" class="nav-link disabled" id="tab_produto">
                <span class="d-sm-none"></span>
                <span class="d-sm-block d-none">Produto</span>
            </a>
        </li>
        <li class="nav-items">
            <a href="#nav-pills-tab-3" data-toggle="tab" class="nav-link disabled" id="tab_financeiro">
                <span class="d-sm-none"></span>
                <span class="d-sm-block d-none">Financeiro</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane fade active show" id="nav-pills-tab-1">

            <div id="form_os" name="form_os">
                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="cliente" class="error-label">Cliente</label>
                        <div class="input-group">
                            <input type="hidden" name="id_cliente" id="id_cliente" class="input-obrigatorio" onchange="LimparVeiculo()" value="<?=isset($linha["id_cliente"]) ? $linha["id_cliente"] : ''?>">
                            <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Cliente" onchange="LimparVeiculo()" value="<?=isset($linha["cliente"]) ? $linha["cliente"] : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="veiculo" class="error-label">Veículo</label>
                        <div class="input-group">
                            <input type="hidden" name="id_veiculo" id="id_veiculo" class="input-obrigatorio" value="<?=isset($linha["id_veiculo"]) ? $linha["id_veiculo"] : ''?>">
                            <input type="text" name="veiculo" id="veiculo" class="form-control" placeholder="Veículo" value="<?=isset($linha["veiculo"]) ? $linha["veiculo"] : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
                        </div>
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
                            <input type="text" name="data_inicial" id="data_inicial" class="form-control input-obrigatorio mask-date-time" placeholder="Data e Hora Inicial" value="<?=isset($linha["data_hora_inicio"]) ? Utils::convertDateTimeSistema($linha["data_hora_inicio"]) : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="data_final"> Data Hora Final</label>
                        <div class="input-group">
                            <input type="text" name="data_final" id="data_final" class="form-control mask-date-time" placeholder="Data e Hora Final" value="<?=isset($linha["data_hora_fim"]) ? Utils::convertDateTimeSistema($linha["data_hora_fim"]) : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="data_garantia"> Data de Garantia</label>
                        <div class="input-group">
                            <input type="text" name="data_garantia" id="data_garantia" class="form-control mask-date" placeholder="Data Final da Garantia de Serviço" value="<?=isset($linha["data_garantia"]) ? Utils::convertDateTimeSistema($linha["data_garantia"], 'd/m/Y') : ''?>">
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
                    <?php
                    $servico = new Servico();
                    $servicos = $servico->ListarSelect();

                    Select::selectDefault("servico", "servico", $servicos, '', 'form-control col-md-10')
                    ?>

                    <div class="form-group col-md-2">
                        <button type="button" id="adicionar_servico" class="btn btn-info col-md-12" onclick="AdicionarServico()">Adicionar</button>
                    </div>
                </div>

                <?php require_once "modulos/ordem_servico/template/tpl.lis.servico.php" ?>

            </div>
        </div>
        <!-- end tab-pane -->

        <div class="tab-pane fade" id="nav-pills-tab-2">

            <h4 style="color: #49b6d6">PRODUTOS</h4><br>

            <div class="form-row">
                <?php
                $produto = new Produto();
                $produtos = $produto->ListarSelect();

                Select::selectDefault("produto", "produto", $produtos, '', 'form-control col-md-10');
                ?>

                <div class="form-group col-md-2">
                    <button type="button" id="adicionar_produto" class="btn btn-info col-md-12" onclick="AdicionarProduto()">Adicionar</button>
                </div>
            </div>

            <?php require_once "tpl.lis.produto.php"?>
        </div>

        <!-- begin tab-pane -->
        <div class="tab-pane fade" id="nav-pills-tab-3">

            <form id="form_financeiro" name="form_financeiro">

                <div class="form-row">

<!--                    <div class="form-group col-md-6">-->
<!--                        <label for="contaStatus" class="error-label">Status</label>-->
<!--                        --><?php
//                        $contaReceber = new ContasReceber();
//                        $contaStatus = $contaReceber->ListarContaStatus();
//
//                        Select::selectDefault("conta_status", "conta_status", $contaStatus, isset($linha['id_contas_receber_status']) ? $linha['id_contas_receber_status'] : '', 'form-control select-obrigatorio');
//                        ?>
<!--                    </div>-->

                    <div class="form-group col-md-6">
                        <label for="forma_pagamento" class="error-label">Forma de Pagamento</label>
                        <?php
                        $formaPagamento = new FormaPagamento();
                        $dadosFormaPagamento = $formaPagamento->ListarSelect();

                        Select::selectDefault("forma_pagamento", "forma_pagamento", $dadosFormaPagamento, isset($linha['id_forma_pagamento']) ? $linha['id_forma_pagamento'] : '', 'form-control select-obrigatorio');
                        ?>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="data_vencimento" class="error-label"> Data de Vencimento</label>
                        <div class="input-group">
                            <input type="text" name="data_vencimento" id="data_vencimento" class="form-control input-obrigatorio mask-date" placeholder="Data de Vencimento" value="<?=isset($linha["data_vencimento"]) ? Utils::convertDateTimeSistema($linha["data_vencimento"], 'd-m-Y') : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-calendar" style="cursor: pointer"></i></span></div>
                        </div>
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="valor" class="error-label">Valor</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                            <input type="text" name="valor" id="valor" readonly class="form-control input-money-obrigatorio mask-money" placeholder="Digite o valor do produto" value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="a" class="error-label">Parcelas</label>
                        <input type="text" name="parcelas" id="parcelas" class="parcelas form-control input-obrigatorio mask-parcelas" placeholder="Digite o número de parcelas" value="<?=isset($linha["parcelas"]) ? $linha["parcelas"] : 1?>">
                        <input type="hidden" name="parcelas_historico" id="parcelas_historico"value="<?=isset($linha["parcelas"]) ? $linha["parcelas"] : 1?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="valor" class="error-label">Valor Parcelado</label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">R$</span></div>
                            <input type="text" name="valor_parcelado" id="valor_parcelado" readonly class="form-control input-money-obrigatorio mask-money" placeholder="Digite o valor do produto" value="<?=isset($linha["valor"]) ? Utils::convertFloatSistema($linha["valor"]) : '0,00'?>">
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
    <!-- end tab-pane -->

</form>

