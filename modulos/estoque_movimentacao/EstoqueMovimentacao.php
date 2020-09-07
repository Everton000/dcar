<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 08/11/2018
 * Time: 08:09
 */
class EstoqueMovimentacao
{
    private $id;
    private $idProdutoEstoque;
    private $idUsuario;
    private $tipo;
    private $quantidade;
    private $conexao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdProdutoEstoque()
    {
        return $this->idProdutoEstoque;
    }

    public function setIdProdutoEstoque($idProdutoEstoque)
    {
        $this->idProdutoEstoque = $idProdutoEstoque;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $filtro, $ordem, $idProduto, $idFornecedor, $dataInicial, $dataFinal)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(movimentacao_estoque.id) AS total
                FROM movimentacao_estoque
                INNER JOIN produto_estoque ON (produto_estoque.id = movimentacao_estoque.id_produto_estoque)
                INNER JOIN usuario ON (usuario.id = movimentacao_estoque.id_usuario)
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)";

        if ($idProduto) $sqlTotal .= " AND produto.id = :id_produto";
        if ($idFornecedor) $sqlTotal .= " AND fornecedor.id = :id_fornecedor";
        if ($dataInicial) $sqlTotal .= " AND data_hora_movimentacao >= :data_inicial";
        if ($dataFinal) $sqlTotal .= " AND data_hora_movimentacao <= :data_final";

        $stmt = $pdo->prepare($sqlTotal);

        if ($idProduto) $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        if ($idFornecedor) $stmt->bindParam(':id_fornecedor', $idFornecedor, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT movimentacao_estoque.id,
                      produto.rotulo AS produto,
                      fornecedor.nome AS fornecedor,
                      movimentacao_estoque.quantidade,
                      movimentacao_estoque.tipo,
                      movimentacao_estoque.data_hora_movimentacao,
                      usuario.nome AS usuario
                FROM movimentacao_estoque
                INNER JOIN produto_estoque ON (produto_estoque.id = movimentacao_estoque.id_produto_estoque)
                INNER JOIN usuario ON (usuario.id = movimentacao_estoque.id_usuario)
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)";

        if ($idProduto) $sql .= " AND produto.id = :id_produto";
        if ($idFornecedor) $sql .= " AND fornecedor.id = :id_fornecedor";
        if ($dataInicial) $sql .= " AND data_hora_movimentacao >= :data_inicial";
        if ($dataFinal) $sql .= " AND data_hora_movimentacao <= :data_final";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY id DESC";
        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($idProduto) $stmt->bindParam(':id_produto', $idProduto, PDO::PARAM_INT);
        if ($idFornecedor) $stmt->bindParam(':id_fornecedor', $idFornecedor, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO movimentacao_estoque (id_produto_estoque, id_usuario, tipo, data_hora_movimentacao, quantidade)
                VALUES (:id_produto_estoque, :id_usuario, :tipo, NOW(), :quantidade)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_produto_estoque', $this->idProdutoEstoque, PDO::PARAM_INT);
        $stmt->bindParam(':id_usuario', $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(':tipo', $this->tipo, PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $this->quantidade, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }
}