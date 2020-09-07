<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 07/09/2018
 * Time: 15:18
 */
class Conexao extends PDO
{
    protected $host = "127.0.0.1";
    protected $usuario = "root";
    protected $senha = "";
    protected $baseDados = "erp";

    public function __construct()
    {
        parent::__construct(
            "mysql:dbname=" . $this->baseDados . ";host=" . $this->host,
            $this->usuario,
            $this->senha,
            array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                   PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
        );
    }
}