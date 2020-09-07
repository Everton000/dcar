<?php require_once "js.frm.forma_pagamento.php"?>

<form method="post" name="form_forma_pagamento" id="form_forma_pagamento">

    <div class="form-row">

        <div class="form-group col-md-12">
            <label class="error-label">Rótulo</label>
            <input type="text" name="rotulo" id="rotulo" class="form-control input-obrigatorio" placeholder="Digite uma forma de pagamento" value="<?=isset($linha["rotulo"]) ? $linha["rotulo"] : ''?>">
        </div>

    </div>

</form>

