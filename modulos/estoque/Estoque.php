<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */
class Estoque
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $filtro, $ordem, $idProduto, $idFornecedor, $idStatus)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(produto.id) AS total,
                            SUM(produto_estoque.quantidade_disponivel) AS quantidade_total_disponivel,
                            SUM(produto.valor * produto_estoque.quantidade_disponivel) AS valor_total
                FROM produto_estoque
                INNER JOIN produto_estoque_status ON (produto_estoque_status.id = produto_estoque.id_status)
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto_estoque.data_hora_exclusao IS NULL
                AND produto_estoque_status.id <> 2
                AND produto.data_hora_exclusao IS NULL";

        if ($idProduto) $sqlTotal .= " AND produto.id = :id_produto";
        if ($idFornecedor) $sqlTotal .= " AND fornecedor.id = :id_fornecedor";
        if ($idStatus) $sqlTotal .= " AND produto_estoque_status.id = :id_status";

        $stmt = $pdo->prepare($sqlTotal);

        if ($idProduto) $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        if ($idFornecedor) $stmt->bindParam(':id_fornecedor', $idFornecedor, PDO::PARAM_INT);
        if ($idStatus) $stmt->bindParam(':id_status', $idStatus, PDO::PARAM_INT);

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT produto_estoque.id,
                      SUM(produto_estoque.quantidade_disponivel) AS quantidade_disponivel,
                      SUM(produto_estoque.quantidade_cadastro) AS quantidade_cadastro,
                      fornecedor.nome AS fornecedor,
                      produto.rotulo AS produto,
                      produto_estoque_status.rotulo AS status,
                      produto.valor,
                      SUM(produto.valor * produto_estoque.quantidade_disponivel) AS valor_total
                FROM produto_estoque
                INNER JOIN produto_estoque_status ON (produto_estoque_status.id = produto_estoque.id_status)
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                WHERE produto_estoque.data_hora_exclusao IS NULL
                AND produto_estoque_status.id <> 2
                AND produto.data_hora_exclusao IS NULL";

        if ($idProduto) $sql .= " AND produto.id = :id_produto";
        if ($idFornecedor) $sql .= " AND fornecedor.id = :id_fornecedor";
        if ($idStatus) $sql .= " AND produto_estoque_status.id = :id_status";

        $sql .= " GROUP BY produto.id";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($idProduto) $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        if ($idFornecedor) $stmt->bindParam(':id_fornecedor', $idFornecedor, PDO::PARAM_INT);
        if ($idStatus) $stmt->bindParam(':id_status', $idStatus, PDO::PARAM_INT);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }

    public function listarProdutoStatus()
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, rotulo AS value
                FROM produto_estoque_status
                WHERE produto_estoque_status.id <> 2";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}