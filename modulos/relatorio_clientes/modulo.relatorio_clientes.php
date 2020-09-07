<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:40
 */

switch ($this->appComando)
{
    case "listar_relatorio_clientes":

        $template = "tpl.geral.relatorio_clientes.php";

        break;

    case "ajax_listar_relatorio_clientes":

        $template = "tpl.lis.relatorio_clientes.php";

        break;

    case "listar_relatorio_clientes_pdf":

        $template = "tpl.lis.relatorio_clientes_pdf.php";

        break;
}