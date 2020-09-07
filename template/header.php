<!DOCTYPE html>
<!--[if IE 8]><html lang="pt-br" class="ie8"><![endif]-->
<!--[if !IE]><!-->
<html lang="pt-br">
<!--<![endif]-->
<head>
    <meta charset="utf-8" />
    <title>D'CAR - ERP</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="assets/css/default/style.css" rel="stylesheet" />
    <link href="assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <link href="assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-calendar/css/bootstrap_calendar.css" rel="stylesheet" />
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="assets/plugins/nvd3/build/nv.d3.css" rel="stylesheet" />
    <link href="assets/plugins/fullcalendar/fullcalendar.print.css" rel="stylesheet" media='print' />
    <link href="assets/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
    <link href="assets/plugins/toastr-master/build/toastr.css" rel="stylesheet"/>
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet"/>
    <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet"/>
    <link href="assets/plugins/morris/morris.css" rel="stylesheet" />

    <!--    <link href="assets/plugins/dataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>-->
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="assets/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script src="assets/crossbrowserjs/html5shiv.js"></script>
    <script src="assets/crossbrowserjs/respond.min.js"></script>
    <script src="assets/crossbrowserjs/excanvas.min.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/plugins/js-cookie/js.cookie.js"></script>
    <script src="assets/js/theme/default.min.js"></script>
    <script src="assets/js/apps.js"></script>
    <script src="assets/plugins/jspanel/jquery.jspanel-compiled.js"></script>
    <script src="assets/plugins/toastr-master/toastr.js"></script>
    <script src="assets/plugins/switchery/switchery.min.js"></script>
    <script src="assets/plugins/masked-input/mask-jquery/src/jquery.mask.js"></script>
    <script src="assets/plugins/masked-input/jquery.maskMoney.js"></script>
    <script src="assets/plugins/resize/src/ResizeSensor.js"></script>
    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/plugins/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.pt-BR.js"></script>
    <script src="assets/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>

    <!--    <script src='assets/plugins/fullcalendar/lang/pt-br.js'></script>-->
    <!-- ================== END BASE JS ================== -->
    <?php require_once('includes/includes_css.php'); ?>
</head>
<body>

<!--máscasra ajax-->
<div id="mask" style="position:absolute; z-index:90; background-color:#000; display:none"></div>
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="page-container fade page-sidebar-fixed page-header-fixed">
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
        <!-- begin navbar-header -->
        <div class="navbar-header">
            <a href="index.php?app_modulo=home&app_comando=home" class="navbar-brand"><span class="navbar-logo"></span> <b>D' Car</b> Admin</a>
            <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- end navbar-header -->

        <!-- begin header-nav -->
        <ul class="navbar-nav navbar-right">
<!--            <li>-->
<!--                <form class="navbar-form">-->
<!--                    <div class="form-group">-->
<!--                        <input type="text" class="form-control" placeholder="Buscar" />-->
<!--                        <button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>-->
<!--                    </div>-->
<!--                </form>-->
<!--            </li>-->
<!--            <li class="dropdown">-->
<!--                <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle f-s-14">-->
<!--                    <i class="fa fa-bell"></i>-->
<!--                    <span class="label">5</span>-->
<!--                </a>-->
<!--                <ul class="dropdown-menu media-list dropdown-menu-right">-->
<!--                    <li class="dropdown-header">NOTIFICATIONS (5)</li>-->
<!--                    <li class="media">-->
<!--                        <a href="javascript:;">-->
<!--                            <div class="media-left">-->
<!--                                <i class="fa fa-bug media-object bg-silver-darker"></i>-->
<!--                            </div>-->
<!--                            <div class="media-body">-->
<!--                                <h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>-->
<!--                                <div class="text-muted f-s-11">3 minutes ago</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="media">-->
<!--                        <a href="javascript:;">-->
<!--                            <div class="media-left">-->
<!--                                <img src="assets/img/user/user-1.jpg" class="media-object" alt="" />-->
<!--                                <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>-->
<!--                            </div>-->
<!--                            <div class="media-body">-->
<!--                                <h6 class="media-heading">John Smith</h6>-->
<!--                                <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>-->
<!--                                <div class="text-muted f-s-11">25 minutes ago</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="media">-->
<!--                        <a href="javascript:;">-->
<!--                            <div class="media-left">-->
<!--                                <img src="assets/img/user/user-2.jpg" class="media-object" alt="" />-->
<!--                                <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>-->
<!--                            </div>-->
<!--                            <div class="media-body">-->
<!--                                <h6 class="media-heading">Olivia</h6>-->
<!--                                <p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>-->
<!--                                <div class="text-muted f-s-11">35 minutes ago</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="media">-->
<!--                        <a href="javascript:;">-->
<!--                            <div class="media-left">-->
<!--                                <i class="fa fa-plus media-object bg-silver-darker"></i>-->
<!--                            </div>-->
<!--                            <div class="media-body">-->
<!--                                <h6 class="media-heading"> New User Registered</h6>-->
<!--                                <div class="text-muted f-s-11">1 hour ago</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="media">-->
<!--                        <a href="javascript:;">-->
<!--                            <div class="media-left">-->
<!--                                <i class="fa fa-envelope media-object bg-silver-darker"></i>-->
<!--                                <i class="fab fa-google text-warning media-object-icon f-s-14"></i>-->
<!--                            </div>-->
<!--                            <div class="media-body">-->
<!--                                <h6 class="media-heading"> New Email From John</h6>-->
<!--                                <div class="text-muted f-s-11">2 hour ago</div>-->
<!--                            </div>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="dropdown-footer text-center">-->
<!--                        <a href="javascript:;">View more</a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
            <li class="dropdown navbar-user">
                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="assets/img/user/user-13.jpg" alt="" />
                    <span class="d-none d-md-inline"><?=$_SESSION["nome_usuario"]?></span> <b class="caret"></b>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="javascript:;" class="dropdown-item" onclick="PerfilUsuario()">Perfil</a>
<!--                    <a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>-->
                    <a href="javascript:;" class="dropdown-item" onclick="Agendamento()">Calendário</a>
<!--                    <a href="javascript:;" class="dropdown-item">Configuração</a>-->
                    <div class="dropdown-divider"></div>
                    <a href="index.php?app_modulo=login&app_comando=logout" id="logout" class="dropdown-item">Log Out</a>
                </div>
            </li>
        </ul>
        <!-- end header navigation right -->
    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
        <!-- begin sidebar scrollbar -->
        <div data-scrollbar="true" data-height="100%">
            <!-- begin sidebar user -->
            <ul class="nav">
                <li class="nav-profile">
                    <a href="javascript:;" data-toggle="nav-profile">
                        <div class="cover with-shadow"></div>
                        <div class="image">
                            <img src="assets/img/user/user-13.jpg" alt="" />
                        </div>
                        <div class="info">
<!--                            <b class="caret pull-right"></b>-->
                            <?=$_SESSION["nome_usuario"]?>
                            <small>Administrador</small>
                        </div>
                    </a>
                </li>
<!--                <li>-->
<!--                    <ul class="nav nav-profile">-->
<!--                        <li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>-->
<!--                        <li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>-->
<!--                        <li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>
            <!-- end sidebar user -->
            <!-- begin sidebar nav -->
            <ul class="nav">
                <li class="nav-header">Navegação</li>
                <li class="has-sub">
                    <a href="javascript:;" onclick="Dashboard()">
                        <i class="fa fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li><a href="javascript:;" onclick="Agendamento()">
                        <i class="fa fa-calendar"></i><span>Agendamento</span></a>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-cubes"></i>
                        <span>Estoque</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="EstoqueEntradas()">Entradas</a></li>
                        <li><a href="javascript:;" onclick="EstoqueGerenciar()">Gerenciar</a></li>
                        <li><a href="javascript:;" onclick="EstoqueMovimentacao()">Histórico de Movimentações</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-plus-circle"></i>
                        <span>Cadastro</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="Cliente()">Cliente</a></li>
                        <li><a href="javascript:;" onclick="Fornecedor()">Fornecedor</a></li>
                        <li><a href="javascript:;" onclick="Produto()">Produto</a></li>
                        <li><a href="javascript:;" onclick="Servico()">Serviço</a></li>
                        <li><a href="javascript:;" onclick="FormaPagamento()">Forma de Pagamento</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-suitcase"></i>
                        <span>Comercial </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="Manutencao()">Manutenção</a></li>
                        <li><a href="javascript:;" onclick="OrdemServico()">Ordem de Serviço</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-dollar-sign"></i>
                        <span>Financeiro </span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="ContasReceber()">Contas a Receber </a></li>
                        <li><a href="javascript:;" onclick="ContasPagar()">Contas a Pagar </a></li>
                        <li><a href="javascript:;" onclick="ComparacaoPrecos()">Comparação de Preços </a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-list-ol"></i>
                        <span>Relatórios</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="RelatorioClientes()">Relatório de Clientes</a></li>
                        <li><a href="javascript:;" onclick="RelatorioManutencoes()">Relatório de Manutenções</a></li>
                        <li><a href="javascript:;" onclick="RelatorioContasReceber()">Relatório de Contas a Receber/Recebidas</a></li>
                        <li><a href="javascript:;" onclick="RelatorioContasPagar()">Relatório de Contas a Pagar/Pagas</a></li>
                    </ul>
                </li>
                <li class="has-sub">
                    <a href="javascript:;">
                        <b class="caret"></b>
                        <i class="fa fa-address-card"></i>
                        <span>Administração</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="javascript:;" onclick="Usuario()">Usuários</a></li>
                    </ul>
                </li>

                <!-- begin sidebar minify button -->
                <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
                <!-- end sidebar minify button -->
            </ul>
            <!-- end sidebar nav -->
        </div>
        <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content">
