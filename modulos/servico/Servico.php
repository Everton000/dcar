<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 23:16
 */
class Servico
{
    private $id;
    private $descricao;
    private $valor;
    private $conexao;

    public function getConexao(): Conexao
    {
        return $this->conexao;
    }

    public function setConexao(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
    }

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(id) AS total
                FROM servico";

        if ($busca)
            $sqlTotal .= " WHERE descricao LIKE :descricao";

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":descricao", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM servico";

        if ($busca)
        {
            $sql .= " WHERE descricao LIKE :descricao";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":descricao", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO servico (descricao, valor) VALUE (:descricao, :valor)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT *
                FROM servico WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados === false)
            throw new Exception();

        return $dados;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE servico SET descricao = :descricao, valor = :valor WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "DELETE FROM servico";

        $sql .= " WHERE id IN ($id)";

        $stmt = $pdo->prepare($sql);
        $idStatus = 1;

        $stmt->bindParam(":id", $idStatus, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function ListarSelect()
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, descricao AS value FROM servico";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ListarServicoListagemJson($id)
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, descricao, valor FROM servico WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}