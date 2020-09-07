<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

session_start();
session_name("erp");

require_once("vendor/autoload.php");
require_once("config/autoload.php");

$application = new Application();
$application->dispatch();

//MANDA E-MAILS DE MANUTENÇÃO PARAR CLIENTES QUE PRECISAM QUANDO O USUÁRIO LOGA NO SISTEMA
if (isset($_REQUEST['login']) && $_REQUEST['login'] == 'true') {
    $email = new EmailManutencao();
}
?>