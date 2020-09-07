<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 05/11/2018
 * Time: 22:53
 */
class OrdemServicoClienteVeiculo
{
    private $id;
    private $idOrdemServico;
    private $idCliente;
    private $idVeiculo;
    private $conexao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdOrdemServico()
    {
        return $this->idOrdemServico;
    }

    public function setIdOrdemServico($idOrdemServico)
    {
        $this->idOrdemServico = $idOrdemServico;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getIdVeiculo()
    {
        return $this->idVeiculo;
    }

    public function setIdVeiculo($idVeiculo)
    {
        $this->idVeiculo = $idVeiculo;
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

        $sql = "INSERT INTO ordem_servico_cliente_veiculo (id_ordem_servico, 
                                  id_cliente, id_veiculo)
                 VALUES (:id_ordem_servico, :id_cliente,
                         :id_veiculo)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ordem_servico", $this->idOrdemServico, PDO::PARAM_INT);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":id_veiculo", $this->idVeiculo, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE ordem_servico_cliente_veiculo SET
                    id_cliente = :id_cliente, id_veiculo = :id_veiculo
                    WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":id_veiculo", $this->idVeiculo, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function listarOrdemServicoCliente($idCliente)
    {
        $idCliente = is_array($idCliente) ? implode(',', $idCliente) : $idCliente;
        $pdo = $this->conexao;

        $sql = "SELECT COUNT(ordem_servico.id) AS total
                FROM ordem_servico_cliente_veiculo
                INNER JOIN ordem_servico ON (ordem_servico.id = ordem_servico_cliente_veiculo.id_ordem_servico)
                WHERE ordem_servico_cliente_veiculo.id_cliente IN ($idCliente)
                AND ordem_servico.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['total'] > 0)
            throw new Exception('Há movimentações referente a esse(s) cliente(s).');

    }
}