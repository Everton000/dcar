<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 05/11/2018
 * Time: 22:48
 */
class ServicoOrdemServico
{
    private $id;
    private $idOrdemServico;
    private $idServico;
    private $valorServico;
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

    public function getIdServico()
    {
        return $this->idServico;
    }

    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;
    }

    public function getValorServico()
    {
        return $this->valorServico;
    }

    public function setValorServico($valorServico)
    {
        $this->valorServico = $valorServico;
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

    public function listarServicoOrdemServico($ordemServico)
    {
        if ($ordemServico === '')
            return [];

        $pdo = $this->conexao;

        $sql = "SELECT servico.id, servico.descricao,
                servico_ordem_servico.id AS id_servico_ordem_servico,
                servico_ordem_servico.valor
                FROM servico_ordem_servico
                INNER JOIN servico ON (servico_ordem_servico.id_servico = servico.id)
                WHERE id_ordem_servico = :id_ordem_servico";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_ordem_servico', $ordemServico, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO servico_ordem_servico (id_ordem_servico, 
                                  id_servico, valor)
                 VALUES (:id_ordem_servico, :id_servico,
                         :valor)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ordem_servico", $this->idOrdemServico, PDO::PARAM_INT);
        $stmt->bindParam(":id_servico", $this->idServico, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valorServico, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE servico_ordem_servico SET valor = :valor
                WHERE id = :id_servico_ordem_servico AND id_servico = :id_servico
                        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_servico_ordem_servico", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_servico", $this->idServico, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valorServico, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar()
    {
        $pdo = $this->conexao;

        $sql = "DELETE FROM servico_ordem_servico WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }

}