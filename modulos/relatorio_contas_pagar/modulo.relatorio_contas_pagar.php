<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 22/11/2018
 * Time: 01:33
 */
switch ($this->appComando)
{
    case "listar_relatorio_contas_pagar":

        $template = "tpl.geral.relatorio_contas_pagar.php";

        break;

    case "ajax_listar_relatorio_contas_pagar":

        $template = "tpl.lis.relatorio_contas_pagar.php";

        break;

    case "listar_relatorio_contas_pagar_pdf":

        $template = "tpl.lis.relatorio_contas_pagar_pdf.php";

        break;
}