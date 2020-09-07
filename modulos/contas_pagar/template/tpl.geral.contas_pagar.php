<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 13/11/2018
 * Time: 00:45
 */
require_once ("js.geral.contas_pagar.php")?>

<div class="panel panel-inverse">
    <div class="panel-heading">
<!--        <div class="panel-heading-btn">-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
<!--        </div>-->
        <h4 class="panel-title">Contas a Pagar</h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <button type="button" id="adicionar" class="btn btn-primary col-md-1">Adicionar</button>
            <button type="button" id="excluir" class="btn btn-danger col-md-1">Excluir</button>
        </div>
        <div id="conteudo_contas_pagar"></div>
    </div>
</div>