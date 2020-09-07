<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 13/11/2018
 * Time: 00:10
 */

switch($this->appComando) {
    case 'listar_contas_pagar':

        $template = 'tpl.geral.contas_pagar.php';

        break;

    case 'ajax_listar_contas_pagar':

        $template = 'tpl.lis.contas_pagar.php';

        break;

    case "frm_adicionar_contas_pagar":

        $template = "tpl.frm.contas_pagar.php";

        break;

    case "adicionar_contas_pagar":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [

                    $_REQUEST["descricao"],
                    $_REQUEST["categoria"],
                    $_REQUEST["vencimento"],
                    $_REQUEST["valor"],
                    $_REQUEST["status"]

                ];


            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $contaspagar = new ContasPagar($pdo);

            //SE O STATUS FOR 'PAGO' É ADICIONADO A DATA DE PAGAMENTO
            $dataPagamento = $_REQUEST["status"] == 1 ? Utils::convertDateTimeBanco($_REQUEST["data_pagamento"]) : NULL;
            $contaspagar->setDescricao($_REQUEST["descricao"]);
            $contaspagar->setIdCategoria($_REQUEST["categoria"]);
            $contaspagar->setVencimento(Utils::convertDateTimeBanco($_REQUEST["vencimento"]));
            $contaspagar->setDataPagamento($dataPagamento);
            $contaspagar->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $contaspagar->setStatus($_REQUEST["status"]);

            //VALOR 1 = INATIVO / 2 = ATIVO

            $contaspagar->adicionar();

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();

        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {

            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;

    case "frm_editar_contas_pagar":

        //BUSCA OS DADOS DAS CONTAS PAGAR PARA EXIBIR NO FORMULÁRIO

        $contaspagar = new ContasPagar();
        $contaspagar->setId($_REQUEST["id"]);

        $linha = $contaspagar->editar();

//        var_dump($linha["vencimento"]); die();
        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = $linha['id_status'] == 2 ? 'checked' : '';

        $template = "tpl.frm.contas_pagar.php";

        break;

    case "editar_contas_pagar":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            $camposObrigatórios =
                [

                    $_REQUEST["descricao"],
                    $_REQUEST["categoria"],
                    $_REQUEST["vencimento"],
                    $_REQUEST["valor"],
                    $_REQUEST["status"],
                ];


            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $contaspagar = new ContasPagar($pdo);

            //SE O STATUS FOR 'PAGO' É ADICIONADO A DATA DE PAGAMENTO
            $dataPagamento = $_REQUEST["status"] == 1 ? Utils::convertDateTimeBanco($_REQUEST["data_pagamento"]) : NULL;
            $contaspagar->setId($_REQUEST["id"]);
            $contaspagar->setDescricao($_REQUEST["descricao"]);
            $contaspagar->setIdCategoria($_REQUEST["categoria"]);
            $contaspagar->setVencimento(Utils::convertDateTimeBanco($_REQUEST["vencimento"]));
            $contaspagar->setDataPagamento($dataPagamento);
            $contaspagar->setValor(Utils::convertFloatBanco($_REQUEST["valor"]));
            $contaspagar->setStatus($_REQUEST["status"]);


            $contaspagar->modificar();

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();

        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;


    case "deletar_contas_pagar":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            $contaspagar = new ContasPagar();
            $contaspagar->deletar($_REQUEST['id']);

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException | Error $error)
        {
            $msg["mensagem"] = "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }
        catch (Exception $e)
        {
            $msg["mensagem"] = $e->getMessage() ? $e->getMessage() : "Erro ao executar operação!";
            $msg["codigo"] = 0;
            $pdo->rollBack();
        }

        echo json_encode($msg);

        break;
}