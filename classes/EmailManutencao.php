<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 28/11/2018
 * Time: 08:41
 */
class EmailManutencao
{
    private $conexao;

    public function getConexao(): Conexao
    {
        return $this->conexao;
    }

    public function setConexao(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function __construct($manutencaoGeral = 1)
    {
        $this->conexao = new Conexao();
        $this->conexao->beginTransaction();
        try
        {
            $dadosEmail = $this->buscarVeiculosManutencao();

            $this->EnviarEmail($dadosEmail);

            $this->conexao->commit();
        }
        catch (PDOException | Error $error)
        {
            $this->conexao->rollBack();
        }
        catch (Exception $e)
        {
            $this->conexao->rollBack();
        }
    }

    //BUSCA VEÍCULOS COM 6 MESES OU MAIS SEM EFETUAR MANUTENÇÕES
    private function buscarVeiculosManutencao()
    {
        $dataExcedida = date("Y-m-d",strtotime(date("Y-m-d") . " -6 month"));

        $pdo = $this->conexao;

        $sql = "SELECT *, veiculo.id FROM veiculo
                INNER JOIN cliente ON (veiculo.id_cliente = cliente.id)
                WHERE (veiculo.data_ultima_manutencao < date(:data_excedida)
                AND veiculo.email_manutencao = 0
                OR veiculo.data_ultimo_email IS NOT NULL AND veiculo.data_ultimo_email < date(:data_excedida))
                AND veiculo.data_hora_exclusao IS NULL
                AND cliente.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':data_excedida', $dataExcedida, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function EnviarEmail($dadosEmail)
    {
        $dia = date('d');
        $mes = Utils::mesAtual();
        $ano = date('Y');
        $a = "'";

        foreach ($dadosEmail as $dados)
        {
            $html = '<!DOCTYPE html>
                <html lang="pt-br">
                <head>
                 </head>
                <body>
                        <div class="container">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p>Curitiba, '.$dia.' de '.$mes.' de '.$ano.'.</p>
                    
                                    <p>Prezado '.$dados['nome'].',
                    
                                    consta em nosso sistema que a sua útilma manutenção no veículo '.$dados['modelo'].'  na nossa mecânica, foi realizada somente na data '.Utils::convertDateTimeSistema($dados['data_ultima_manutencao'],'d/m/Y').'.</p>
                    
                                    <p>Isto é, há mais de 6 meses.</p>
                                    
                                    <p>Pedimos que venha nos visitar o quanto antes para realizar as manutenções gerais no seu veículo.</p>
                    
                                    <p>Se tiver dúvidas, por gentileza, entre em contato pelo telefone 3586-0626 ou 98420-4580.</p><br>
                    
                                    <p>Atenciosamente,</p><br>
                    
                                    <p>Administração D'.$a.' CAR.</p>
                            </div>
                        </div>
                    </div>
                </body>';

            $mailer = new Mailer($dados['email'], $dados['nome'], "Lembrete de Manutenção", "Manutenção", $html);
            $mailer->send();

            $this->atualizarPermicaoEmailManutencao($dados['id']);
        }
    }

    private function atualizarPermicaoEmailManutencao($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE veiculo SET email_manutencao = 1, data_ultimo_email = NOW() WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }
}