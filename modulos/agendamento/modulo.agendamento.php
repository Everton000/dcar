<?php
switch ($this->appComando)
{
    case "exibir_agendamento";

    $template = "tpl.agendamento.php";

    break;

    case "ajax_listar_calendario_agendamento":

        $agendamento = new Agendamento();
        $retorno = $agendamento->listarAgendamentoCalendario();
        $dados = $agendamento->agruparAgendamentoCalendario($retorno);

        echo json_encode($dados);
        break;

    case "frm_adicionar_agendamento":

        $disabled = '';
        $template = "tpl.frm.agendamento.php";

        break;

    case "adicionar_agendamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatorios =
                [
                    $_REQUEST["id_cliente"],
                    $_REQUEST["id_veiculo"],
                    $_REQUEST["status"],
                    $_REQUEST["data_inicial"],
                    $_REQUEST["data_final"]
                ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatorios);

            $agendamento = new Agendamento($pdo);
            $agendamento->setIdUsuario($_SESSION['id_usuario']);
            $agendamento->setIdCliente($_REQUEST['id_cliente']);
            $agendamento->setIdVeiculo($_REQUEST['id_veiculo']);
            $agendamento->setObservacao($_REQUEST['observacao']);
            $agendamento->setIdStatus($_REQUEST['status']);
            $agendamento->setDataInicio(Utils::convertDateTimeBanco($_REQUEST['data_inicial']));
            $agendamento->setDataFim(Utils::convertDateTimeBanco($_REQUEST['data_final']));

            $idAgendamento = $agendamento->adicionar();
            $agendamento->setId($idAgendamento);

            $agendamento->adicionarAgendamentoClienteManutencao();

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

    case "frm_editar_agendamento":

        $agendamento = new Agendamento();
        $agendamento->setId($_REQUEST['id']);
        $linha = $agendamento->editar();

        if (strtotime($linha['data_inicial']) < strtotime(date("Y-m-d H:i:s")))
        {
            $visualização = true;
            $disabled = 'disabled="disabled"';
        }
        else
        {
            $visualização = false;
            $disabled = '';
        }
        $template = "tpl.frm.agendamento.php";

        break;

    case "editar_agendamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatorios =
                [
                    $_REQUEST["id_cliente"],
                    $_REQUEST["id_veiculo"],
                    $_REQUEST["status"],
                    $_REQUEST["data_inicial"],
                    $_REQUEST["data_final"]
                ];

            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatorios);

            $agendamento = new Agendamento($pdo);
            $agendamento->setId($_REQUEST['id']);
            $agendamento->setIdCliente($_REQUEST['id_cliente']);
            $agendamento->setIdVeiculo($_REQUEST['id_veiculo']);
            $agendamento->setObservacao($_REQUEST['observacao']);
            $agendamento->setIdStatus($_REQUEST['status']);
            $agendamento->setDataInicio(Utils::convertDateTimeBanco(str_replace('/', '-', ($_REQUEST['data_inicial']))));
            $agendamento->setDataFim(Utils::convertDateTimeBanco(str_replace('/', '-', ($_REQUEST['data_final']))));

            $agendamento->modificar();

            $agendamento->modificarAgendamentoClienteManutencao();

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

    case "editar_data_agendamento":

        $agendamento = new Agendamento();
        $agendamento->setId($_REQUEST['id']);
        $agendamento->setDataInicio(Utils::convertDateTimeBanco($_REQUEST['data_inicial']));
        $agendamento->setDataFim(Utils::convertDateTimeBanco($_REQUEST['data_final']));
        $agendamento->modificarDataAgendamento();

        break;

    case "ajax_listar_agendamento":

        $template = "tpl.lis.agendamento.php";

        break;

    case "deletar_agendamento":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $agendamento = new Agendamento();
            $agendamento->deletar($_REQUEST['id']);

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