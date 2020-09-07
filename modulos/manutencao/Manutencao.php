<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 31/10/2018
 * Time: 01:16
 */
class Manutencao
{
    private $id;
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

        $sqlTotal = "SELECT COUNT(ordem_servico.id) AS total
                FROM ordem_servico
                    INNER JOIN ordem_servico_status ON (ordem_servico_status.id = ordem_servico.id_ordem_servico_status)
                    INNER JOIN contas_receber ON (contas_receber.id = ordem_servico.id_conta_receber)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                    INNER JOIN cliente ON (cliente.id = ordem_servico_cliente_veiculo.id_cliente)
                    INNER JOIN veiculo ON (veiculo.id = ordem_servico_cliente_veiculo.id_veiculo)
                WHERE ordem_servico.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sqlTotal .= " AND (cliente.nome LIKE :cliente OR ordem_servico.id LIKE :numero
             OR veiculo.modelo LIKE :veiculo OR veiculo.placa LIKE :placa OR contas_receber.valor LIKE :valor
             OR ordem_servico.data_hora_cadastro LIKE :data_cadastro_manutencao)";
        }

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":numero", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":veiculo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":placa", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":valor", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_cadastro_manutencao", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT ordem_servico.id AS numero,
                       ordem_servico.data_hora_cadastro,
                       ordem_servico.data_hora_inicio AS data_cadastro_manutençao,
                       ordem_servico_status.rotulo AS ordem_servico_status,
                       cliente.nome AS cliente,
                       veiculo.placa AS veiculo,
                       veiculo.modelo,
                       contas_receber.valor
                FROM ordem_servico
                    INNER JOIN ordem_servico_status ON (ordem_servico_status.id = ordem_servico.id_ordem_servico_status)
                    INNER JOIN contas_receber ON (contas_receber.id = ordem_servico.id_conta_receber)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                    INNER JOIN cliente ON (cliente.id = ordem_servico_cliente_veiculo.id_cliente)
                    INNER JOIN veiculo ON (veiculo.id = ordem_servico_cliente_veiculo.id_veiculo)
                    WHERE ordem_servico.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (cliente.nome LIKE :cliente OR ordem_servico.id LIKE :numero
             OR veiculo.modelo LIKE :veiculo OR veiculo.placa LIKE :placa OR contas_receber.valor LIKE :valor
             OR ordem_servico.data_hora_cadastro LIKE :data_cadastro_manutencao)";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY ordem_servico.id DESC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":numero", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":veiculo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":placa", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":valor", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_cadastro_manutencao", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT ordem_servico.*,
                       cliente.nome AS cliente,
                       cliente.id AS id_cliente,
                       veiculo.modelo AS veiculo,
                       veiculo.id AS id_veiculo,
                       contas_receber.valor,
                       contas_receber.id AS id_contas_receber,
                       contas_receber.id_forma_pagamento AS id_forma_pagamento,
                       contas_receber.id AS id_contas_receber,
                       contas_receber.id AS id_contas_receber,
                       ordem_servico_cliente_veiculo.id AS id_cliente_veiculo,
                       contas_receber_ocorrencia.data_vencimento,
                       (SELECT COUNT(id) FROM contas_receber_ocorrencia WHERE contas_receber_ocorrencia.id_contas_receber = contas_receber.id) AS parcelas
                FROM ordem_servico
                    INNER JOIN contas_receber ON (contas_receber.id = ordem_servico.id_conta_receber)
                    INNER JOIN contas_receber_ocorrencia ON (contas_receber.id = contas_receber_ocorrencia.id_contas_receber)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                    INNER JOIN cliente ON (cliente.id = ordem_servico_cliente_veiculo.id_cliente)
                    INNER JOIN veiculo ON (veiculo.id = ordem_servico_cliente_veiculo.id_veiculo)
                    WHERE ordem_servico.id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados === false)
            throw new Exception();

        return $dados;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE ordem_servico
                LEFT JOIN contas_receber ON (contas_receber.id = ordem_servico.id_conta_receber)
                SET ordem_servico.data_hora_exclusao = NOW()
                WHERE ordem_servico.id IN ($id)";

        $stmt = $pdo->prepare($sql);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function atualizarEstoqueExclusao($idOrdem)
    {
        $pdo = $this->conexao;

        $sql = "SELECT * FROM ordem_servico_produto
                WHERE id_ordem_servico IN ($idOrdem)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($dados as $dado)
        {
            $sql = "UPDATE produto_estoque
                SET produto_estoque.quantidade_disponivel = quantidade_disponivel + 1
                WHERE produto_estoque.id = {$dado['id_produto_estoque']}";

            $stmt = $pdo->prepare($sql);

            $retorno = $stmt->execute();

            if($retorno === false)
                throw new Exception();
        }
    }
}