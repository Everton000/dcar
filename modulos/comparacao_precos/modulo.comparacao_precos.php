<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:40
 */

switch ($this->appComando)
{
    case "listar_comparacao_precos":

        $template = "tpl.geral.comparacao_precos.php";

        break;

    case "ajax_listar_comparacao_precos":

        $template = "tpl.lis.comparacao_precos.php";

        break;

    case "listar_grafico":

        $template = "tpl.grafico.php";

        break;

    case "ajax_listar_grafico":

        $comparacao = new ComparacaoPrecos();
        $dados = $comparacao->listarDadosGraficos($_REQUEST['codigo']);

        echo json_encode($dados);

        break;

}