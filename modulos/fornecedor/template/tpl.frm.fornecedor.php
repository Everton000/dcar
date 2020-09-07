<?php
require_once "modulos/fornecedor/template/js.frm.fornecedor.php"?>


<form method="post" name="form_fornecedor" id="form_fornecedor">

    <input type="hidden" id="id_fornecedor" name="id_fornecedor" value="<?=isset($linha['id']) ? $linha['id'] : ''?>">

    <div class="form-row">

        <div class="form-group col-md-4">
            <label class="error-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control input-obrigatorio" placeholder="Nome" value="<?=isset($linha["nome"]) ? $linha["nome"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label class="error-label">CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" class="form-control cnpj-obrigatorio mask-cnpj" placeholder="CNPJ" onchange="ValidarCnpj(this)" value="<?=isset($linha["cnpj"]) ? $linha["cnpj"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label class="error-label">Telefone</label>
            <input type="text" name="telefone" id="telefone" class="form-control input-obrigatorio mask-telefone" placeholder="Telefone" value="<?=isset($linha["telefone"]) ? $linha["telefone"] : ''?>">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label class="error-label">Email</label>
            <input type="text" name="email" id="email" class="form-control email-obrigatorio" onchange="validarEmail(this)" placeholder="E-mail" value="<?=isset($linha["email"]) ? $linha["email"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label>Site</label>
            <input type="text" name="site" id="site" class="form-control" placeholder="Ex: www.google.com.br" value="<?=isset($linha["site"]) ? $linha["site"] : ''?>">
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
            <label class="error-label">Endereço</label>
            <input type="text" name="endereco" id="endereco" class="form-control input-obrigatorio" placeholder="Endereço" value="<?=isset($linha["endereco"]) ? $linha["endereco"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label class="error-label">Numero</label>
            <input type="text" name="numero" id="numero" class="form-control mask-numero input-obrigatorio" placeholder="Numero" value="<?=isset($linha["numero"]) ? $linha["numero"] : ''?>">
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label class="error-label">Bairro</label>
            <input type="text" name="bairro" id="bairro" class="form-control input-obrigatorio" placeholder="Bairro" value="<?=isset($linha["bairro"]) ? $linha["bairro"] : ''?>">
        </div>

        <div class="form-group col-md-4">
            <label class="error-label">Cidade</label>
            <input type="text" name="cidade" id="cidade" class="form-control input-obrigatorio" placeholder="Cidade" value="<?=isset($linha["cidade"]) ? $linha["cidade"] : ''?>">
        </div>

        <div class="form-group col-md-2">
            <label class="error-label">Estado</label>
            <input type="text" name="estado" id="estado" class="form-control mask-uf input-obrigatorio" placeholder="Estado" value="<?=isset($linha["estado"]) ? $linha["estado"] : ''?>">
        </div>

        <div class="form-group col-md-2">
            <label for="ativo">Ativo</label><br>
            <input type="checkbox" name="ativo" id="ativo" class="js-switch" <?=$checked['ativo']?>>
        </div>

    </div>

</form>
