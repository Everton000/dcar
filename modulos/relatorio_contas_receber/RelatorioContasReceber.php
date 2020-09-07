<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 13/11/2018
 * Time: 19:41
 */
class RelatorioContasReceber
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem, $idCliente, $numeroFatura, $formaPagamento, $receber, $recebidas, $dataInicial, $dataFinal, $dataVencimento)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(contas_receber_ocorrencia.id) AS total,
                            SUM(contas_receber_ocorrencia.valor) AS valor_total
                FROM contas_receber_ocorrencia
                    INNER JOIN contas_receber ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                    INNER JOIN contas_receber_status ON (contas_receber_status.id = contas_receber_ocorrencia.id_contas_receber_status)
                    INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico.id = ordem_servico_cliente_veiculo.id_ordem_servico)
                    INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                    INNER JOIN forma_pagamento ON (contas_receber.id_forma_pagamento = forma_pagamento.id)
                WHERE ordem_servico.data_hora_exclusao IS NULL AND contas_receber.data_hora_exclusao IS NULL";

        if ($idCliente) $sqlTotal .= " AND cliente.id = :cliente";
        if ($numeroFatura) $sqlTotal .= " AND contas_receber.numero_fatura = :numero_fatura";
        if ($formaPagamento) $sqlTotal .= " AND forma_pagamento.id = :forma_pagamento";
        if ($dataInicial) $sqlTotal .= " AND contas_receber.data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sqlTotal .= " AND contas_receber.data_hora_cadastro <= :data_final";
        if ($dataVencimento) $sqlTotal .= " AND contas_receber_ocorrencia.data_vencimento = :data_vencimento";
        if ($receber && $recebidas) $sqlTotal .= "";
        elseif ($receber) $sqlTotal .= " AND contas_receber_status.id = 2";
        elseif ($recebidas) $sqlTotal .= " AND contas_receber_status.id = 1";

        $stmt = $pdo->prepare($sqlTotal);

        if ($idCliente) $stmt->bindParam(":cliente", $idCliente, PDO::PARAM_INT);
        if ($numeroFatura) $stmt->bindParam(":numero_fatura", $numeroFatura, PDO::PARAM_INT);
        if ($formaPagamento) $stmt->bindParam(":forma_pagamento", $formaPagamento, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);
        if ($dataVencimento) $stmt->bindParam(":data_vencimento", $dataVencimento, PDO::PARAM_STR);

        $stmt->execute();

        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT forma_pagamento.rotulo AS forma_pagamento,
                       contas_receber_ocorrencia.id_contas_receber_status,
                       contas_receber.numero_fatura,
                       contas_receber.id_forma_pagamento,
                       contas_receber.data_hora_cadastro,
                       contas_receber_ocorrencia.data_vencimento,
                       contas_receber_ocorrencia.data_hora_pagamento,
                       contas_receber_ocorrencia.id,
                       contas_receber_ocorrencia.numero_ocorrencia AS parcelas,
                       contas_receber_ocorrencia.valor AS valor_parcelado,
                       ordem_servico.id AS numero_os,
                       cliente.nome AS cliente
                FROM contas_receber_ocorrencia
                    INNER JOIN contas_receber ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                    INNER JOIN contas_receber_status ON (contas_receber_status.id = contas_receber_ocorrencia.id_contas_receber_status)
                    INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico.id = ordem_servico_cliente_veiculo.id_ordem_servico)
                    INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                    INNER JOIN forma_pagamento ON (contas_receber.id_forma_pagamento = forma_pagamento.id)
                WHERE ordem_servico.data_hora_exclusao IS NULL AND contas_receber.data_hora_exclusao IS NULL";

        if ($idCliente) $sql .= " AND cliente.id = :cliente";
        if ($numeroFatura) $sql .= " AND contas_receber.numero_fatura = :numero_fatura";
        if ($formaPagamento) $sql .= " AND forma_pagamento.id = :forma_pagamento";
        if ($dataInicial) $sql .= " AND contas_receber.data_hora_cadastro >= :data_inicial";
        if ($dataFinal) $sql .= " AND contas_receber.data_hora_cadastro <= :data_final";
        if ($dataVencimento) $sql .= " AND contas_receber_ocorrencia.data_vencimento = :data_vencimento";
        if ($receber && $recebidas) $sql .= "";
        elseif ($receber) $sql .= " AND contas_receber_status.id = 2";
        elseif ($recebidas) $sql .= " AND contas_receber_status.id = 1";

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY contas_receber_ocorrencia.data_vencimento";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($idCliente) $stmt->bindParam(":cliente", $idCliente, PDO::PARAM_INT);
        if ($numeroFatura) $stmt->bindParam(":numero_fatura", $numeroFatura, PDO::PARAM_INT);
        if ($formaPagamento) $stmt->bindParam(":forma_pagamento", $formaPagamento, PDO::PARAM_INT);
        if ($dataInicial) $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal) $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);
        if ($dataVencimento) $stmt->bindParam(":data_vencimento", $dataVencimento, PDO::PARAM_STR);

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }

}