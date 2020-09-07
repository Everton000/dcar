<?php require_once 'js.home.php'?>

<div class="panel panel-inverse">

    <div class="panel-heading">
        <h4 class="panel-title">Dashboard Financeiro</h4>
    </div>

    <div class="panel-body">

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-blue">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">CONTAS A RECEBER (MÊS ATUAL)</div>
                        <div class="stats-number"><?=$contasReceber?></div><br>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-green">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">CONTAS RECEBIDAS (MÊS ATUAL)</div>
                        <div class="stats-number"><?=$contasRecebidas?></div><br>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-orange-transparent-8">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">CONTAS A PAGAR (MÊS ATUAL)</div>
                        <div class="stats-number"><?=$contasPagar?></div><br>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="widget widget-stats bg-gradient-red">
                    <div class="stats-icon stats-icon-lg"><i class="fa fa-comment-alt fa-fw"></i></div>
                    <div class="stats-content">
                        <div class="stats-title">CONTAS PAGAS (MÊS ATUAL)</div>
                        <div class="stats-number"><?=$contasPagas?></div><br>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-lg-6">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="flot-chart-5">
                    <div class="panel-heading">
                        <h4 class="panel-title">Totais de Contas</h4>
                    </div>
                    <div class="panel-body">
                        <p>Contas<code>Recebidas</code>, <code>Pagas</code> e margem de <code>Lucro</code>.</p>
                        <div id="donut-chart" class="height-sm"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="flot-chart-3">
                    <div class="panel-heading">
                        <h4 class="panel-title">Contas Recebidas</h4>
                    </div>
                    <div class="panel-body">
                        <p>
                            Valores mensais aproximados de contas recebidas.
                        </p>
                        <div id="bar-chart" class="height-sm"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!--PARA REQUISIÇÃO AJAX RESTARTA OS PLUGINS DOS GRÁFICOS-->
<?if(!empty(IS_AJAX)){?>
    <script>
        App.restartGlobalFunction();

        $.when(
            $.getScript('assets/plugins/flot/jquery.flot.min.js'),
            $.getScript('assets/plugins/flot/jquery.flot.time.min.js'),
//            $.getScript('assets/plugins/flot/jquery.flot.resize.min.js'),
            $.getScript('assets/plugins/flot/jquery.flot.pie.min.js'),
            $.getScript('assets/plugins/flot/jquery.flot.stack.min.js'),
            $.getScript('assets/plugins/flot/jquery.flot.crosshair.min.js'),
            $.getScript('assets/plugins/flot/jquery.flot.categories.js'),
            $.Deferred(function( deferred ){
                $(deferred.resolve);
            })
        ).done(function() {
            Chart.init();
        });
    </script>
<?}?>
