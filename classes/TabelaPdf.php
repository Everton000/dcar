<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 20/11/2018
 * Time: 23:56
 */
class TabelaPdf
{
    public $idTabela = "tabela_dados";
    public $titulo = 'Relatório';
    public $filtros;
    public $dadosColuna;
    public $dadosLinha;
    public $dadosHidden = "";
    public $retornarHtml = false;
    public $txtSemRegistro = "Nenhum Registro Encontrado!";

    public function Gerar()
    {
        $html = "<!DOCTYPE html>
                <html lang='pt-br'>
                <head>
                    <meta charset='UTF-8'>
                    <title>D'CAR - ERP</title>
                <style>
                    table, th, td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 5px;
                    }               
                    table tr:nth-child(odd) {
                    background-color: #eee;
                    }  
                    table tr:nth-child(even) {
                    background-color: #fff;
                    }   
                    table thead th {
                    background-color: #ccc;
                    } 
                    table tfoot td {
                    background-color: #ccc;
                    } 
                </style>
                </head>
                <body>
            ";

        //TITULO
        $html .= "<h2 style='text-align: center'>$this->titulo</h2><br>";

        //FILTROS
        if (count($this->filtros) > 0)
        {
            foreach ($this->filtros AS $dados)
            {
                foreach ($dados AS $key => $row)
                    $html .= '<b>' . $key . '</b>: ' . $row . '<br>';
            }
        }

        //TABELA
        $html .= "<br><div class=''>";

        $html .= "<table id='{$this->idTabela}'>";

        $html .= "<thead>";

        $html .= "<tr>";

        //COLUNAS
        if (count($this->dadosColuna["dados_th"]) > 0)
        {
            foreach ($this->dadosColuna["dados_th"] as $coluna)
            {
                //TRATA WARNINGS
                if(empty($coluna["filtro"])) $coluna["filtro"] = "";
                if(empty($coluna["ordem"])) $coluna["ordem"] = "";

                if (isset($coluna['nome']))
                    $html .= "<th>{$coluna['nome']}</th>";
                elseif ($coluna['checkbox'])
                    $html .= "<th><input type='checkbox'></th>";
            }
        }

        $html .= "</tr>";

        $html .= "</thead>";

        $html .= "<tbody>";

        $html .= $this->dadosHidden;

        //LINHAS
        if (isset($this->dadosLinha["dados_tr"]) && count($this->dadosLinha["dados_tr"]) > 0)
        {
            $ind = 0;
            //DADOS LINHA
            foreach ($this->dadosLinha["dados_tr"] as $linha)
            {
                $idTr = isset($this->dadosLinha["id_tr"][$ind]["id"]) ? $this->dadosLinha["id_tr"][$ind]["id"] : '';
                $classTr = isset($this->dadosLinha["id_tr"][$ind]["class"]) ? $this->dadosLinha["id_tr"][$ind]["class"] : '';

                $html .= "<tr class='{$classTr}' id='{$idTr}'>";

                foreach ($linha as $celula)
                {
                    $colspan = isset($celula['colspan']) ? $celula['colspan'] : '';

                    if (isset($celula['dados']) || $celula['dados'] == "")
                        $html .= "<td colspan='{$colspan}'>{$celula['dados']}</td>";

                }
                $html .= "</tr>";
                $ind++;
            }
        }
        //LINHA SEM REGISTROS
        else
        {
            $qtdColunas = count($this->dadosColuna["dados_th"]);

            $html .= "<tr><td style='color: black' colspan='{$qtdColunas}'>$this->txtSemRegistro</td></tr>";
        }

        $html .= "</tbody>";

        $html .= "</table>";

        $html .= "</div></body>";

        return $html;
    }
}