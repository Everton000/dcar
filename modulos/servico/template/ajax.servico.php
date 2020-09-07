<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 03:50
 */
switch ($this->appComando)
{
    case "listar_servico_listagem_json":

        $servico = new Servico();
        $dados = $servico->ListarServicoListagemJson($_REQUEST['id_servico']);

        echo json_encode($dados);
        break;

}