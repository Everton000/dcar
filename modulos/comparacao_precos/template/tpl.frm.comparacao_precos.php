<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 12/11/2018
 * Time: 23:13
 */
require_once "js.frm.comparacao_precos.php";
?>
<form method="post" name="form_comparacao" id="form_comparacao">

    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="codigo">Código Produto</label>
            <input type="text" name="codigo" id="codigo" class="form-control input-obrigatorio" placeholder="Código do Produto">
        </div>

    </div>

    <div class="form-group">
        <button type="button" id="listar" class="btn btn-info" onclick="AtualizarGridComparacaoPrecos()">Listar</button>
    </div>

</form>
