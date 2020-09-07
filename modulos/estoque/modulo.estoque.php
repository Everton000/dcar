<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */

switch ($this->appComando)
{
    case "listar_estoque":

        $template = "tpl.geral.estoque.php";

        break;

    case "ajax_listar_estoque":

        $template = "tpl.lis.estoque.php";

        break;
}