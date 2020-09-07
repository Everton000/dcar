<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/10/2018
 * Time: 22:00
 */
class Cliente
{
    private $id;
    private $idUsuario;
    private $idStatus;
    private $nome;
    private $email;
    private $cpf;
    private $telefone;
    private $endereco;
    private $cidade;
    private $bairro;
    private $numero;
    private $cep;
    private $estado;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

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

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro)
    {
        $this->bairro = $bairro;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
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

        $sqlTotal = "SELECT COUNT(cliente.id) AS total
                FROM cliente
                    INNER JOIN status ON (cliente.id_status = status.id)
                WHERE cliente.data_hora_exclusao IS NULL ";

        if ($busca)
        {
            $sqlTotal .= " AND (cliente.nome LIKE :nome OR cpf LIKE :cpf OR email LIKE :email 
            OR cliente.endereco LIKE :endereco)";
        }
        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cpf", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":endereco", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT cliente.id,
                      cliente.nome,
                      status.rotulo AS status,
                      cliente.cpf,
                      cliente.telefone,
                      cliente.endereco,
                      cliente.cidade,
                      cliente.data_hora_cadastro
                FROM cliente
                    INNER JOIN status ON (cliente.id_status = status.id)
                    WHERE cliente.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (cliente.nome LIKE :nome OR cpf LIKE :cpf OR email LIKE :email 
            OR cliente.endereco LIKE :endereco)";
        }

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY cliente.nome ASC";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cpf", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":endereco", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$clientes, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO cliente (id_usuario,
                                  id_status, 
                                  nome, email,
                                  cpf, telefone,
                                  endereco, cidade,
                                  estado, bairro, numero,
                                  cep, data_hora_cadastro)
                 VALUES (:id_usuario, :id_status,
                         :nome, :email,
                         :cpf, :telefone,
                         :endereco, :cidade,
                         :estado, :bairro,
                         :numero, :cep,
                         NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_usuario", $this->idUsuario, PDO::PARAM_INT);
        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":cpf", $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_INT);
        $stmt->bindParam(":cidade", $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(":numero", $this->numero, PDO::PARAM_STR);
        $stmt->bindParam(":cep", $this->cep, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $pdo->lastInsertId();
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT cliente.*
                FROM cliente
                    INNER JOIN status ON (cliente.id_status = status.id)
                    WHERE cliente.id = :id_cliente AND cliente.data_hora_exclusao IS NULL
                ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id_cliente", $this->id);
        $stmt->execute();
        $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarios === false)
            throw new Exception();

        return $usuarios;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE cliente SET id_status = :id_status, nome = :nome, 
                        email = :email, cpf = :cpf,
                        telefone = :telefone, endereco = :endereco,
                        cidade = :cidade, estado = :estado, bairro = :bairro,
                        numero = :numero, cep = :cep";

        $sql .= " WHERE cliente.id = :id_cliente";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":cpf", $this->cpf, PDO::PARAM_STR);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(":numero", $this->numero, PDO::PARAM_STR);
        $stmt->bindParam(":cep", $this->cep, PDO::PARAM_STR);
        $stmt->bindParam(":id_cliente", $this->id, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE cliente SET id_status = :id_status, data_hora_exclusao = NOW()";

        $sql .= " WHERE cliente.id IN ($id)";

        $stmt = $pdo->prepare($sql);
        $idStatus = 1;

        $stmt->bindParam(":id_status", $idStatus, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function listarClienteJson($param)
    {
        $param = trim($param);
        $pdo = $this->conexao;

        $sql = "SELECT id AS value, nome AS label FROM cliente WHERE
                nome LIKE :nome AND data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $busca = "%$param%";
        $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarContasInativacao($idCliente)
    {
        $pdo = $this->conexao;

        $sql = "SELECT COUNT(*) AS total
                FROM ordem_servico
                INNER JOIN ordem_servico_cliente_veiculo ON (ordem_servico_cliente_veiculo.id_ordem_servico = ordem_servico.id)
                INNER JOIN contas_receber ON (ordem_servico.id_conta_receber = contas_receber.id)
                INNER JOIN contas_receber_ocorrencia ON (contas_receber_ocorrencia.id_contas_receber = contas_receber.id)
                WHERE ordem_servico_cliente_veiculo.id_cliente = (:id_cliente)
                AND ordem_servico.data_hora_exclusao IS NULL
                AND contas_receber.data_hora_exclusao IS NULL
                AND contas_receber_ocorrencia.data_hora_pagamento IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id_cliente", $idCliente, PDO::PARAM_INT);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dados['total'] > 0)
            throw new Exception('Não é possível inativar esse cliente, pois, há contas em aberto referente ao mesmo.');
    }
}