<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 04/09/2018
 * Time: 20:38
 */
class Home
{
    private $conexao;
    private $mes;

    /**
     * @return mixed
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * @param mixed $mes
     */
    public function setMes($mes)
    {
        $this->mes = $mes;
    }

    public function getConexao(): Conexao
    {
        return $this->conexao;
    }

    public function setConexao(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
    }

    public function somarTotalContasReceberMes()
    {
        $pdo = $this->conexao;

        $sql = "SELECT SUM(contas_receber_ocorrencia.valor) AS valor
                FROM contas_receber_ocorrencia
                INNER JOIN contas_receber ON (contas_receber.id = contas_receber_ocorrencia.id_contas_receber)
                WHERE id_contas_receber_status = 2
                AND EXTRACT(MONTH FROM data_vencimento) = :mes
                AND contas_receber.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mes', $this->mes, PDO::PARAM_STR);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dados === false)
            throw new Exception();

        return Utils::convertFloatSistema($dados->valor);
    }

    public function somarTotalContasRecebidasMes()
    {
        $pdo = $this->conexao;

        $sql = "SELECT SUM(contas_receber_ocorrencia.valor) AS valor
                FROM contas_receber_ocorrencia
                INNER JOIN contas_receber ON (contas_receber.id = contas_receber_ocorrencia.id_contas_receber)
                WHERE id_contas_receber_status = 1
                AND EXTRACT(MONTH FROM data_hora_pagamento) = :mes
                AND contas_receber.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mes', $this->mes, PDO::PARAM_STR);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dados === false)
            throw new Exception();

        return Utils::convertFloatSistema($dados->valor);
    }

    public function somarTotalContasPagarMes()
    {
        $pdo = $this->conexao;

        $sql = "SELECT SUM(valor) AS valor
                FROM contas_pagar
                WHERE id_status = 4
                AND EXTRACT(MONTH FROM vencimento) = :mes
                AND contas_pagar.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mes', $this->mes, PDO::PARAM_STR);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dados === false)
            throw new Exception();

        return Utils::convertFloatSistema($dados->valor);
    }

    public function somarTotalContasPagasMes()
    {
        $pdo = $this->conexao;

        $sql = "SELECT SUM(valor) AS valor
                FROM contas_pagar
                WHERE id_status = 1
                AND EXTRACT(MONTH FROM data_hora_pagamento) = :mes
                AND contas_pagar.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':mes', $this->mes, PDO::PARAM_STR);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_OBJ);

        if ($dados === false)
            throw new Exception();

        return Utils::convertFloatSistema($dados->valor);
    }

    public function listarTotalContas()
    {
        $pdo = $this->conexao;

        $sqlRecebidas = "SELECT SUM(contas_receber_ocorrencia.valor) AS valor
                FROM contas_receber_ocorrencia
                INNER JOIN contas_receber ON (contas_receber.id = contas_receber_ocorrencia.id_contas_receber)
                WHERE id_contas_receber_status = 1
                AND contas_receber.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sqlRecebidas);
        $stmt->execute();

        $contasRecebidas = $stmt->fetch(PDO::FETCH_OBJ);

        $sqlPagas = "SELECT SUM(valor) AS valor
                FROM contas_pagar
                WHERE id_status = 1
                AND contas_pagar.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sqlPagas);
        $stmt->execute();

        $contasPagas = $stmt->fetch(PDO::FETCH_OBJ);

        $lucro = round($contasRecebidas->valor - $contasPagas->valor, 2);

        //PARA SER EXIBIDO 0% POR CENTO NO GRÁFICO
        if ($lucro < 0)
            $lucro = '0.1';

        $retorno = [['label' => 'Recebidas', 'color' => 'COLOR_GREY', 'data' => $contasRecebidas->valor],
                    ['label' => 'Pagas',     'color' => 'COLOR_BLACK_LIGHTER', 'data' => $contasPagas->valor],
                    ['label' => 'Lucro',     'color' => 'COLOR_ORANGE', 'data' => $lucro]];

        return $retorno;
    }
}