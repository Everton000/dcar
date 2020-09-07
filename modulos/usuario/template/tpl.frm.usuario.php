<?php require_once "modulos/usuario/template/js.frm.usuario.php"?>

<form method="post" name="form_usuario" id="form_usuario">

    <input type="hidden" id="id_usuario" name="id_usuario" value="<?=isset($linha['id']) ? $linha['id'] : ''?>">

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="nome" class="error-label">Nome</label>
            <input type="text" name="nome" id="nome" class="form-control input-obrigatorio" placeholder="Nome" value="<?=isset($linha["nome"]) ? $linha["nome"] : ''?>">
        </div>
        <div class="form-group col-md-8">
            <label for="email" class="error-label">E-mail</label>
            <input type="text" name="email" id="email" class="form-control email-obrigatorio" onchange="validarEmail(this)" placeholder="E-mail" value="<?=isset($linha["email"]) ? $linha["email"] : ''?>">
        </div>
    </div>

    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="usuario" class="<?=$senhaObrigatorio?>">Usuário</label>
            <input type="text" name="usuario" id="usuario" class="form-control input-obrigatorio" placeholder="Usuário" value="<?=isset($linha["usuario"]) ? $linha["usuario"] : ''?>">
        </div>
        <div class="form-group col-md-4">
            <label for="senha" class="<?=$senhaObrigatorio?>">Senha</label>
            <input type="password" name="senha" id="senha" class="form-control" onchange="validarSenha()" placeholder="Senha">
        </div>
        <div class="form-group col-md-4">
            <label for="confirma_senha" class="error-label">Confirmar Senha</label>
            <input type="password" name="confirma_senha" id="confirma_senha" class="form-control confirma-senha-obrigatorio" onchange="validarSenha()" placeholder="Confirmar Senha">
        </div>

    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="pergunta_senha" class="error-label">Pergunta Senha</label>
            <input type="text" name="pergunta_senha" id="pergunta_senha" class="form-control input-obrigatorio" placeholder="Digite uma pergunta" value="<?=isset($linha["pergunta_senha"]) ? $linha["pergunta_senha"] : ''?>">
        </div>
        <div class="form-group col-md-6">
            <label for="resposta_senha" class="error-label">Resposta Senha</label>
            <input type="text" name="resposta_senha" id="resposta_senha" class="form-control input-obrigatorio" placeholder="Digite uma resposta" value="<?=isset($linha["resposta_senha"]) ? $linha["resposta_senha"] : ''?>">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="ativo" class="error-label">Ativo</label><br>
            <input type="checkbox" name="ativo" id="ativo" class="js-switch" <?=$checked['ativo']?>>
        </div>
        <div class="form-group col-md-6">
            <label for="master" class="error-label">Master</label><br>
            <input type="checkbox" name="master" id="master" class="js-switch" <?=$checked['master']?>>
        </div>
    </div>
</form>

