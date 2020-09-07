<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 03:15
 */

switch ($this->appComando)
{
    case "listar_cliente_json":

        $cliente = new Cliente();
        $retorno = $cliente->listarClienteJson($_REQUEST['term']);

        echo json_encode($retorno);
        break;
}