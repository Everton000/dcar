<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 28/10/2018
 * Time: 16:49
 */
?>

<script type="text/javascript">

    function DialogFormulario(opcoes,manterBotoes)
    {

        if (typeof opcoes.ofset === "undefined") {
            opcoes.ofset = "70";
        }

        if (typeof opcoes.urlConteudo === "undefined") {
            console.log("url do dialog inválida");
            return false;
        }

        if (typeof opcoes.titulo === "undefined") {
            console.log("título do dialog inválido");
            return false;
        }

        if (typeof opcoes.width === "undefined") {
            console.log("width do dialog inválida");
            return false;
        }

        if (typeof opcoes.height === "undefined") {
            opcoes.height = 'auto';
        }

        if (typeof opcoes.closeable !== "boolean") {
            opcoes.closeable = "disable";
        }

        if (typeof opcoes.overflow === "undefined") {
            opcoes.overflow = "visible";
        }

        if(typeof opcoes.evento === "undefined")
        {
            opcoes.evento = function(){};
        }

        if (opcoes.closeable !== "disable") {
            if (!Array.isArray(opcoes.botoes)) {
                opcoes.botoes = [{
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-white btn-fechar",
                    btntext:  " Fechar",
                    callback: function( event ){ event.data.close()}
                }];
            } else {
                opcoes.botoes.unshift({
                    item:     "<button type='button'></button>",
                    event:    "click",
                    btnclass: "btn btn-white btn-fechar",
                    btntext:  " Fechar",
                    callback: function( event ){ event.data.close()}
                });
            }
        }

        var id = Date.now();

        /*
         * Verifica o tamanho do dialog e adiciona overflow, conforme necessidade
         * */
        $(document).one("ajaxStop", function(){

            $("body").css("overflow", "hidden");

            var div = $("#"+id), avoidDuplicate = false;

            MudarDiv();

            $(document).on("shown.bs.tab", function(){
                MudarDiv();
            });

            div.resize(function()
            {
                MudarDiv();
            });

            new ResizeSensor(div[0], function() {
                MudarDiv();
            });

            /*
             * Utiliza as bibliotecas: ElementQueries.js e ResizeSensor.js (includes no js.includes)
             * */
            function MudarDiv()
            {
                if (((div.height() * 100) / window.screen.height) > 60) {
                    div.css("max-height", "75vh");
                    div.css("overflow-y", "auto");
                    div.css("overflow-x", "hidden");
                } else {
                    div.css("overflow", "visible");
                }

                $(".panel-footer").css({"float" : "right"});
                $(".btn-salvar").css({"float" : "right", "margin-right" : "7px"});
                $(".btn-fechar").css("float", "right");
            }
        });

        var mypanel  = $.jsPanel({
            content:         $('<div id="'+id+'"></div>').load(opcoes.urlConteudo,opcoes.data),
            contentOverflow: opcoes.overflow,
            headerTitle:     opcoes.titulo,
            theme:           "bootstrap-inverse",
            contentSize:     {width: opcoes.width, height: opcoes.height},
            show:            'animated fadeInDownBig',
            paneltype: 		 "modal",
            position:        {my: "center-top", at: "center-top", autoposition: "top", offsetY: opcoes.ofset},
            onbeforeclose:  function(){eval(opcoes.evento);},
            headerControls: {
                close:     opcoes.closeable,
                maximize:  "enable",
                minimize:  "remove",
                normalize: "enable",
                smallify:  "remove"
            },

            footerToolbar: opcoes.botoes,
            onclosed: function() {
                $("body").css("overflow", "auto");
                CloseDiv();
            },
            callback: function() {
                var botoes = $("#" + id).closest(".jsPanel").find(".jsPanel-ftr").find("button");
                botoes.attr("data-loading-text", "<i class='fa fa-spinner fa-spin '></i>");
                if(!manterBotoes) {
                    botoes.on("ajaxStart", function () {
                        var $this = $(this);
                        $this.button('loading');

                        $(document).one("ajaxStop", function () {
                            $this.button('reset');
                        });
                    });
                }
                OpenDiv();
            }
        });

        return mypanel;

    }

    function OpenDiv()
    {
        $(".panel-footer").css({"float" : "right"});
        $(".btn-salvar").css({"float" : "right", "margin-right" : "7px"});
        $(".btn-fechar").css("float", "right");

        $('#mask').css({'width':maskWidth,'height':maskHeight});

        $('#mask').fadeTo("slow",0.7);
//        e.preventDefault();
    }

    function CloseDiv()
    {
        $('#mask, .window').hide();
//        e.preventDefault();
    }

    function ConfirmModal(titulo, texto, funcao, paramFuncao)
    {
        $("body").css("overflow", "hidden");

        var opcoes = {
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-warning btn-salvar",
                btntext:  "Sim",
                callback: function (event)
                {
                    eval(funcao)(paramFuncao);
                    event.data.close();
                }
            }]
        };

        opcoes.botoes.unshift({
            item:     "<button type='button'></button>",
            event:    "click",
            btnclass: "btn btn-white btn-fechar",
            btntext:  " Não",
            callback: function( event ){ event.data.close()}
        });


        var id = Date.now();

        /*
         * Verifica o tamanho do dialog e adiciona overflow, conforme necessidade
         * */
        $(document).one("ajaxStop", function(){

            var div = $("#"+id), avoidDuplicate = false;

            MudarDiv();

            $(document).on("shown.bs.tab", function(){
                MudarDiv();
            });

            div.resize(function()
            {
                MudarDiv();
            });


            /*
             * Utiliza as bibliotecas: ElementQueries.js e ResizeSensor.js (includes no js.includes)
             * */
            function MudarDiv()
            {
                if (((div.height() * 100) / window.screen.height) > 60) {
                    div.css("max-height", "75vh");
                    div.css("overflow-y", "auto");
                    div.css("overflow-x", "hidden");
                } else {
                    div.css("overflow", "visible");
                }

                $(".panel-footer").css({"float" : "right"});
                $(".btn-salvar").css({"float" : "right", "margin-right" : "7px"});
                $(".btn-fechar").css("float", "right");
            }
        });

        var mypanel  = $.jsPanel({
            content:         '<div id="'+id+'"></div><h1 style="font-size: 13px; color: #717879;">'+texto+'</h1>',
            contentOverflow: 'visible',
            headerTitle:     titulo,
            theme:           "panel panel-warning",
            contentSize:     {width: '30vw', height: 'auto'},
            show:            'animated fadeInDownBig',
            paneltype: 		 "modal",
            position:        {my: "center-top", at: "center-top", autoposition: "top", offsetY: 220},
            onbeforeclose:  function(){eval(opcoes.evento);},
            headerControls: {
                close:     true,
                maximize:  "enable",
                minimize:  "remove",
                normalize: "enable",
                smallify:  "remove"
            },

            footerToolbar: opcoes.botoes,
            onclosed: function() {
                $("body").css("overflow", "auto");
                CloseDiv();
            },
            callback: function() {
                var botoes = $("#" + id).closest(".jsPanel").find(".jsPanel-ftr").find("button");
                botoes.attr("data-loading-text", "<i class='fa fa-spinner fa-spin '></i>");
                botoes.on("ajaxStart", function () {
                    var $this = $(this);
                    $this.button('loading');

                    $(document).one("ajaxStop", function () {
                        $this.button('reset');
                    });
                });
                OpenDiv();
            }
        });

        return mypanel;

    }

    function Alerta(titulo, texto)
    {
        $("body").css("overflow", "hidden");

        var opcoes = {
            botoes:      [{
                item:     "<button type='button'></button>",
                event:    "click",
                btnclass: "btn btn-warning btn-salvar",
                btntext:  "Tudo bem",
                callback: function (event)
                {
                    event.data.close();
                }
            }]
        };

        var id = Date.now();

        /*
         * Verifica o tamanho do dialog e adiciona overflow, conforme necessidade
         * */
        $(document).one("ajaxStop", function(){

            var div = $("#"+id), avoidDuplicate = false;

            MudarDiv();

            $(document).on("shown.bs.tab", function(){
                MudarDiv();
            });

            div.resize(function()
            {
                MudarDiv();
            });


            /*
             * Utiliza as bibliotecas: ElementQueries.js e ResizeSensor.js (includes no js.includes)
             * */
            function MudarDiv()
            {
                if (((div.height() * 100) / window.screen.height) > 60) {
                    div.css("max-height", "75vh");
                    div.css("overflow-y", "auto");
                    div.css("overflow-x", "hidden");
                } else {
                    div.css("overflow", "visible");
                }

                $(".panel-footer").css({"float" : "right"});
                $(".btn-salvar").css({"float" : "right", "margin-right" : "7px"});
                $(".btn-fechar").css("float", "right");
            }
        });

        var mypanel  = $.jsPanel({
            content:         '<div id="'+id+'"></div><h1 style="font-size: 13px; color: #717879;">'+texto+'</h1>',
            contentOverflow: 'visible',
            headerTitle:     titulo,
            theme:           "panel panel-warning",
            contentSize:     {width: '30vw', height: 'auto'},
            show:            'animated fadeInDownBig',
            paneltype: 		 "modal",
            position:        {my: "center-top", at: "center-top", autoposition: "top", offsetY: 220},
            onbeforeclose:  function(){eval(opcoes.evento);},
            headerControls: {
                close:     true,
                maximize:  "enable",
                minimize:  "remove",
                normalize: "enable",
                smallify:  "remove"
            },

            footerToolbar: opcoes.botoes,
            onclosed: function() {
                $("body").css("overflow", "auto");
                CloseDiv();
            },
            callback: function() {
                var botoes = $("#" + id).closest(".jsPanel").find(".jsPanel-ftr").find("button");
                botoes.attr("data-loading-text", "<i class='fa fa-spinner fa-spin '></i>");
                botoes.on("ajaxStart", function () {
                    var $this = $(this);
                    $this.button('loading');

                    $(document).one("ajaxStop", function () {
                        $this.button('reset');
                    });
                });
                OpenDiv();
            }
        });

        return mypanel;

    }

</script>
