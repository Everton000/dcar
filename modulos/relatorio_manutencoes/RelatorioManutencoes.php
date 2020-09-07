<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:41
 */
class RelatorioManutencoes
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $filtro, $ordem, $cliente, $veiculo, $numero_os, $dataInicial, $dataFinal)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(ordem_servico.id) AS total,
                            SUM(contas_receber.valor) AS valor_total
                     FROM ordem_servico
                     INNER JOIN contas_receber ON (ordem_servico.id_conta_receber = contas_receber.id)
                     INNER JOIN ordem_servico_status ON (ordem_servico.id_ordem_servico_status = ordem_servico_status.id)
                     INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                     INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                     INNER JOIN veiculo ON (ordem_servico_cliente_veiculo.id_veiculo = veiculo.id)
                     WHERE ordem_servico.data_hora_exclusao IS NULL";

        if ($cliente) $sqlTotal .= " AND cliente.id = :cliente";
        if ($veiculo) $sqlTotal  .= " AND veiculo.id = :veiculo";
        if ($numero_os) $sqlTotal  .= " AND ordem_servico.id = :numero_os";
        if ($dataInicial) $sqlTotal .= " AND ordem_servico.data_hora_inicio >= :data_inicial";
        if ($dataFinal) $sqlTotal .= " AND ordem_servico.data_hora_fim <= :data_final";

        $stmt = $pdo->prepare($sqlTotal);

        if ($cliente) $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
        if ($veiculo) $stmt->bindParam(":veiculo", $veiculo, PDO::PARAM_INT);
        if ($numero_os) $stmt->bindParam(":numero_os", $numero_os, PDO::PARAM_STR);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT ordem_servico.*,
                      ordem_servico_status.rotulo AS status,
                      cliente.nome AS cliente,
                      veiculo.placa,
                      veiculo.modelo AS veiculo,
                      contas_receber.valor
                FROM ordem_servico
                INNER JOIN contas_receber ON (ordem_servico.id_conta_receber = contas_receber.id)
                INNER JOIN ordem_servico_status ON (ordem_servico.id_ordem_servico_status = ordem_servico_status.id)
                INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                INNER JOIN veiculo ON (ordem_servico_cliente_veiculo.id_veiculo = veiculo.id)
                WHERE ordem_servico.data_hora_exclusao IS NULL";

        if ($cliente) $sql .= " AND cliente.id = :cliente";
        if ($veiculo) $sql  .= " AND veiculo.id = :veiculo";
        if ($numero_os) $sql  .= " AND ordem_servico.id = :numero_os";
        if ($dataInicial) $sql .= " AND ordem_servico.data_hora_inicio >= :data_inicial";
        if ($dataFinal) $sql .= " AND ordem_servico.data_hora_fim <= :data_final";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY ordem_servico.id DESC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($cliente) $stmt->bindParam(":cliente", $cliente, PDO::PARAM_INT);
        if ($veiculo) $stmt->bindParam(":veiculo", $veiculo, PDO::PARAM_INT);
        if ($numero_os) $stmt->bindParam(":numero_os", $numero_os, PDO::PARAM_STR);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }
}