<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:41
 */
class ComparacaoPrecos
{
    private $conexao;

    /**
     * @return mixed
     */
    public function getConexao()
    {
        return $this->conexao;
    }

    /**
     * @param mixed $conexao
     */
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $filtro, $ordem, $codigo)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(produto.id) AS total
                     FROM produto
                     INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                     WHERE fornecedor.data_hora_exclusao IS NULL
                     AND produto.codigo = :codigo";

        $stmt = $pdo->prepare($sqlTotal);

        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_INT);

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT *
                FROM produto
                     INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                     WHERE fornecedor.data_hora_exclusao IS NULL
                     AND produto.codigo = :codigo
                     AND produto.data_hora_exclusao IS NULL";


        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY produto.id DESC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":codigo", $codigo, PDO::PARAM_INT);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }

    public function listarDadosGraficos($codigo)
    {
        $pdo = $this->conexao;
        $sql = "SELECT fornecedor.nome AS fornecedor,
                       produto.valor
                FROM produto
                     INNER JOIN fornecedor ON (fornecedor.id = produto.id_fornecedor)
                     WHERE fornecedor.data_hora_exclusao IS NULL
                     AND produto.codigo = :codigo
                     AND produto.data_hora_exclusao IS NULL";

        $sql .= " ORDER BY produto.id DESC";

        $sql .= " LIMIT 0, 20";
        $stmt = $pdo->prepare($sql);

        if ($codigo) $stmt->bindParam(":codigo", $codigo, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $retorno = [];
        $x = 0;
        foreach ($dados as $dado)
        {
            $retorno[$x]['device'] = $dado['fornecedor'];
            $retorno[$x]['geekbench'] = $dado['valor'];
            $x++;
        }
        return $retorno;
    }
}