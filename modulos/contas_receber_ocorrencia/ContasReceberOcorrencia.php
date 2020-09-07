<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 05/11/2018
 * Time: 23:23
 */
class ContasReceberOcorrencia
{
    private $id;
    private $idContasReceber;
    private $idStatus;
    private $valor;
    private $numeroOcorrencia;
    private $dataVencimento;
    private $conexao;

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus)
    {
        $this->idStatus = $idStatus;
    }

    public function getNumeroOcorrencia()
    {
        return $this->numeroOcorrencia;
    }

    public function setNumeroOcorrencia($numeroOcorrencia)
    {
        $this->numeroOcorrencia = $numeroOcorrencia;
    }

    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdContasReceber()
    {
        return $this->idContasReceber;
    }

    public function setIdContasReceber($idContasReceber)
    {
        $this->idContasReceber = $idContasReceber;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
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

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO contas_receber_ocorrencia (id_contas_receber, id_contas_receber_status,
                numero_ocorrencia, valor, data_vencimento)
                VALUES (:id_contas_receber, :id_contas_receber_status,
                :numero_ocorrencia, :valor, :data_vencimento)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_contas_receber", $this->idContasReceber, PDO::PARAM_INT);
        $stmt->bindParam(":id_contas_receber_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":numero_ocorrencia", $this->numeroOcorrencia, PDO::PARAM_INT);
        $stmt->bindParam(":data_vencimento", $this->dataVencimento, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_receber_ocorrencia SET valor = :valor, data_vencimento = :data_vencimento
                WHERE id_contas_receber = :id_contas_receber";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_contas_receber", $this->idContasReceber, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);
        $stmt->bindParam(":data_vencimento", $this->dataVencimento, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function deletar()
    {
        $pdo = $this->conexao;

        $sql = "DELETE FROM contas_receber_ocorrencia WHERE id_contas_receber = :id_contas_receber";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_contas_receber", $this->idContasReceber);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }
}