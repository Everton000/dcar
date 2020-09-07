<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/10/2018
 * Time: 22:00
 */
class Usuario
{
    private $id;
    private $nome;
    private $usuario;
    private $senha;
    private $email;
    private $master;
    private $perguntaSenha;
    private $respostaSenha;
    private $ativo;
    private $dataHoraExclusao;
    private $conexao;

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

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMaster()
    {
        return $this->master;
    }

    public function setMaster($master)
    {
        $this->master = $master;
    }

    public function getPerguntaSenha()
    {
        return $this->perguntaSenha;
    }

    public function setPerguntaSenha($perguntaSenha)
    {
        $this->perguntaSenha = $perguntaSenha;
    }

    public function getRespostaSenha()
    {
        return $this->respostaSenha;
    }

    public function setRespostaSenha($respostaSenha)
    {
        $this->respostaSenha = $respostaSenha;
    }

    public function getAtivo()
    {
        return $this->ativo;
    }

    public function setAtivo($ativo)
    {
        $this->ativo = $ativo;
    }

    public function getDataHoraExclusao()
    {
        return $this->dataHoraExclusao;
    }

    public function setDataHoraExclusao($dataHoraExclusao)
    {
        $this->dataHoraExclusao = $dataHoraExclusao;
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

    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(usuario.id) AS total
                FROM usuario
                    INNER JOIN status ON (usuario.id_status = status.id)
                WHERE usuario.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sqlTotal .= " AND (nome LIKE :nome OR usuario LIKE :usuario OR email like :email)";
        }
        $stmt = $pdo->prepare($sqlTotal);

        if ($busca)
        {
            $busca = "%$busca%";
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT usuario.id,
                    nome,
                    usuario,
                    email,
                    master,
                    data_hora_cadastro,
                    status.rotulo AS status
                FROM usuario
                    INNER JOIN status ON (usuario.id_status = status.id)
                    WHERE usuario.data_hora_exclusao IS NULL";

        if ($busca)
        {
            $sql .= " AND (nome LIKE :nome OR usuario LIKE :usuario OR email like :email)";
        }
        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";

        $sql .= " LIMIT :inicio, :fim";
        $stmt = $pdo->prepare($sql);

        if ($busca)
        {
            $stmt->bindParam(":nome", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":usuario", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":email", $busca, PDO::PARAM_STR);
        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$usuarios, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO usuario (id_status, 
                                  nome, usuario,
                                  senha, email,
                                  master, pergunta_senha, 
                                  resposta_senha, data_hora_cadastro)
                 VALUES (:id_status, :nome,
                         :usuario, :senha,
                         :email, :master,
                         :pergunta_senha,
                         :resposta_senha,
                         NOW())";

        $stmt = $pdo->prepare($sql);
        $senha = md5($this->senha);
        $stmt->bindParam(":id_status", $this->ativo, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $this->usuario, PDO::PARAM_STR);
        $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":master", $this->master, PDO::PARAM_INT);
        $stmt->bindParam(":pergunta_senha", $this->perguntaSenha, PDO::PARAM_STR);
        $stmt->bindParam(":resposta_senha", $this->respostaSenha, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT usuario.*
                FROM usuario
                    INNER JOIN status ON (usuario.id_status = status.id)
                    WHERE usuario.id = :id_usuario AND usuario.data_hora_exclusao IS NULL";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("id_usuario", $this->id);
        $stmt->execute();
        $usuarios = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarios === false)
            throw new Exception();

        return $usuarios;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE usuario SET id_status = :id_status, nome = :nome, 
                        usuario = :usuario, email = :email, 
                        master = :master, pergunta_senha = :pergunta_senha, resposta_senha = :resposta_senha";

        if ($this->senha)
            $sql .= ", senha = :senha";

        $sql .= " WHERE usuario.id = :id_usuario";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_status", $this->ativo, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $this->nome, PDO::PARAM_STR);
        $stmt->bindParam(":usuario", $this->usuario, PDO::PARAM_STR);
        $stmt->bindParam(":email", $this->email, PDO::PARAM_STR);
        $stmt->bindParam(":master", $this->master, PDO::PARAM_STR);
        $stmt->bindParam(":pergunta_senha", $this->perguntaSenha, PDO::PARAM_STR);
        $stmt->bindParam(":resposta_senha", $this->respostaSenha, PDO::PARAM_STR);
        $stmt->bindParam(":id_usuario", $this->id, PDO::PARAM_INT);

        if ($this->senha)
        {
            $senha = md5($this->senha);
            $stmt->bindParam(":senha", $senha, PDO::PARAM_STR);
        }

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE usuario SET id_status = :id_status, data_hora_exclusao = NOW()";

        $sql .= " WHERE usuario.id IN ($id)";

        $stmt = $pdo->prepare($sql);
        $idStatus = 1;

        $stmt->bindParam(":id_status", $idStatus, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if($retorno === false)
            throw new Exception();

        return $retorno;
    }

}