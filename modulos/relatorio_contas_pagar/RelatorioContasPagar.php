<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 22/11/2018
 * Time: 01:30
 */

class RelatorioContasPagar
{
    private $conexao;

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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem, $id_categoria, $vencimento, $dataInicial, $dataFinal, $id_status)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(contas_pagar.id) AS total,
                            SUM(contas_pagar.valor) AS valor_total
                FROM contas_pagar
                INNER JOIN contas_pagar_status ON (contas_pagar_status.id = contas_pagar.id_status)
                INNER JOIN categoria ON (categoria.id = contas_pagar.id_categoria)
                WHERE contas_pagar.data_hora_exclusao IS NULL";

        if ($id_categoria) $sqlTotal .= " AND contas_pagar.id_categoria = :id_categoria";
        if ($vencimento) $sqlTotal .= " AND contas_pagar.vencimento = :vencimento";
        if ($id_status) $sqlTotal .= " AND contas_pagar.id_status = :id_status";
        if ($dataInicial) $sqlTotal .= " AND contas_pagar.data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sqlTotal .= " AND contas_pagar.data_hora_cadastro <= :data_final";

        $stmt = $pdo->prepare($sqlTotal);

        if ($id_categoria) $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        if ($vencimento) $stmt->bindParam(":vencimento", $vencimento, PDO::PARAM_INT);
        if ($id_status) $stmt->bindParam(":id_status", $id_status, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->execute();

        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT contas_pagar_status.rotulo AS contas_pagar_status,
                       contas_pagar.id,
                       contas_pagar.descricao,
                       contas_pagar.id_categoria,
                       categoria.rotulo AS categoria,
                       contas_pagar.vencimento,
                       contas_pagar.data_hora_pagamento,
                       contas_pagar.valor,
                       contas_pagar.id_status,
                       contas_pagar.data_hora_cadastro
                FROM contas_pagar
                INNER JOIN contas_pagar_status ON (contas_pagar_status.id = contas_pagar.id_status)
                INNER JOIN categoria ON (categoria.id = contas_pagar.id_categoria)
                WHERE contas_pagar.data_hora_exclusao IS NULL";


        if ($id_categoria) $sql .= " AND contas_pagar.id_categoria = :id_categoria";
        if ($vencimento) $sql .= " AND contas_pagar.vencimento = :vencimento";
        if ($id_status) $sql .= " AND contas_pagar.id_status = :id_status";
        if ($dataInicial) $sql .= " AND contas_pagar.data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sql .= " AND contas_pagar.data_hora_cadastro <= :data_final";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY contas_pagar.id";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);


        if ($id_categoria) $stmt->bindParam(":id_categoria", $id_categoria, PDO::PARAM_INT);
        if ($vencimento) $stmt->bindParam(":vencimento", $vencimento, PDO::PARAM_INT);
        if ($id_status) $stmt->bindParam(":id_status", $id_status, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }
}