<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 14/10/2018
 * Time: 20:27
 */

class Fornecedor
{
    private $id;
    private $idStatus;
    private $nome;
    private $cnpj;
    private $endereco;
    private $numero;
    private $bairro;
    private $cidade;
    private $cep;
    private $estado;
    private $telefone;
    private $email;
    private $site;
    private $conexao;


    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus($idStatus): void
    {
        $this->idStatus = $idStatus;
    }

    public function getBairro()
    {
        return $this->bairro;
    }

    public function setBairro($bairro): void
    {
        $this->bairro = $bairro;
    }

    public function getCidade()
    {
        return $this->cidade;
    }

    public function setCidade($cidade): void
    {
        $this->cidade = $cidade;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): void
    {
        $this->estado = $estado;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getCnpj()
    {
        return $this->cnpj;
    }

    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    public function getEndereco()
    {
        return $this->endereco;
    }

    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    public function getCep()
    {
        return $this->cep;
    }

    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSite()
    {
        return $this->site;
    }

    public function setSite($site)
    {
        $this->site = $site;
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

        $sqlTotal = "SELECT COUNT(fornecedor.id) AS total
                FROM fornecedor
                    INNER JOIN status ON (fornecedor.id_status = status.id)
                WHERE fornecedor.data_hora_exclusao IS NULL";


        if ($busca)
        {
            $sqlTotal .= " AND (nome LIKE :nome OR cnpj LIKE :cnpj OR email LIKE :email
                                OR endereco LIKE :endereco OR cidade LIKE :cidade
                                OR telefone LIKE :telefone OR status.rotulo LIKE :status)";
        }
        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cnpj", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":endereco", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cidade", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT fornecedor.id as id_fornecedor,
                    nome,
                    cnpj,
                    email,
                    endereco,
                    numero,
                    cidade,
                    telefone,
                    data_hora_cadastro,
                    status.rotulo AS status
                FROM fornecedor
                    INNER JOIN status ON (fornecedor.id_status = status.id)
                    WHERE fornecedor.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (nome LIKE :nome OR cnpj LIKE :cnpj OR email LIKE :email
                                OR endereco LIKE :endereco OR cidade LIKE :cidade
                                OR telefone LIKE :telefone OR status.rotulo LIKE :status)";
        }

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY nome ASC";

        $sql .= " LIMIT :inicio, :fim";

        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cnpj", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":endereco", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":cidade", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":telefone", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $fornecedor = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$fornecedor, $totalRegistros];
    }

    public function adicionarFornecedor()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO fornecedor (id_status, id_usuario,
                                  nome, cnpj,
                                  endereco,bairro,cidade, cep, estado,
                                 numero,telefone, 
                                  email,site, data_hora_cadastro)
                 VALUES (:id_status,:id_usuario, :nome, :cnpj,
                                  :endereco, :bairro,:cidade, :cep, :estado,
                                 :numero, :telefone, 
                                  :email, :site, NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":id_usuario", $_SESSION["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":cnpj", $this->cnpj, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(":cep", $this->cep, PDO::PARAM_STR);
        $stmt->bindParam(":numero", $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":site", $this->site, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT fornecedor.*
                FROM fornecedor
                    INNER JOIN status ON (fornecedor.id_status = status.id)
                    WHERE fornecedor.id = :id_fornecedor AND fornecedor.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id_fornecedor", $this->id);
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        return $fornecedor;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE fornecedor SET id_status = :id_status, nome = :nome, 
                       cnpj = :cnpj, endereco = :endereco, cidade = :cidade, bairro = :bairro, estado = :estado, 
                       cep = :cep, numero = :numero, telefone = :telefone,
                       email = :email, site = :site, data_hora_cadastro = NOW()";


        $sql .= " WHERE fornecedor.id = :id_fornecedor";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_status", $this->idStatus, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":cnpj", $this->cnpj, PDO::PARAM_STR);
        $stmt->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
        $stmt->bindParam(":bairro", $this->bairro, PDO::PARAM_STR);
        $stmt->bindParam(":cidade", $this->cidade, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $this->estado, PDO::PARAM_STR);
        $stmt->bindParam(":cep", $this->cep, PDO::PARAM_STR);
        $stmt->bindParam(":numero", $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":site", $this->site, PDO::PARAM_STR);
        $stmt->bindParam(":id_fornecedor", $this->id, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE fornecedor SET id_status = :id_status, data_hora_exclusao = NOW()";

        $sql .= " WHERE fornecedor.id IN ($id)";

        $stmt = $pdo->prepare($sql);
        $idStatus = 1;

        $stmt->bindParam(":id_status", $idStatus, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

}