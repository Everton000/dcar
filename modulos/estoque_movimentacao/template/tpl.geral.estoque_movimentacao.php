<?php require_once ("js.geral.estoque_movimentacao.php")?>

<div class="panel panel-inverse">
    <div class="panel-heading">
<!--        <div class="panel-heading-btn">-->
<!--            <a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--            <a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>-->
<!--            <a href="javascript:" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
<!--        </div>-->
        <h4 class="panel-title">Histórico de Movimentações</h4>
    </div>
    <div class="panel-body">
        <div id="conteudo_form"><?php require_once "tpl.frm.estoque_movimentacao.php"?></div>
        <div id="conteudo_estoque_movimentacao"></div>
    </div>
</div>