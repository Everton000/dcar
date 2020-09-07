<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 06/11/2018
 * Time: 00:17
 */

switch ($this->appComando)
{
    case "listar_veiculo_json":

        $veiculo = new Veiculo();
        $retorno = $veiculo->listarVeiculoJson($_REQUEST['term'], $_REQUEST['filtro']);

        echo json_encode($retorno);

        break;
}