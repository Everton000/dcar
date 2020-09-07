<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 02:03
 */
class OrdemServico
{
    private $id;
    private $idContaReceber;
    private $idCliente;
    private $idVeiculo;
    private $idClienteVeiculo;
    private $idUsuario;
    private $idServico;
    private $idServicoOrdemServico;
    private $idProduto;
    private $idOrdemServicoProduto;
    private $idOrdemServicoStatus;
    private $descricao;
    private $quilometragem;
    private $dataInicio;
    private $dataFim;
    private $dataGarantia;
    private $valorServico;
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

    public function getIdContaReceber()
    {
        return $this->idContaReceber;
    }

    public function setIdContaReceber($idContaReceber)
    {
        $this->idContaReceber = $idContaReceber;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    public function getIdVeiculo()
    {
        return $this->idVeiculo;
    }

    public function setIdVeiculo($idVeiculo)
    {
        $this->idVeiculo = $idVeiculo;
    }

    public function getIdClienteVeiculo()
    {
        return $this->idClienteVeiculo;
    }

    public function setIdClienteVeiculo($idClienteVeiculo)
    {
        $this->idClienteVeiculo = $idClienteVeiculo;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdServico()
    {
        return $this->idServico;
    }

    public function setIdServico($idServico)
    {
        $this->idServico = $idServico;
    }

    public function getIdServicoOrdemServico()
    {
        return $this->idServicoOrdemServico;
    }

    public function setIdServicoOrdemServico($idServicoOrdemServico)
    {
        $this->idServicoOrdemServico = $idServicoOrdemServico;
    }

    public function getIdProduto()
    {
        return $this->idProduto;
    }

    public function setIdProduto($idProduto)
    {
        $this->idProduto = $idProduto;
    }

    public function getIdOrdemServicoProduto()
    {
        return $this->idOrdemServicoProduto;
    }

    public function setIdOrdemServicoProduto($idOrdemServicoProduto)
    {
        $this->idOrdemServicoProduto = $idOrdemServicoProduto;
    }

    public function getIdOrdemServicoStatus()
    {
        return $this->idOrdemServicoStatus;
    }

    public function setIdOrdemServicoStatus($idOrdemServicoStatus)
    {
        $this->idOrdemServicoStatus = $idOrdemServicoStatus;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getQuilometragem()
    {
        return $this->quilometragem;
    }

    public function setQuilometragem($quilometragem)
    {
        $this->quilometragem = $quilometragem;
    }

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function setDataInicio($dataInicio)
    {
        $this->dataInicio = $dataInicio;
    }

    public function getDataFim()
    {
        return $this->dataFim;
    }

    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
    }

    public function getDataGarantia()
    {
        return $this->dataGarantia;
    }

    public function setDataGarantia($dataGarantia)
    {
        $this->dataGarantia = $dataGarantia;
    }

    public function getConexao(): Conexao
    {
        return $this->conexao;
    }

    public function setConexao(Conexao $conexao)
    {
        $this->conexao = $conexao;
    }

    public function getValorServico()
    {
        return $this->valorServico;
    }

    public function setValorServico($valorServico)
    {
        $this->valorServico = $valorServico;
    }

    public function getValorProduto()
    {
        return $this->valorProduto;
    }

    public function setValorProduto($valorProduto)
    {
        $this->valorProduto = $valorProduto;
    }

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
    }

    public function ListarOrdemStatus()
    {
        $pdo = $this->conexao;

        $sql = "SELECT ordem_servico_status.id, ordem_servico_status.rotulo AS value 
                FROM ordem_servico_status";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO ordem_servico (id_conta_receber, id_usuario, id_ordem_servico_status,
                                  descricao, quilometragem,
                                  data_hora_inicio, data_hora_fim, 
                                  data_garantia, data_hora_cadastro)
                 VALUES (:id_conta_receber, :id_usuario, :id_ordem_servico_status, :descricao,
                         :quilometragem, :data_hora_inicio,
                         :data_hora_fim,
                         :data_garantia,
                         NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_conta_receber", $this->idContaReceber, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_ordem_servico_status", $this->idOrdemServicoStatus, PDO::PARAM_INT);
        $stmt->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(":quilometragem", $this->quilometragem, PDO::PARAM_STR);
        $stmt->bindParam(":data_hora_inicio", $this->dataInicio, PDO::PARAM_INT);
        $stmt->bindParam(":data_hora_fim", $this->dataFim, PDO::PARAM_STR);
        $stmt->bindParam(":data_garantia", $this->dataGarantia, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE ordem_servico SET id_ordem_servico_status = :id_ordem_status,
                descricao = :descricao, quilometragem = :quilometragem, data_hora_inicio = :data_inicio,
                data_hora_fim = :data_fim, data_garantia = :data_garantia
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":id_ordem_status", $this->idOrdemServicoStatus);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":quilometragem", $this->quilometragem);
        $stmt->bindParam(":data_inicio", $this->dataInicio);
        $stmt->bindParam(":data_fim", $this->dataFim);
        $stmt->bindParam(":data_garantia", $this->dataGarantia);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT ordem_servico.*,
                       cliente.nome AS cliente,
                       cliente.id AS id_cliente,
                       veiculo.modelo AS veiculo,
                       veiculo.placa AS placa,
                       veiculo.id AS id_veiculo,
                       contas_receber.valor
                FROM ordem_servico
                INNER JOIN contas_receber ON (contas_receber.id = ordem_servico.id_conta_receber)
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
             OR veiculo.modelo LIKE :veiculo OR veiculo.placa LIKE :placa OR ordem_servico.data_hora_inicio LIKE :data_hora_inicio
             OR ordem_servico.data_hora_fim LIKE :data_hora_fim OR ordem_servico.data_hora_cadastro LIKE :data_hora_cadastro)";
        }

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":numero", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":veiculo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":placa", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_cadastro", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_inicio", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_fim", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT ordem_servico.id AS numero,
                       ordem_servico.data_hora_cadastro,
                       ordem_servico.data_hora_inicio,
                       ordem_servico.data_hora_fim,
                       ordem_servico.data_hora_cadastro,
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
             OR veiculo.modelo LIKE :veiculo OR veiculo.placa LIKE :placa OR ordem_servico.data_hora_inicio LIKE :data_hora_inicio
             OR ordem_servico.data_hora_fim LIKE :data_hora_fim OR ordem_servico.data_hora_cadastro LIKE :data_hora_cadastro)";
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
            $stmt->bindParam(":data_hora_cadastro", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_inicio", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":data_hora_fim", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }
}