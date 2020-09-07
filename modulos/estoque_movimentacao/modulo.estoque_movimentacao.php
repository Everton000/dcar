<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */

switch ($this->appComando)
{
    case "listar_estoque_movimentacao":

        $template = "tpl.geral.estoque_movimentacao.php";

        break;

    case "ajax_listar_estoque_movimentacao":

        $template = "tpl.lis.estoque_movimentacao.php";

        break;
}