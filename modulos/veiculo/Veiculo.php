<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 18/10/2018
 * Time: 20:19
 */
class Veiculo
{
    private $id;
    private $idCliente;
    private $idUsuario;
    private $idStatus;
    private $placa;
    private $chassis;
    private $marca;
    private $modelo;
    private $ano;
    private $cor;
    private $km;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdCliente()
    {
        return $this->idCliente;
    }

    public function setIdCliente($idCliente)
    {
        $this->idCliente = $idCliente;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus)
    {
        $this->idStatus = $idStatus;
    }

    public function getPlaca()
    {
        return $this->placa;
    }

    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    public function getChassis()
    {
        return $this->chassis;
    }

    public function setChassis($chassis)
    {
        $this->chassis = $chassis;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function getKm()
    {
        return $this->km;
    }

    public function setKm($km)
    {
        $this->km = $km;
    }

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
    }

    public function listarVeiculos()
    {
        if ($this->idCliente == 0)
            return false;

        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(veiculo.id) AS total
                FROM veiculo
                INNER JOIN status ON (status.id = veiculo.id_status)
                WHERE veiculo.id_cliente = :id_cliente
                     AND veiculo.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sqlTotal);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->execute();

        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT veiculo.*, status.rotulo AS status
                FROM veiculo
                INNER JOIN status ON (status.id = veiculo.id_status)
                WHERE veiculo.id_cliente = :id_cliente
                     AND veiculo.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->execute();

        $veiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$veiculos, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO veiculo (id_cliente,
                                  id_usuario,
                                  id_status, 
                                  placa, chassis,
                                  marca, modelo,
                                  ano, cor,
                                  kilometragem,
                                  data_hora_cadastro)
                 VALUES (:id_cliente, :id_usuario,
                         :id_status, :placa,
                         :chassis, :marca,
                         :modelo, :ano,
                         :cor, :kilometragem,
                         NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_cliente", $this->idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":placa", $this->placa, PDO::PARAM_STR);
        $stmt->bindParam(":chassis", $this->chassis, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $this->marca, PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $this->modelo, PDO::PARAM_STR);
        $stmt->bindParam(":ano", $this->ano, PDO::PARAM_INT);
        $stmt->bindParam(":cor", $this->cor, PDO::PARAM_STR);
        $stmt->bindParam(":kilometragem", $this->km, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE veiculo SET id_status = :id_status, placa = :placa, 
                        chassis = :chassis, marca = :marca,
                        modelo = :modelo, ano = :ano,
                        cor = :cor, kilometragem = :kilometragem";

        $sql .= " WHERE veiculo.id = :id_veiculo";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":placa", $this->placa, PDO::PARAM_STR);
        $stmt->bindParam(":chassis", $this->chassis, PDO::PARAM_STR);
        $stmt->bindParam(":marca", $this->marca, PDO::PARAM_STR);
        $stmt->bindParam(":modelo", $this->modelo, PDO::PARAM_STR);
        $stmt->bindParam(":ano", $this->ano, PDO::PARAM_INT);
        $stmt->bindParam(":cor", $this->cor, PDO::PARAM_STR);
        $stmt->bindParam(":kilometragem", $this->km, PDO::PARAM_STR);
        $stmt->bindParam(":id_veiculo", $this->id, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function buscaVeiculo($idCliente)
    {
        $pdo = $this->conexao;

        $sql = "SELECT id FROM veiculo WHERE id_cliente IN ('$idCliente') AND data_hora_exclusao IS NULL";
        $stmt = $pdo->prepare($sql);
        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $x = 0;
        foreach ($dados as $row)
        {
            $id[$x] = $row['id'];
            $x++;
        }
        return $id;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE veiculo SET id_status = 1, data_hora_exclusao = NOW()";

        $sql .= " WHERE veiculo.id IN ('$id')";

        $stmt = $pdo->prepare($sql);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }

    public function listarVeiculoJson($param, $cliente)
    {
        $param = trim($param);
        if ($cliente == "")
            return [];

        $pdo = $this->conexao;

        $sql = "SELECT id AS value, modelo AS label FROM veiculo WHERE
                veiculo.id_cliente = :id_cliente AND modelo LIKE :modelo AND data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $busca = "%$param%";
        $stmt->bindParam(":modelo", $busca, PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $cliente, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizarDataUltimaManutencao()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE veiculo SET data_ultima_manutencao = NOW()";

        $sql .= " WHERE veiculo.id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();
    }
}