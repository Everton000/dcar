<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */
class EstoqueEntradas
{
    private $id;
    private $idProduto;
    private $idStatus;
    private $idUsuario;
    private $quantidadeCadastro;
    private $quantidadeDisponivel;
    private $valor;
    private $conexao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus)
    {
        $this->idStatus = $idStatus;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getQuantidadeCadastro()
    {
        return $this->quantidadeCadastro;
    }

    public function setQuantidadeCadastro($quantidadeCadastro)
    {
        $this->quantidadeCadastro = $quantidadeCadastro;
    }

    public function getQuantidadeDisponivel()
    {
        return $this->quantidadeDisponivel;
    }

    public function setQuantidadeDisponivel($quantidadeDisponivel)
    {
        $this->quantidadeDisponivel = $quantidadeDisponivel;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getConexao()
    {
        return $this->conexao;
    }

    public function setConexao($conexao)
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(produto_estoque.id) AS total
                FROM produto_estoque
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto_estoque.data_hora_exclusao IS NULL
                AND produto.data_hora_exclusao IS NULL";

        if ($busca)
            $sqlTotal .= " AND (produto.rotulo LIKE :produto OR fornecedor.nome LIKE :fornecedor)";

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":produto", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":fornecedor", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT produto_estoque.*, 
                      fornecedor.nome AS fornecedor,
                      produto.rotulo AS produto,
                      produto.valor,
                      SUM(produto.valor * produto_estoque.quantidade_cadastro) AS valor_total
                FROM produto_estoque
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto_estoque.data_hora_exclusao IS NULL
                AND produto.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (produto.rotulo LIKE :produto OR fornecedor.nome LIKE :fornecedor)";
        }

        $sql .= " GROUP BY produto_estoque.id";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY produto_estoque.id DESC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":produto", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":fornecedor", $busca, PDO::PARAM_STR);
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

        $sql = "INSERT INTO produto_estoque (id_produto, quantidade_cadastro,
                quantidade_disponivel, id_status, id_usuario, data_hora_cadastro)
                VALUES (:id_produto, :quantidade_cadastro, :quantidade_disponivel, 1 ,
                        :id_usuario, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_produto", $this->idProduto, PDO::PARAM_INT);
        $stmt->bindParam(":quantidade_cadastro", $this->quantidadeCadastro, PDO::PARAM_INT);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidadeDisponivel, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto_estoque.*, 
                      produto.rotulo AS produto,
                      produto.id AS id_produto,
                      produto.valor,
                      SUM(produto.valor * produto_estoque.quantidade_cadastro) AS valor_total
                FROM produto_estoque
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto_estoque.id = :id";

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

        $sql = "UPDATE produto_estoque SET id_produto = :id_produto,
                quantidade_cadastro = :quantidade_cadastro, quantidade_disponivel = :quantidade_disponivel
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_produto", $this->idProduto, PDO::PARAM_INT);
        $stmt->bindParam(":quantidade_cadastro", $this->quantidadeCadastro, PDO::PARAM_INT);
        $stmt->bindParam(":quantidade_disponivel", $this->quantidadeDisponivel, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE produto_estoque SET data_hora_exclusao = NOW()";

        $sql .= " WHERE produto_estoque.id IN ($id)";

        $stmt = $pdo->prepare($sql);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

}