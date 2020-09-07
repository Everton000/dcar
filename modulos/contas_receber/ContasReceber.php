<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 02:35
 */
class ContasReceber
{
    private $id;
    private $idOrdemServico;
    private $idFormaPagamento;
    private $idUsuario;
    private $idContaReceberStatus;
    private $numeroFatura;
    private $valor;
    private $dataPagamento;
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

    public function getIdFormaPagamento()
    {
        return $this->idFormaPagamento;
    }

    public function setIdFormaPagamento($idFormaPagamento)
    {
        $this->idFormaPagamento = $idFormaPagamento;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdContaReceberStatus()
    {
        return $this->idContaReceberStatus;
    }

    public function setIdContaReceberStatus($idContaReceberStatus)
    {
        $this->idContaReceberStatus = $idContaReceberStatus;
    }

    public function getNumeroFatura()
    {
        return $this->numeroFatura;
    }

    public function setNumeroFatura($numeroFatura)
    {
        $this->numeroFatura = $numeroFatura;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getDataPagamento()
    {
        return $this->dataPagamento;
    }

    public function setDataPagamento($dataPagamento)
    {
        $this->dataPagamento = $dataPagamento;
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

    public function ListarContaStatus()
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, rotulo AS value FROM contas_receber_status";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO contas_receber (
                                  id_forma_pagamento, id_usuario,
                                  numero_fatura, valor,
                                  data_hora_cadastro)
                 VALUES (:id_forma_pagamento,
                         :id_usuario, :numero_fatura,
                         :valor, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_forma_pagamento", $this->idFormaPagamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":numero_fatura", $this->numeroFatura, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_receber SET id_forma_pagamento = :id_forma_pagamento,
                valor = :valor
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_forma_pagamento", $this->idFormaPagamento, PDO::PARAM_INT);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem, $idCliente, $numeroFatura, $formaPagamento, $dataInicial, $dataFinal, $dataVencimento)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(contas_receber.id) AS total
                FROM contas_receber_ocorrencia
                    INNER JOIN contas_receber ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                    INNER JOIN contas_receber_status ON (contas_receber_status.id = contas_receber_ocorrencia.id_contas_receber_status)
                    INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico.id = ordem_servico_cliente_veiculo.id_ordem_servico)
                    INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                    INNER JOIN forma_pagamento ON (contas_receber.id_forma_pagamento = forma_pagamento.id)
                WHERE ordem_servico.data_hora_exclusao IS NULL AND contas_receber.data_hora_exclusao IS NULL
                AND contas_receber_ocorrencia.data_hora_pagamento IS NULL";

        if ($idCliente)
            $sqlTotal .= " AND cliente.id = :cliente";
        if ($numeroFatura)
            $sqlTotal .= " AND contas_receber.numero_fatura = :numero_fatura";
        if ($formaPagamento)
            $sqlTotal .= " AND forma_pagamento.id = :forma_pagamento";
        if ($dataInicial)
            $sqlTotal .= " AND contas_receber.data_hora_cadastro >= :data_inicial";
        if ($dataFinal)
            $sqlTotal .= " AND contas_receber.data_hora_cadastro <= :data_final";
        if ($dataVencimento)
            $sqlTotal .= " AND contas_receber_ocorrencia.data_vencimento = :data_vencimento";

        if ($busca)
        {
            $sqlTotal .= " AND (ordem_servico.id LIKE :numero_os OR contas_receber_status.rotulo LIKE :status
             OR forma_pagamento.rotulo LIKE :forma_pagamento
             OR contas_receber.data_hora_cadastro LIKE :data_hora_cadastro
             OR cliente.nome LIKE :cliente)";
        }

        $stmt = $pdo->prepare($sqlTotal);

        if ($idCliente)
            $stmt->bindParam(":cliente", $idCliente, PDO::PARAM_INT);
        if ($numeroFatura)
            $stmt->bindParam(":numero_fatura", $numeroFatura, PDO::PARAM_INT);
        if ($formaPagamento)
            $stmt->bindParam(":forma_pagamento", $formaPagamento, PDO::PARAM_INT);
        if ($dataInicial)
            $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal)
            $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);
        if ($dataVencimento)
            $stmt->bindParam(":data_vencimento", $dataVencimento, PDO::PARAM_STR);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":numero_os", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":forma_pagamento", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_cadastro", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();

        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT forma_pagamento.rotulo AS forma_pagamento,
                       contas_receber_ocorrencia.id_contas_receber_status,
                       contas_receber.id AS id_conta,
                       contas_receber.numero_fatura,
                       contas_receber.id_forma_pagamento,
                       contas_receber.data_hora_cadastro,
                       contas_receber_ocorrencia.data_vencimento,
                       contas_receber_ocorrencia.id,
                       contas_receber_ocorrencia.numero_ocorrencia AS parcelas,
                       contas_receber_ocorrencia.valor AS valor_parcelado,
                       contas_receber_ocorrencia.envio_email_cobranca,
                       ordem_servico.id AS numero_os,
                       cliente.nome AS cliente
                FROM contas_receber_ocorrencia
                    INNER JOIN contas_receber ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                    INNER JOIN contas_receber_status ON (contas_receber_status.id = contas_receber_ocorrencia.id_contas_receber_status)
                    INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico.id = ordem_servico_cliente_veiculo.id_ordem_servico)
                    INNER JOIN cliente ON (ordem_servico_cliente_veiculo.id_cliente = cliente.id)
                    INNER JOIN forma_pagamento ON (contas_receber.id_forma_pagamento = forma_pagamento.id)
                WHERE ordem_servico.data_hora_exclusao IS NULL AND contas_receber.data_hora_exclusao IS NULL
                AND contas_receber_ocorrencia.data_hora_pagamento IS NULL";

        if ($idCliente)
            $sql .= " AND cliente.id = :cliente";
        if ($numeroFatura)
            $sql .= " AND contas_receber.numero_fatura = :numero_fatura";
        if ($formaPagamento)
            $sql .= " AND forma_pagamento.id = :forma_pagamento";
        if ($dataInicial)
            $sql .= " AND contas_receber.data_hora_cadastro >= :data_inicial";
        if ($dataFinal)
            $sql .= " AND contas_receber.data_hora_cadastro <= :data_final";
        if ($dataVencimento)
            $sql .= " AND contas_receber_ocorrencia.data_vencimento = :data_vencimento";

        if ($busca)
        {
            $sql .= " AND (ordem_servico.id LIKE :numero_os OR contas_receber_status.rotulo LIKE :status
             OR forma_pagamento.rotulo LIKE :forma_pagamento
             OR contas_receber.data_hora_cadastro LIKE :data_hora_cadastro
             OR cliente.nome LIKE :cliente)";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY contas_receber_ocorrencia.data_vencimento";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($idCliente)
            $stmt->bindParam(":cliente", $idCliente, PDO::PARAM_INT);
        if ($numeroFatura)
            $stmt->bindParam(":numero_fatura", $numeroFatura, PDO::PARAM_INT);
        if ($formaPagamento)
            $stmt->bindParam(":forma_pagamento", $formaPagamento, PDO::PARAM_INT);
        if ($dataInicial)
            $stmt->bindParam(":data_inicial", $dataInicial, PDO::PARAM_STR);
        if ($dataFinal)
            $stmt->bindParam(":data_final", $dataFinal, PDO::PARAM_STR);
        if ($dataVencimento)
            $stmt->bindParam(":data_vencimento", $dataVencimento, PDO::PARAM_STR);

        if ($busca)
        {
            $stmt->bindParam(":numero_os", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":forma_pagamento", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_cadastro", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }

    public function gerarBaixa($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_receber_ocorrencia SET id_contas_receber_status = 1,
                data_hora_pagamento = NOW()
                WHERE id IN ('$id')";

        $stmt = $pdo->prepare($sql);
        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }

    public function estornarConta($idConta)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_receber SET data_hora_exclusao = NOW()
                WHERE id IN ('$idConta')";

        $stmt = $pdo->prepare($sql);
        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }

    public function buscarUltimaFatura()
    {
        $pdo = $this->conexao;

        $sql = "SELECT numero_fatura FROM contas_receber ORDER BY numero_fatura DESC LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        $numeroFatura = $dados['numero_fatura'];
        return $numeroFatura;
    }

    public function listarClienteEmailCobranca()
    {
        $pdo = $this->conexao;

        $sql = "SELECT cliente.*,
                       contas_receber_ocorrencia.numero_ocorrencia,
                       contas_receber_ocorrencia.data_vencimento,
                       contas_receber_ocorrencia.valor,
                       veiculo.modelo AS modelo_veiculo,
                       ordem_servico.data_hora_inicio
                FROM contas_receber_ocorrencia
                    INNER JOIN contas_receber ON (contas_receber.id = contas_receber_ocorrencia.id_contas_receber)
                    INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                    INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                    INNER JOIN veiculo ON (ordem_servico_cliente_veiculo.id_veiculo = veiculo.id)
                    INNER JOIN cliente ON (cliente.id = ordem_servico_cliente_veiculo.id_cliente)
                    WHERE contas_receber_ocorrencia.id IN ($this->id) AND cliente.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($usuarios === false)
            throw new Exception();

        return $usuarios;
    }

    public function emailCobrancaEnviado()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_receber_ocorrencia SET envio_email_cobranca = 1
                WHERE id IN ($this->id)";

        $stmt = $pdo->prepare($sql);
        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }

    public function listarContasOrdemServico($idOrdemServico)
    {
        $idOrdemServico = is_array($idOrdemServico) ? implode(',', $idOrdemServico) : $idOrdemServico;
        $pdo = $this->conexao;

        $sql = "SELECT COUNT(contas_receber.id) AS total FROM contas_receber
                INNER JOIN ordem_servico ON (ordem_servico.id_conta_receber = contas_receber.id)
                INNER JOIN contas_receber_ocorrencia ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                WHERE ordem_servico.id IN ($idOrdemServico)
                AND contas_receber.data_hora_exclusao IS NULL
                AND contas_receber_ocorrencia.data_hora_pagamento IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['total'] > 0)
            throw new Exception('Há conta(s) referente á essa(s) Ordem(s) de Serviço(s) em aberto.');

    }
}