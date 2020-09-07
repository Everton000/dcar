<?php require_once "js.agendamento.php";?>


<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
    <li class="breadcrumb-item"><a href="javascript:;" onclick="Dashboard()">Home</a></li>
    <li class="breadcrumb-item active">Agendamentos</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header">Agendamentos <small></small></h1>
<!--<hr class="bg-grey-lighter" />-->

<!-- end page-header -->
<div class="panel panel-inverse panel-with-tabs" data-sortable-id="ui-unlimited-tabs-1" style="">
    <!-- begin panel-heading -->
    <div class="panel-heading p-0 ui-sortable-handle">
<!--        <div class="panel-heading-btn m-r-10 m-t-10">-->
<!--            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--        </div>-->
        <!-- begin nav-tabs -->
        <div class="tab-overflow overflow-right">
            <ul class="nav nav-tabs nav-tabs-inverse">
                <li class="nav-item prev-button" style=""><a href="javascript:;" data-click="prev-tab" class="nav-link text-success"><i class="fa fa-arrow-left"></i></a></li>
                <li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link active show" onclick="AlternarBackground(0)">Calendário</a></li>
                <li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link" onclick="AlternarBackground(1)">Listagem</a></li>
                <li class="nav-item next-button" style=""><a href="javascript:;" data-click="next-tab" class="nav-link text-success"><i class="fa fa-arrow-right"></i></a></li>
            </ul>
        </div>
        <!-- end nav-tabs -->
    </div>
    <!-- end panel-heading -->
    <!-- begin tab-content -->
    <div class="tab-content" id="background_listagem_agendamento" style="background-color: #ebefed">
        <!-- begin tab-pane -->
        <div class="tab-pane fade active show" id="nav-tab-1">
<!--            <h3 class="m-t-10">Calendário</h3>-->

            <div id="calendar" class="vertical-box-column calendar"></div>

        </div>
        <!-- end tab-pane -->
        <!-- begin tab-pane -->
        <div class="tab-pane fade" id="nav-tab-2">


<!--            <div class="panel panel-inverse">-->
<!--                <div class="panel-heading">-->
<!--                    <div class="panel-heading-btn">-->
<!--                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>-->
<!--                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>-->
<!--                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>-->
<!--                    </div>-->
<!--                    <h4 class="panel-title">Forma de Pagamento</h4>-->
<!--                </div>-->
<!--                <div class="panel-body">-->
<!--                    <div class="form-group">-->
                        <button type="button" id="adicionar" class="btn btn-primary col-md-1">Adicionar</button>
                        <button type="button" id="excluir" class="btn btn-danger col-md-1">Excluir</button>
<!--                    </div>-->
                    <div id="conteudo_agendamento"></div>
<!--                </div>-->
<!--            </div>-->

        </div>

        <!-- end tab-pane -->
    </div>
    <!-- end tab-content -->
</div>


<!-- begin vertical-box -->
<!--<div class="vertical-box">-->
    <!-- begin event-list -->
<!--    <div class="vertical-box-column p-r-30 d-none d-lg-table-cell" style="width: 215px">-->
<!--        <div id="external-events" class="fc-event-list">-->
<!--            <h5 class="m-t-0 m-b-15">Eventos</h5>-->
<!--            <div class="fc-event" data-color="#00acac"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-success"></i></div> Meeting with Client</div>-->
<!--            <div class="fc-event" data-color="#348fe2"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-primary"></i></div> IOS App Development</div>-->
<!--            <div class="fc-event" data-color="#f59c1a"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-warning"></i></div> Group Discussion</div>-->
<!--            <div class="fc-event" data-color="#ff5b57"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-danger"></i></div> New System Briefing</div>-->
<!--            <div class="fc-event"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-inverse"></i></div> Brainstorming</div>-->
<!--            <hr class="bg-grey-lighter m-b-15" />-->
<!--            <h5 class="m-t-0 m-b-15">Outros Eventos</h5>-->
<!--            <div class="fc-event" data-color="#b6c2c9"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div> Other Event 1</div>-->
<!--            <div class="fc-event" data-color="#b6c2c9"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div> Other Event 2</div>-->
<!--            <div class="fc-event" data-color="#b6c2c9"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div> Other Event 3</div>-->
<!--            <div class="fc-event" data-color="#b6c2c9"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div> Other Event 4</div>-->
<!--            <div class="fc-event" data-color="#b6c2c9"><div class="fc-event-icon"><i class="fas fa-circle fa-fw f-s-9 text-grey"></i></div> Other Event 5</div>-->
<!--        </div>-->
<!--    </div>-->
    <!-- end event-list -->
    <!-- begin calendar -->
    <!-- end calendar -->
<!--</div>-->
<!-- end vertical-box -->

<!--PARA REQUISIÇÃO AJAX RESTARTA OS PLUGINS DOS GRÁFICOS-->
<?if(!empty(IS_AJAX)){?>
    <script>
        App.restartGlobalFunction();

        $.when(
            $.getScript('assets/plugins/fullcalendar/lib/moment.min.js'),
            $.getScript('assets/plugins/fullcalendar/fullcalendar.min.js'),
            $.getScript('assets/plugins/fullcalendar/lang/pt-br.js'),
//            $.getScript('assets/js/demo/calendar.demo.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            Calendar.init();
        });
    </script>
<?}
?>