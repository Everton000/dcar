<!DOCTYPE html>
<html lang="pr-br">
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
    <link href="assets/css/default/style.min.css" rel="stylesheet" />
    <link href="assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>
<body class="pace-top">
<!-- begin #page-loader -->
<div id="page-loader" class="fade show"><span class="spinner"></span></div>
<!-- end #page-loader -->

<!-- begin #page-container -->
<div id="page-container" class="fade">
    <!-- begin login -->
    <div class="login bg-black animated fadeInDown">
        <!-- begin brand -->
        <div class="login-header">
            <div class="brand">
                <span class="logo"></span> <b>D'CAR</b> / ERP
                <small>sistema integrado de gestão empresarial</small>
            </div>
            <div class="icon">
                <i class="fa fa-lock"></i>
            </div>
        </div>
        <!-- end brand -->
        <!-- begin login-content -->
        <div class="login-content">
            <form method="post" id="form-login" class="margin-bottom-0">
                <div class="form-group m-b-20">
                    <input type="text" id="usuario" name="usuario" class="form-control form-control-lg inverse-mode" placeholder="Usuário" required />
                </div>
                <div class="form-group m-b-20">
                    <input type="password" id="senha" name="senha" class="form-control form-control-lg inverse-mode" placeholder="Senha" required />
                </div>
                <div class="checkbox checkbox-css m-b-20">
                    <input type="checkbox" id="remember_checkbox" />
<!--                    <label for="remember_checkbox">-->
<!--                        Lembrar me-->
<!--                    </label>-->
                </div>
                <div class="login-buttons">
                    <button type="button" class="btn btn-success btn-block btn-lg" onclick="Entrar()">Entrar</button>
                </div>
                <br>
                <div id="div-resposta"></div>

            </form>
        </div>
        <!-- end login-content -->
    </div>
    <!-- end login -->

</div>
<!-- end page container -->

<!-- ================== BEGIN BASE JS ================== -->
<script src="assets/plugins/jquery/jquery-3.2.1.min.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="assets/plugins/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
<!--[if lt IE 9]>
<script src="assets/crossbrowserjs/html5shiv.js"></script>
<script src="assets/crossbrowserjs/respond.min.js"></script>
<script src="assets/crossbrowserjs/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/plugins/js-cookie/js.cookie.js"></script>
<script src="assets/js/theme/default.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END BASE JS ================== -->

<script>
    $(document).ready(function() {
        App.init();
    });
</script>

</body>
</html>
