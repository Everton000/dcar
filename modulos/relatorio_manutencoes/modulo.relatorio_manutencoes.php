<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:40
 */

switch ($this->appComando)
{
    case "listar_relatorio_manutencoes":

        $template = "tpl.geral.relatorio_manutencoes.php";

        break;

    case "ajax_listar_relatorio_manutencoes":

        $template = "tpl.lis.relatorio_manutencoes.php";

        break;

    case "listar_relatorio_manutencoes_pdf":

        $template = "tpl.lis.relatorio_manutencoes_pdf.php";

        break;
}