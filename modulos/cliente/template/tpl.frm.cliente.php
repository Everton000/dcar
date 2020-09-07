<?php require_once "js.frm.cliente.php"?>

<form method="post" name="form_cliente" id="form_cliente">

    <input type="hidden" id="id_cliente" name="id_cliente" value="<?=isset($linha['id']) ? $linha['id_cliente'] : ''?>">
    <input type="hidden" id="veiculo_listagem" name="veiculo_listagem" value="0">

    <ul class="nav nav-pills" id="myTab">
        <li class="nav-items">
            <a href="#nav-pills-tab-1" data-toggle="tab" class="nav-link active" id="tab_cliente">
                <span class="d-sm-none"></span>
                <span class="d-sm-block d-none">Dados Cliente</span>
            </a>
        </li>
        <li class="nav-items">
            <a href="#nav-pills-tab-2" data-toggle="tab" class="nav-link disabled" id="tab_veiculo">
                <span class="d-sm-none"></span>
                <span class="d-sm-block d-none">Dados Veiculo</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- begin tab-pane -->
        <div class="tab-pane fade active show" id="nav-pills-tab-1">
            <div id="div_cliente">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nome" class="error-label">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control input-obrigatorio" placeholder="Nome Completo" value="<?=isset($linha["nome"]) ? $linha["nome"] : ''?>">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" id="email" class="form-control" onchange="validarEmail(this)" placeholder="E-mail" value="<?=isset($linha["email"]) ? $linha["email"] : ''?>">
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-4">
                        <label for="cpf" class="error-label">CPF</label>
                        <input type="text" name="cpf" id="cpf" class="form-control cpf-obrigatorio mask-cpf" placeholder="CPF" onchange="ValidarCpf(this)" value="<?=isset($linha["cpf"]) ? $linha["cpf"] : ''?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="telefone" class="error-label">Telefone</label>
                        <input type="text" name="telefone" id="telefone" class="form-control input-obrigatorio mask-telefone" placeholder="Telefone" value="<?=isset($linha["telefone"]) ? $linha["telefone"] : ''?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nome">CEP</label>
                        <div class="input-group">
                            <input type="text" name="cep" id="cep" class="form-control mask-cep" placeholder="CEP" onchange="PesquisarCep(this)" value="<?=isset($linha["cep"]) ? $linha["cep"] : ''?>">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-search" style="cursor: pointer"></i></span></div>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="endereco" class="error-label">Endereço</label>
                        <input type="text" name="endereco" id="endereco" class="form-control input-obrigatorio" placeholder="Endereço" value="<?=isset($linha["endereco"]) ? $linha["endereco"] : ''?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="numero" class="error-label">Número</label>
                        <input type="text" name="numero" id="numero" class="form-control input-obrigatorio mask-numero" placeholder="Número" value="<?=isset($linha["numero"]) ? $linha["numero"] : ''?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="bairro" class="error-label">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control input-obrigatorio" placeholder="Bairro" value="<?=isset($linha["bairro"]) ? $linha["bairro"] : ''?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cidade" class="error-label">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control input-obrigatorio" placeholder="Cidade" value="<?=isset($linha["cidade"]) ? $linha["cidade"] : ''?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="estado" class="error-label">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control mask-uf input-obrigatorio" placeholder="Estado" value="<?=isset($linha["estado"]) ? $linha["estado"] : ''?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="ativo" class="error-label">Ativo</label><br>
                        <input type="checkbox" name="ativo" id="ativo" class="js-switch" <?=$checked['ativo']?>>
                    </div>
                </div>
            </div>
        </div>
        <!-- end tab-pane -->

        <!-- begin tab-pane -->
        <div class="tab-pane fade" id="nav-pills-tab-2">
            <div id="div_veiculo">
                <div class="form-row">

                    <input type="hidden" id="id_veiculo_edicao" value="">
                    <div class="form-group col-md-3">
                        <label for="modelo" class="error-label">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control input-obrigatorio" placeholder="Modelo">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="marca" class="error-label">Marca</label>
                        <input type="text" name="marca" id="marca" class="form-control input-obrigatorio" placeholder="Marca">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="placa" class="error-label">Placa</label>
                        <input type="text" name="placa" id="placa" class="form-control placa-obrigatorio mask-placa" placeholder="Placa">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="km" class="error-label">Quilometragem</label>
                        <input type="text" name="km" id="km" class="form-control mask-km input-obrigatorio" placeholder="Quilometragem">
                    </div>

                </div>

                <div class="form-row">

                    <div class="form-group col-md-6">
                        <label for="chassis" class="error-label">Chassis</label>
                        <input type="text" name="chassis" id="chassis" class="form-control input-obrigatorio" placeholder="Digite o número do Chassis">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="ano" class="error-label">Ano</label>
                        <input type="text" name="ano" id="ano" class="form-control input-obrigatorio mask-ano" placeholder="Ano">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="cor" class="error-label">Cor</label>
                        <input type="text" name="cor" id="cor" class="form-control input-obrigatorio mask-letras" placeholder="Cor">
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label class="error-label" for="veiculo_ativo">Ativo</label><br>
                        <input type="checkbox" name="veiculo_ativo" id="veiculo_ativo" class="js-switch">
                    </div>
                </div>

                <div class="form-group" style="margin-left: 32%" >
                    <button type="button" id="limpar_campos"  class="btn col-md-2" onclick="LimparInputs(this)">Limpar</button>
                    <button type="button" id="adicionar_veiculo"  class="btn btn-inverse col-md-2" onclick="AdicionarVeiculo()">Adicionar</button>
                    <button type="button" disabled id="modificar_veiculo" class="btn btn-inverse col-md-2" style="cursor: not-allowed" onclick="ModificarVeiculo()">Modificar</button>
                </div>

                <?php require_once ("modulos/veiculo/template/tpl.lis.veiculo.php")?>
            </div>
        </div>
    </div>
    <!-- end tab-pane -->


</form>

