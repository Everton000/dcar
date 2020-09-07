<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 04/10/2018
 * Time: 20:44
 */
switch($this->appComando) {
    case 'listar_fornecedor':

        $template = 'tpl.geral.fornecedor.php';

        break;

    case 'ajax_listar_fornecedor':

        $template = 'tpl.lis.fornecedor.php';

        break;

    case "frm_adicionar_fornecedor":

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = "";

        $template = "tpl.frm.fornecedor.php";

        break;

    case "adicionar_fornecedor":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            //ARRAY COM OS CAMPOS OBRIGATÓRIOS DO FORMULÁRIO
            $camposObrigatórios =
                [

                    $_REQUEST["nome"],
                    $_REQUEST["cnpj"],
                    $_REQUEST["endereco"],
                    $_REQUEST["numero"],
                    $_REQUEST["bairro"],
                    $_REQUEST["cidade"],
                    $_REQUEST["estado"],
                    $_REQUEST["telefone"],
                    $_REQUEST["email"]
                ];


            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $fornecedor = new Fornecedor($pdo);

            $fornecedor->setNome($_REQUEST["nome"]);
            $fornecedor->setCnpj($_REQUEST["cnpj"]);
            $fornecedor->setEndereco($_REQUEST["endereco"]);
            $fornecedor->setNumero($_REQUEST["numero"]);
            $fornecedor->setBairro($_REQUEST["bairro"]);
            $fornecedor->setCidade($_REQUEST["cidade"]);
            $fornecedor->setEstado($_REQUEST["estado"]);
            $fornecedor->setCidade($_REQUEST["cidade"]);
            $fornecedor->setCep($_REQUEST["cep"]);
            $fornecedor->setTelefone($_REQUEST["telefone"]);
            $fornecedor->setEmail($_REQUEST["email"]);
            $fornecedor->setSite($_REQUEST["site"]);
            //VALOR 1 = INATIVO / 2 = ATIVO
            @$fornecedor->setIdStatus(isset($_REQUEST["ativo"]) ? 2 : 1);
            $fornecedor->adicionarFornecedor();

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

    case "frm_editar_fornecedor":

        //BUSCA OS DADOS DO FORNECEDOR PARA EXIBIR NO FORMULÁRIO
        $fornecedor = new Fornecedor();
        $fornecedor->setId($_REQUEST["id"]);
        $linha = $fornecedor->editar();

        //VARIÁVEL QUE ATIVA O CHECKBOX
        $checked['ativo'] = $linha['id_status'] == 2 ? 'checked' : '';

        $template = "tpl.frm.fornecedor.php";

        break;

    case "editar_fornecedor":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            $camposObrigatórios =
                [

                    $_REQUEST["nome"],
                    $_REQUEST["cnpj"],
                    $_REQUEST["endereco"],
                    $_REQUEST["numero"],
                    $_REQUEST["bairro"],
                    $_REQUEST["cidade"],
                    $_REQUEST["estado"],
                    $_REQUEST["telefone"],
                    $_REQUEST["email"]
                ];


            //VALIDA CAMPOS
            Validacao::ValidarObrigatorio($camposObrigatórios);

            $fornecedor = new Fornecedor($pdo);


            $fornecedor->setId($_REQUEST["id"]);
            $fornecedor->setNome($_REQUEST["nome"]);
            $fornecedor->setCnpj($_REQUEST["cnpj"]);
            $fornecedor->setEndereco($_REQUEST["endereco"]);
            $fornecedor->setNumero($_REQUEST["numero"]);
            $fornecedor->setBairro($_REQUEST["bairro"]);
            $fornecedor->setCidade($_REQUEST["cidade"]);
            $fornecedor->setEstado($_REQUEST["estado"]);
            $fornecedor->setCidade($_REQUEST["cidade"]);
            $fornecedor->setCep($_REQUEST["cep"]);
            $fornecedor->setTelefone($_REQUEST["telefone"]);
            $fornecedor->setEmail($_REQUEST["email"]);
            $fornecedor->setSite($_REQUEST["site"]);
            //VALOR 1 = INATIVO / 2 = ATIVO
            $fornecedor->setIdStatus(isset($_REQUEST["ativo"]) ? 2 : 1);

            $fornecedor->modificar();

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();

        }
        catch (PDOException $error)
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

    case "validar_exclusao":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try
        {
            $contasReceber = new Produto($pdo);
            $contasReceber->bucarProdutoFornecedor($_REQUEST['id']);

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

    case "deletar_fornecedor":

        $pdo = new Conexao();
        $pdo->beginTransaction();

        try {
            $fornecedor = new fornecedor();
            $fornecedor->deletar($_REQUEST['id']);

            $msg["mensagem"] = "Operação realizada com sucesso!";
            $msg["codigo"] = 1;
            $pdo->commit();
        }
        catch (PDOException $error)
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