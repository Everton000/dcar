<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 20/11/2018
 * Time: 22:33
 */

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

session_start();
session_name("erp");

require_once("vendor/autoload.php");
require_once("config/autoload.php");

$application = new Application();
$application->dispatchPdf();