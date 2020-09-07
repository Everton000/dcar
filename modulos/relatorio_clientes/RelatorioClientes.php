<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:41
 */
class RelatorioClientes
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $filtro, $ordem, $cliente, $cidade, $bairro, $estado, $status, $dataInicial, $dataFinal)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(cliente.id) AS total
                     FROM cliente
                     INNER JOIN status ON (cliente.id_status = status.id)
                     WHERE cliente.data_hora_exclusao IS NULL";

        if ($cliente) $sqlTotal .= " AND cliente.id = :cliente";
        if ($cidade) $sqlTotal .= " AND cliente.cidade = :cidade";
        if ($bairro) $sqlTotal .= " AND cliente.bairro = :bairro";
        if ($estado) $sqlTotal .= " AND cliente.estado = :estado";
        if ($status) $sqlTotal .= " AND cliente.id_status = :status";
        if ($dataInicial) $sqlTotal .= " AND data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sqlTotal .= " AND data_hora_cadastro <= :data_final";

        $stmt = $pdo->prepare($sqlTotal);

        if ($cliente) $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
        if ($cidade) $stmt->bindParam(":cidade", $cidade, PDO::PARAM_STR);
        if ($bairro) $stmt->bindParam(":bairro", $bairro, PDO::PARAM_STR);
        if ($estado) $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        if ($status) $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT cliente.*, status.rotulo AS status
                FROM cliente
                INNER JOIN status ON (cliente.id_status = status.id)";

        if ($cliente) $sql .= " AND cliente.id = :cliente";
        if ($cidade) $sql .= " AND cliente.cidade = :cidade";
        if ($bairro) $sql .= " AND cliente.bairro = :bairro";
        if ($estado) $sql .= " AND cliente.estado = :estado";
        if ($status) $sql .= " AND cliente.id_status = :status";
        if ($dataInicial) $sql .= " AND data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sql .= " AND data_hora_cadastro <= :data_final";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY cliente.id DESC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($cliente) $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
        if ($cidade) $stmt->bindParam(":cidade", $cidade, PDO::PARAM_STR);
        if ($bairro) $stmt->bindParam(":bairro", $bairro, PDO::PARAM_STR);
        if ($estado) $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        if ($status) $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);
        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }
}