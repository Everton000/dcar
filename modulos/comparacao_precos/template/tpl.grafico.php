<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/12/2018
 * Time: 15:54
 */
require_once "js.grafico.php";
?>

<hr>
<div class="row">

    <div class="col-lg-6">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="morris-chart-1" style="display: none">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                </div>
                <h4 class="panel-title">Morris Line Chart</h4>
            </div>
            <div class="panel-body">
                <h4 class="text-center">Audi Vehicles Sales Report in UK</h4>
                <div id="morris-line-chart" class="height-sm"></div>
            </div>
        </div>

    </div>
    <div class="col-lg-12">
        <h4 class="text-center">Vela</h4>
        <div id="morris-bar-chart" class="height-sm"></div>
    </div>
</div>
<!-- end row -->


<script>
    App.restartGlobalFunction();

    $.when(
        $.getScript('assets/plugins/morris/raphael.min.js'),
        $.getScript('assets/plugins/morris/morris.js'),
        $.Deferred(function( deferred ){
            $(deferred.resolve);
        })
    ).done(function() {
        MorrisChart.init();
    });
</script>
