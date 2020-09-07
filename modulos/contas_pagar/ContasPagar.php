<?php
/**
 * Created by PhpStorm.
 * User: Stephanie
 * Date: 05/11/2018
 * Time: 22:44
 */

class ContasPagar
{
    private $id;
    private $id_usuario;
    private $descricao;
    private $id_categoria;
    private $vencimento;
    private $valor;
    private $data_hora_pagamento;
    private $status;

    /**
     * @return mixed]]]]]]]]]]]]
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    /**
     * @param mixed $id_usuario
     */
    public function setIdUsuario($id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    /**
     * @return mixed
     */
    public function getIdCategoria()
    {
        return $this->id_categoria;
    }

    /**
     * @param mixed $id_categoria
     */
    public function setIdCategoria($id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao): void
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getVencimento()
    {
        return $this->vencimento;
    }

    /**
     * @param mixed $vencimento
     */
    public function setVencimento($vencimento): void
    {
        $this->vencimento = $vencimento;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * @param mixed $valor
     */
    public function setValor($valor): void
    {
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getDataPagamento()
    {
        return $this->data_hora_pagamento;
    }

    /**
     * @param mixed $dataPagamento
     */
    public function setDataPagamento($data_hora_pagamento): void
    {
        $this->data_hora_pagamento = $data_hora_pagamento;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function __construct($conexao = null)
    {
        if (is_a($conexao, 'Conexao'))
            $this->conexao = $conexao;
        else
            $this->conexao = new Conexao();
    }
    public function ListarCategoria()
    {
        $pdo = $this->conexao;

        $sql = "SELECT categoria.id, categoria.rotulo AS value 
                        FROM categoria";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function ListarStatus()
    {
        $pdo = $this->conexao;

        $sql = "SELECT id, rotulo AS value 
                        FROM contas_pagar_status";

        $stmt = $pdo->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function listarPaginacao($inicioRegistros, $fimRegistros, $busca, $filtro, $ordem)
    {
        $pdo = $this->conexao;

        $sqlTotal = "SELECT COUNT(contas_pagar.id) AS total
                FROM contas_pagar
                    INNER JOIN contas_pagar_status ON (contas_pagar.id_status = contas_pagar_status.id)
                    INNER JOIN categoria ON (categoria.id = contas_pagar.id_categoria)
                WHERE contas_pagar.data_hora_exclusao IS NULL";

        if ($busca) {
            $sqlTotal .= " AND (contas_pagar.descricao LIKE :descricao or categoria.rotulo LIKE :categoria
            or contas_pagar_status.rotulo LIKE :status)";
        }
        $stmt = $pdo->prepare($sqlTotal);

        if ($busca) {
            $busca = "%$busca%";
            $stmt->bindParam(":descricao", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":categoria", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);
        }

        $stmt->execute();
        $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT contas_pagar.id,
                    id_usuario,
                    descricao,
                    categoria.rotulo as categoria,                
                    vencimento,
                    valor,
                    data_hora_pagamento,
                    data_hora_cadastro,
                    contas_pagar_status.rotulo AS status
                FROM contas_pagar
                    INNER JOIN contas_pagar_status ON (contas_pagar.id_status = contas_pagar_status.id)
                    INNER JOIN categoria ON (categoria.id = contas_pagar.id_categoria)
                    WHERE data_hora_exclusao IS NULL";

        if ($busca) {
            $sql .= " AND (contas_pagar.descricao LIKE :descricao or categoria.rotulo LIKE :categoria
            or contas_pagar_status.rotulo LIKE :status)";
        }

        if ($filtro)
            $sql .= " ORDER BY $filtro $ordem";
        else
            $sql .= " ORDER BY contas_pagar.id DESC";

        $sql .= " LIMIT :inicio, :fim";

        $stmt = $pdo->prepare($sql);

        if ($busca) {
            $stmt->bindParam(":descricao", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":categoria", $busca, PDO::PARAM_STR);
            $stmt->bindParam(":status", $busca, PDO::PARAM_STR);

        }

        $stmt->bindParam(":inicio", $inicioRegistros, PDO::PARAM_INT);
        $stmt->bindParam(":fim", $fimRegistros, PDO::PARAM_INT);

        $stmt->execute();
        $contaspagar = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [$contaspagar, $totalRegistros];
    }

    public function adicionar()
    {
        $pdo = $this->conexao;

        $sql = "INSERT INTO contas_pagar (id_usuario,
                    id_categoria,
                    descricao,
                    vencimento,
                    valor,
                    data_hora_pagamento,
                    id_status,
                    data_hora_cadastro)
                 VALUES (:id_usuario,:id_categoria, :descricao, :vencimento,
                                  :valor, :data_hora_pagamento, :id_status, NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_usuario", $_SESSION["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":id_categoria", $this->id_categoria, PDO::PARAM_STR);
        $stmt->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_STR);
        $stmt->bindParam(":vencimento", $this->vencimento, PDO::PARAM_STR);
        $stmt->bindParam(":id_status", $this->status, PDO::PARAM_STR);
        $stmt->bindParam(":data_hora_pagamento", $this->data_hora_pagamento, PDO::PARAM_STR);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function editar()
    {
        $pdo = $this->conexao;

        $sql = "SELECT contas_pagar.*
                FROM contas_pagar
                    WHERE contas_pagar.id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $contaspagar= $stmt->fetch(PDO::FETCH_ASSOC);

         return $contaspagar;
    }

    public function modificar()
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_pagar SET id_usuario = :id_usuario, id_categoria = :id_categoria, descricao = :descricao, vencimento = :vencimento,
                                 valor = :valor, data_hora_pagamento = :data_hora_pagamento, id_status = :id_status, data_hora_cadastro = NOW()";

        $sql .= " WHERE contas_pagar.id = :id_contas_pagar";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id_usuario", $_SESSION["id_usuario"], PDO::PARAM_INT);
        $stmt->bindParam(":id_contas_pagar", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":id_categoria", $this->id_categoria, PDO::PARAM_INT);
        $stmt->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
        $stmt->bindParam(":valor", $this->valor, PDO::PARAM_INT);
        $stmt->bindParam(":vencimento", $this->vencimento, PDO::PARAM_STR);
        $stmt->bindParam(":data_hora_pagamento", $this->data_hora_pagamento, PDO::PARAM_INT);
        $stmt->bindParam(":id_status", $this->status, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();

        return $retorno;
    }

    public function deletar($id)
    {
        $pdo = $this->conexao;

        $sql = "UPDATE contas_pagar SET data_hora_exclusao = NOW()";

        $sql .= " WHERE contas_pagar.id IN ($id)";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $retorno = $stmt->execute();

        if ($retorno === false)
            throw new Exception();

        return $retorno;
    }


}