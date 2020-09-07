<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:46
 */
require_once "js.geral.relatorio_contas_receber.php";
?>

<div class="panel panel-inverse">
    <div class="panel-heading">
<!--        <div class="panel-heading-btn">-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
<!--        </div>-->
        <h4 class="panel-title">Relatório de Contas a Receber/Recebidas</h4>
    </div>
    <div class="panel-body">
        <div id="conteudo_form"><?php require_once "tpl.frm.relatorio_contas_receber.php"?></div>
        <div id="conteudo_relatorio_contas_receber"></div>
    </div>
</div>
