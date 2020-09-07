<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/09/2018
 * Time: 19:33
 */
class Login
{
    private $usuario;
    private $senha;
    private $conexao;

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
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

    public function logar()
    {
        $pdo = new Conexao();

        $sql = "SELECT id, usuario, nome, senha, id_status FROM usuario WHERE usuario = :usuario";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":usuario", $this->usuario);
        $stmt->execute();

        $dadosUsuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($dadosUsuario) === 0)
            throw new Exception("Usuário inexistente!", 1);

        if ($dadosUsuario[0]["id_status"] == 1)
            throw new Exception("Usuário inativo!", 1);

        $usuario = $dadosUsuario[0];

        //ENCRIPITO A SENHA INFORMADA NO FORMULÁRIO
        $senha = md5($this->senha);

        //COMPARO A SENHA DO BANCO COM A SENHA DO FORMULÁRIO
        if ($senha === $usuario['senha'])
        {
            $_SESSION["usuario"] = $usuario["usuario"];
            $_SESSION["id_usuario"] = $usuario["id"];
            $_SESSION["nome_usuario"] = $usuario["nome"];
        }
        else
        {
            throw new Exception("Senha inválida!");
        }
    }

    public function Logout()
    {
        // DESTRUIR SESSION NAME
        $_SESSION["erp"] = array();

        // DESTRUIR O COOKIE RELACIONADO A ESTA SESSÃO
        if(isset($_COOKIE[session_name("erp")]))
            setcookie(session_name("erp"), '', time() - 1000, '/');

        // DESTRUIR A SESSÃO
        session_destroy();

        // REDIRECIONAR PARA A TELA DE LOGIN
        header("Location: index.php");
    }

}