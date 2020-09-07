<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 23:16
 */
class FormaPagamento
{
    private $id;
    private $rotulo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getRotulo()
    {
        return $this->rotulo;
    }

    public function setRotulo($rotulo)
    {
        $this->rotulo = $rotulo;
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
                FROM forma_pagamento";

        if ($busca)
            $sqlTotal .= " WHERE rotulo LIKE :rotulo";

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":rotulo", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM forma_pagamento";

        if ($busca)
        {
            $sql .= " WHERE rotulo LIKE :rotulo";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":rotulo", $busca, PDO::PARAM_STR);
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

        $sql = "INSERT INTO forma_pagamento (rotulo) VALUE (:rotulo)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":rotulo", $this->rotulo, PDO::PARAM_STR);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT *
                FROM forma_pagamento WHERE id = :id";

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

        $sql = "UPDATE forma_pagamento SET rotulo = :rotulo WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":rotulo", $this->rotulo, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "DELETE FROM forma_pagamento";

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

        $sql = "SELECT id, rotulo AS value FROM forma_pagamento";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}