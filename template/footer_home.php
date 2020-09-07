
</div>
<!-- end #content -->


<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

<!--Início Rodapé-->
<div id="footer" class="footer">
    © 2018 Color Admin Responsive Admin Template - Sean Ngu All Rights Reserved
</div>
<!--Fim Rodapé-->

<!-- end scroll to top btn -->
</div>
<!-- end page container -->

<script>
    $(document).ready(function() {
        App.init();
    });

</script>
<!--INCLUI PLUGINS DO HOME -->
<script>
    App.restartGlobalFunction();

    $.getScript('https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.2/d3.min.js').done(function () {
        $.when(
            $.getScript('assets/plugins/nvd3/build/nv.d3.js'),
            $.getScript('assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js'),
            $.getScript('assets/plugins/jquery-jvectormap/jquery-jvectormap-world-merc-en.js'),
            $.getScript('assets/plugins/bootstrap-calendar/js/bootstrap_calendar.min.js'),
            $.getScript('assets/plugins/gritter/js/jquery.gritter.js'),
            $.Deferred(function (deferred) {
                $(deferred.resolve);
            })
        ).done(function () {
            $.getScript('assets/js/demo/dashboard-v2.min.js').done(function () {
                DashboardV2.init();
            });
        });
    });
</script>

</body>
</html>