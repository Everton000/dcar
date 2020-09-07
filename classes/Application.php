<?php

class Application
{
    protected $appModulo;
    protected $appComando;
    protected $rotaModulo;

    public function __construct()
    {
        $this->appModulo = isset($_REQUEST['app_modulo']) ? $_REQUEST['app_modulo'] : 'home';
        $this->appComando = isset($_REQUEST['app_comando']) ? $_REQUEST['app_comando'] : 'home';
        $this->rotaModulo = "modulos" . DIRECTORY_SEPARATOR . $this->appModulo . DIRECTORY_SEPARATOR . "modulo." . $this->appModulo . ".php";
    }

    public function dispatch()
    {
        //QUANDO O USUÁRIO ESTIVER LOGADO
        if (isset($_SESSION['usuario']))
        {
            $this->dispatchModulos();
        }
        //QUANDO O USUÁRIO NÃO ESTIVER LOGADO
        else
        {
            $this->dispatchLogin();
        }
    }

    private function dispatchModulos()
    {
        //SE A REQUISIÇÃO NÃO FOR AJAX É INCLUIDO O CABEÇALHO DA PÁGINA
        if(empty(IS_AJAX) && $this->appComando != "logout")
        {
            require_once('template/header.php');
            require_once('includes/includes_js.php');
        }

        //INCLUI O MÓDULO
        if (file_exists($this->rotaModulo))
            require_once($this->rotaModulo);
        else
            require_once ("template/template_404.php");

        //CASO SEJA DEFINIDO UM TEMPLATE
        if (isset($template))
        {
            $rotaTemplate = 'modulos' . DIRECTORY_SEPARATOR . $this->appModulo . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $template;

            //INCLUI O TEMPLATE
            if (file_exists($rotaTemplate))
                require_once($rotaTemplate);
            else
                require_once ("template/template_404.php");
        }

        //SE A REQUISIÇÃO NÃO FOR AJAX É INCLUIDO O RODAPÉ DA PÁGINA
        if(empty(IS_AJAX) && $this->appComando != "logout")
        {
            //FOOTER PADRÃO
            if ($this->appModulo != "home" || $this->appModulo != "agendamento")
                require_once('template/footer.php');
            //FOOTER DO HOME
            elseif ($this->appModulo == "home")
                require_once('template/footer_home.php');
            //FOOTER DO CALENDÁRIO
            elseif ($this->appModulo == "agendamento")
                require_once('template/footer_calendar.php');
        }
    }

    private function dispatchLogin()
    {
        //LOGIN
        $login = isset($_REQUEST["login"]) ? $_REQUEST["login"] : "";
        if ($login == "on")
        {
            //INCLUI O MÓDULO
            if (file_exists($this->rotaModulo))
                require_once($this->rotaModulo);
            else
                require_once ("template/template_404.php");

            //CASO SEJA DEFINIDO UM TEMPLATE
            if (isset($template))
            {
                $rotaTemplate = 'modulos' . DIRECTORY_SEPARATOR . $this->appModulo . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $template;

                //INCLUI O TEMPLATE
                if (file_exists($rotaTemplate))
                    require_once($rotaTemplate);
                else
                    require_once ("template/template_404.php");
            }
        }
        else
        {
            //REDIRECIONA PARA A TELA DE LOGIN
            require_once("modulos/login/template/tpl.login.php");
            require_once("modulos/login/template/js.login.php");
        }
    }

    public function dispatchPdf()
    {
        //INCLUI O MÓDULO
        if (file_exists($this->rotaModulo))
            require_once($this->rotaModulo);
        else
            require_once ("template/template_404.php");

        //CASO SEJA DEFINIDO UM TEMPLATE
        if (isset($template))
        {
            $rotaTemplate = 'modulos' . DIRECTORY_SEPARATOR . $this->appModulo . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . $template;

            //INCLUI O TEMPLATE
            if (file_exists($rotaTemplate))
                require_once($rotaTemplate);
            else
                require_once ("template/template_404.php");
        }
    }
}