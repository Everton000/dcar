<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/11/2018
 * Time: 22:58
 */
class Agendamento
{
    private $id;
    private $idStatus;
    private $idCliente;
    private $idVeiculo;
    private $idUsuario;
    private $dataInicio;
    private $dataFim;
    private $observacao;
    private $conexao;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus)
    {
        $this->idStatus = $idStatus;
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

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
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

    public function getObservacao()
    {
        return $this->observacao;
    }

    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
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

    public function listarStatus()
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, rotulo AS value FROM agenda_manutencao_status";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarAgendamentoCalendario()
    {
        $pdo = $this->conexao;

        $sql = "SELECT agenda_manutencao.id,
                       data_hora_inicio AS data_inicio,
                       data_hora_fim AS data_fim,
                       agenda_manutencao.id_status AS status,
                       cliente.nome AS cliente
                FROM agenda_manutencao
                INNER JOIN agenda_manutencao_cliente_veiculo ON (agenda_manutencao_cliente_veiculo.id_agenda_manutencao = agenda_manutencao.id)
                INNER JOIN cliente ON (cliente.id = agenda_manutencao_cliente_veiculo.id_cliente)
                WHERE agenda_manutencao.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agruparAgendamentoCalendario($dados)
    {
        $formatado = [];
        $cor = '';
        $x = 0;
        foreach ($dados as $agendamento)
        {
            //PARA DATA EXCEDIDA O TEMA USADO 'BLACK'
            if (strtotime($agendamento['data_inicio']) < strtotime(date("Y-m-d H:i:s")))
                $cor = 'COLOR_BLACK';
            elseif ($agendamento['status'] == 1)
                $cor = 'COLOR_GREEN';
            elseif ($agendamento['status'] == 2)
                $cor = 'COLOR_BLUE';
            elseif ($agendamento['status'] == 3)
                $cor = 'COLOR_RED';

            $formatado[$x]['id'] = $agendamento['id'];
            $formatado[$x]['title'] = $agendamento['cliente'];
            $formatado[$x]['start'] = $agendamento['data_inicio'];
            $formatado[$x]['end']   = $agendamento['data_fim'];
            $formatado[$x]['color'] = $cor;
            $x++;
        }
        return $formatado;
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO agenda_manutencao (id_usuario,
                                  id_status, 
                                  observacao, 
                                  data_hora_inicio,
                                  data_hora_fim,
                                  data_hora_cadastro)
                 VALUES (:id_usuario,
                         :id_status,
                         :observacao,
                         :data_hora_inicio,
                         :data_hora_fim,
                         NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":observacao", $this->observacao, PDO::PARAM_STR);
        $stmt->bindParam(":data_hora_inicio", $this->dataInicio, PDO::PARAM_STR);
        $stmt->bindParam(":data_hora_fim", $this->dataFim, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function adicionarAgendamentoClienteManutencao()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO agenda_manutencao_cliente_veiculo (id_agenda_manutencao, id_cliente, id_veiculo)
                VALUES (:id_agenda_manutencao, :id_cliente, :id_veiculo)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_agenda_manutencao", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":id_veiculo", $this->idVeiculo, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT agenda_manutencao.data_hora_inicio AS data_inicial,
                agenda_manutencao.data_hora_fim AS data_final,
                agenda_manutencao.observacao,
                agenda_manutencao.id_status,
                cliente.id AS id_cliente,
                cliente.nome AS cliente,
                veiculo.id AS id_veiculo,
                veiculo.modelo AS veiculo
                FROM agenda_manutencao
                INNER JOIN agenda_manutencao_cliente_veiculo ON (agenda_manutencao_cliente_veiculo.id_agenda_manutencao = agenda_manutencao.id)
                INNER JOIN cliente ON (agenda_manutencao_cliente_veiculo.id_cliente = cliente.id)
                INNER JOIN veiculo ON (agenda_manutencao_cliente_veiculo.id_veiculo = veiculo.id)
                WHERE agenda_manutencao.id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE agenda_manutencao SET id_status = :idStatus,
                observacao = :observacao,
                data_hora_inicio = :data_inicio,
                data_hora_fim = :data_fim
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":idStatus", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":observacao", $this->observacao, PDO::PARAM_STR);
        $stmt->bindParam(":data_inicio", $this->dataInicio, PDO::PARAM_STR);
        $stmt->bindParam(":data_fim", $this->dataFim, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function modificarAgendamentoClienteManutencao()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE agenda_manutencao_cliente_veiculo SET id_cliente = :id_cliente,
                id_veiculo = :id_veiculo
                WHERE id_agenda_manutencao = :id_agendamento_manutencao";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_agendamento_manutencao", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":id_veiculo", $this->idVeiculo, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function modificarDataAgendamento()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE agenda_manutencao SET data_hora_inicio = :data_inicio,
                data_hora_fim = :data_fim
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":data_inicio", $this->dataInicio, PDO::PARAM_STR);
        $stmt->bindParam(":data_fim", $this->dataFim, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(agenda_manutencao.id) AS total
                FROM agenda_manutencao
                INNER JOIN agenda_manutencao_status ON (agenda_manutencao_status.id = agenda_manutencao.id_status)
                INNER JOIN agenda_manutencao_cliente_veiculo ON (agenda_manutencao_cliente_veiculo.id_agenda_manutencao = agenda_manutencao.id)
                INNER JOIN cliente ON (agenda_manutencao_cliente_veiculo.id_cliente = cliente.id)
                INNER JOIN veiculo ON (agenda_manutencao_cliente_veiculo.id_veiculo = veiculo.id)
                WHERE agenda_manutencao.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sqlTotal .= " AND (cliente.nome LIKE :cliente OR veiculo.modelo LIKE :veiculo
                      OR agenda_manutencao_status.rotulo LIKE :status
                      OR agenda_manutencao.observacao LIKE :observacao)";
        }

        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":veiculo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":observacao", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT agenda_manutencao.id,
                agenda_manutencao.data_hora_inicio AS data_inicial,
                agenda_manutencao.data_hora_fim AS data_final,
                agenda_manutencao.data_hora_cadastro,
                agenda_manutencao.observacao,
                agenda_manutencao.id_status,
                agenda_manutencao_status.rotulo AS status,
                cliente.nome AS cliente,
                veiculo.modelo AS veiculo
                FROM agenda_manutencao
                INNER JOIN agenda_manutencao_status ON (agenda_manutencao_status.id = agenda_manutencao.id_status)
                INNER JOIN agenda_manutencao_cliente_veiculo ON (agenda_manutencao_cliente_veiculo.id_agenda_manutencao = agenda_manutencao.id)
                INNER JOIN cliente ON (agenda_manutencao_cliente_veiculo.id_cliente = cliente.id)
                INNER JOIN veiculo ON (agenda_manutencao_cliente_veiculo.id_veiculo = veiculo.id)
                WHERE agenda_manutencao.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (cliente.nome LIKE :cliente OR veiculo.modelo LIKE :veiculo
                      OR agenda_manutencao_status.rotulo LIKE :status
                      OR agenda_manutencao.observacao LIKE :observacao)";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY agenda_manutencao.id";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":cliente", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":veiculo", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":observacao", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$dados, $totalRegistros];
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE agenda_manutencao
                SET agenda_manutencao.data_hora_exclusao = NOW()
                WHERE agenda_manutencao.id IN ($id)";

        $stmt = $pdo->prepare($sql);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }
}