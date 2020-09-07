<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:40
 */

switch ($this->appComando)
{
    case "listar_relatorio_contas_receber":

        $template = "tpl.geral.relatorio_contas_receber.php";

        break;

    case "ajax_listar_relatorio_contas_receber":

        $template = "tpl.lis.relatorio_contas_receber.php";

        break;

    case "listar_relatorio_contas_receber_pdf":

        $template = "tpl.lis.relatorio_contas_receber_pdf.php";

        break;
}