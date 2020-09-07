<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 17/10/2018
 * Time: 04:10
 */
class Produto
{
    private $id;
    private $idFornecedor;
    private $rotulo;
    private $valor;
    private $codigo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdFornecedor()
    {
        return $this->idFornecedor;
    }

    public function setIdFornecedor($idFornecedor)
    {
        $this->idFornecedor = $idFornecedor;
    }

    public function getRotulo()
    {
        return $this->rotulo;
    }

    public function setRotulo($rotulo)
    {
        $this->rotulo = $rotulo;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
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

        $sqlTotal = "SELECT COUNT(produto.id) AS total
                FROM produto
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto.data_hora_exclusao IS NULL";

        if ($busca)
            $sqlTotal .= " AND rotulo LIKE :rotulo OR fornecedor.nome LIKE :fornecedor OR valor LIKE :valor";

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":rotulo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":fornecedor", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":valor", $busca, PDO::PARAM_STR);        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT produto.*, 
                      fornecedor.nome AS fornecedor 
                      FROM produto
                      INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                      WHERE produto.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND rotulo LIKE :rotulo OR fornecedor.nome LIKE :fornecedor OR valor LIKE :valor";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":rotulo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":fornecedor", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":valor", $busca, PDO::PARAM_STR);
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

        $sql = "INSERT INTO produto (rotulo, valor, id_fornecedor, codigo) VALUE (:rotulo, :valor, :id_fornecedor, :codigo)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":rotulo", $this->rotulo, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);
        $stmt->bindParam(":id_fornecedor", $this->idFornecedor, PDO::PARAM_INT);
        $stmt->bindParam(":codigo", $this->codigo, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto.*,
                fornecedor.nome AS fornecedor,
                fornecedor.id AS id_fornecedor
                FROM produto 
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto.id = :id";

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

        $sql = "UPDATE produto SET rotulo = :rotulo, valor = :valor, id_fornecedor = :id_fornecedor, codigo = :codigo WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":rotulo", $this->rotulo, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);
        $stmt->bindParam(":id_fornecedor", $this->idFornecedor, PDO::PARAM_STR);
        $stmt->bindParam(":codigo", $this->codigo, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE produto SET data_hora_exclusao = NOW()";

        $sql .= " WHERE id IN ($id)";

        $stmt = $pdo->prepare($sql);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function listarFornecedorJson($param)
    {
        $pdo = $this->conexao;

        $sql = "SELECT id AS value, nome AS label FROM fornecedor 
                WHERE nome LIKE :nome AND data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $busca = "%$param%";
        $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarSelect()
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto.id, produto.rotulo AS value
                FROM produto
                INNER JOIN produto_estoque ON (produto.id = produto_estoque.id_produto)
                WHERE produto_estoque.id_status = 1 AND produto_estoque.quantidade_disponivel > 0
                AND  produto.data_hora_exclusao IS NULL
                GROUP BY produto.id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ListarProdutoListagemJson($id)
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto.id, rotulo, valor,
                produto_estoque.id AS id_produto_estoque, produto_estoque.quantidade_disponivel
                FROM produto
                INNER JOIN produto_estoque ON (produto.id = produto_estoque.id_produto) 
                WHERE produto.id = :id AND produto_estoque.id_status = 1
                AND produto.data_hora_exclusao IS NULL
                AND quantidade_disponivel > 0";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarProdutoJson($param)
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto.id AS value, produto.rotulo AS label,
                produto.valor AS param
                FROM produto
                WHERE rotulo LIKE :rotulo
                AND  produto.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $busca = "%$param%";
        $stmt->bindParam(":rotulo", $busca, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function bucarProdutoFornecedor($idFornecedor)
    {
        $idFornecedor = is_array($idFornecedor) ? implode(',', $idFornecedor) : $idFornecedor;
        $pdo = $this->conexao;

        $sql = "SELECT COUNT(produto.id) AS total
                FROM fornecedor
                INNER JOIN produto ON (produto.id_fornecedor = fornecedor.id)
                WHERE fornecedor.id IN ($idFornecedor)
                AND produto.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['total'] > 0)
            throw new Exception('Existem produtos desse fornecedor cadastrados no sistema.');

    }

    public function listarProdutosEstoque($idProduto)
    {
        $idProduto = is_array($idProduto) ? implode(',', $idProduto) : $idProduto;
        $pdo = $this->conexao;

        $sql = "SELECT COUNT(*) AS total FROM produto_estoque
                WHERE id_produto IN ($idProduto)
                AND data_hora_exclusao IS NULL
                AND id_status <> 2";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['total'] > 0)
            throw new Exception('Existem produtos cadastrados no estoque.');

    }
}