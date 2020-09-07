<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 05/11/2018
 * Time: 22:51
 */
class OrdemServicoProduto
{
    private $id;
    private $idOrdemServico;
    private $idProdutoEstoque;
    private $valorProduto;
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

    public function getIdProdutoEstoque()
    {
        return $this->idProdutoEstoque;
    }

    public function setIdProdutoEstoque($idProdutoEstoque)
    {
        $this->idProdutoEstoque = $idProdutoEstoque;
    }

    public function getValorProduto()
    {
        return $this->valorProduto;
    }

    public function setValorProduto($valorProduto)
    {
        $this->valorProduto = $valorProduto;
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

    public function listar($ordemServico)
    {
        if ($ordemServico === '')
            return [];

        $pdo = $this->conexao;

        $sql = "SELECT ordem_servico_produto.id AS id_ordem_servico_produto,
                SUM(ordem_servico_produto.valor) AS valor,
                ordem_servico_produto.valor AS valor_unitario,
                produto.id, 
                produto.rotulo,
                produto_estoque.id AS id_produto_estoque,
                COUNT(produto_estoque.quantidade_disponivel) AS quantidade
                FROM ordem_servico_produto
                INNER JOIN ordem_servico ON (ordem_servico_produto.id_ordem_servico = ordem_servico.id)
                INNER JOIN produto_estoque ON (ordem_servico_produto.id_produto_estoque = produto_estoque.id)
                INNER JOIN produto ON (produto.id = produto_estoque.id_produto)
                WHERE id_ordem_servico = :id_ordem_servico 
                #AND produto_estoque.data_hora_exclusao IS NULL
                GROUP BY produto_estoque.id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_ordem_servico', $ordemServico, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO ordem_servico_produto (id_ordem_servico, 
                                  id_produto_estoque, valor)
                 VALUES (:id_ordem_servico, :id_produto_estoque,
                         :valor)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ordem_servico", $this->idOrdemServico, PDO::PARAM_INT);
        $stmt->bindParam(":id_produto_estoque", $this->idProdutoEstoque, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valorProduto, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        //DECREMENTA QUANTIDADE DE PRODUTO
        $sql = "UPDATE produto_estoque SET quantidade_disponivel = quantidade_disponivel-1 WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->idProdutoEstoque, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE ordem_servico_produto SET valor = :valor
                WHERE id_ordem_servico = :id_ordem_servico AND id_produto_estoque = :id_produto_estoque";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ordem_servico", $this->idOrdemServico, PDO::PARAM_INT);
        $stmt->bindParam(":id_produto_estoque", $this->idProdutoEstoque, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valorProduto, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function deletar($qtdHistoricoProduto)
    {
        $pdo = $this->conexao;

        $sql = "DELETE FROM ordem_servico_produto 
                WHERE id_ordem_servico = :id_ordem_servico AND id_produto_estoque = :id_produto_estoque";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_ordem_servico", $this->idOrdemServico, PDO::PARAM_INT);
        $stmt->bindParam(":id_produto_estoque", $this->idProdutoEstoque, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        //DECREMENTA QUANTIDADE DE PRODUTO
        $sql = "UPDATE produto_estoque SET id_status = 1,
                quantidade_disponivel = quantidade_disponivel + :qtd WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->idProdutoEstoque, PDO::PARAM_INT);
        $stmt->bindParam(":qtd", $qtdHistoricoProduto, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function atualizaStatusProdutoVendido()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE produto_estoque SET id_status = 2 WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->idProdutoEstoque, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function quantidadeProdutoDispinivel($idProduto)
    {
        $pdo = $this->conexao;

        $sql = "SELECT produto_estoque.quantidade_disponivel AS quantidade
                FROM produto_estoque 
                WHERE id = :id ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $idProduto, PDO::PARAM_INT);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        $quantidade = $stmt->fetch(PDO::FETCH_ASSOC);
        return $quantidade['quantidade'];
    }
}