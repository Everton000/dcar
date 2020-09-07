<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/10/2018
 * Time: 21:46
 */
class Tabela
{
    public $idTabela = "tabela_dados";
    public $classTabela = "table table-striped table-hover";
    public $dadosColuna;
    public $dadosLinha;
    public $totalRegistros;
    public $totalRegistrosPaginacao;
    public $funcaoAtualizarListagem = "";
    public $funcaoModificar = "Modificar";
    public $busca = "";
    public $pagina = "1";
    public $filtro = "";
    public $ordem = "";
    public $permitiPaginacao = true;
    public $permitiUl = true;
    public $permitirCampoBusca = true;
    public $legenda = false;
    public $dadosHidden = "";
    public $retornarHtml = false;
    public $txtSemRegistro = "Nenhum Registro Encontrado!";

    public function gerar()
    {
        $html = '';
        if ($this->permitiUl)
            $html .= "<hr/>";

        if ($this->permitiPaginacao === true)
        {
            //MARGEM

            $html .= "<div class='row'>";

            $html .= "<div class='col-md-8'>";


            //PAGINAÇÃO
            $paginas = ceil($this->totalRegistros / $this->totalRegistrosPaginacao);

            if ($paginas == 0)
                $paginas = 1;

            //BOTÃO 'ANTERIOR'
            if ($this->pagina == 1)
            {
                $html .= "<ul style='float: left' class='pagination'><li class='paginate_button previous disabled' id='data-table-default_previous'>";

                $html .= "<a href='javascript:;' aria-controls='data-table-default' data-dt-idx='0' tabindex='0'>Anterior</a></li>";
            }
            else
            {
                $paginaAnterior = $this->pagina - 1;
                $html .= "<ul style='float: left; cursor: pointer;' class='pagination'><li class='paginate_button previous' id='data-table-default_previous'>";

                $html .= "<a onclick=\"$this->funcaoAtualizarListagem('$paginaAnterior', '$this->busca', '$this->filtro', '$this->ordem')\" aria-controls='data-table-default' data-dt-idx='0' tabindex='0'>Anterior</a></li>";
            }

            if ($this->totalRegistros > $this->totalRegistrosPaginacao)
            {
                $active[$this->pagina] = 'active';

                for ($pag = 1; $pag <= $paginas; $pag++)
                {
                    $active[$pag] = isset($active[$pag]) ? $active[$pag] : '';

                    $html .= "<li class='paginate_button $active[$pag]'><a href='javascript:;' onclick=\"$this->funcaoAtualizarListagem('$pag', '$this->busca', '$this->filtro', '$this->ordem')\" aria-controls='data-table-default' data-dt-idx='1' tabindex='0'>$pag</a></li>";
                }

            }

            elseif ($this->totalRegistros <= $this->totalRegistrosPaginacao)
                $html .= "<li class='paginate_button active'><a href='javascript:;' aria-controls='data-table-default' data-dt-idx='1' tabindex='0'>1</a></li>";


            //BOTÃO 'PRÓXIMO'
            if ($paginas == 1 || $paginas == $this->pagina)
            {
                $html .= "<li class='paginate_button next disabled' id='data-table-default-next'><a href='javascript:;' aria-controls='data-table-default' data-dt-idx='7' tabindex='0'>Próximo</a></li>";
            }
            else
            {
                $paginaAnterior = ((int)$this->pagina) + 1;

                $html .= "<li style='cursor: pointer' class='paginate_button next' id='data-table-default-next'><a onclick=\"$this->funcaoAtualizarListagem('$paginaAnterior', '$this->busca', '$this->filtro', '$this->ordem')\" aria-controls='data-table-default' data-dt-idx='7' tabindex='0'>Próximo</a></li>";
            }

            //BOTÃO 'TOTAL REGISTROS'
            $html .= "<li class='paginate_button' id='data-table-default-total'><a aria-controls='data-table-default' data-dt-idx='7' tabindex='0'>{$this->pagina} / {$paginas} | {$this->totalRegistros} Registros</a></li></ul>";

            $html .= "</div>";

            if ($this->permitirCampoBusca)
            {
                //INPUT DE BUSCA
                $html .= "<div class='col-md-4'>";

                $html .= "<div class=\"input-group\"><input type='text' id='campo_busca' name='campo_busca' placeholder='Digite algo para iniciar a busca' class='form-control' value='$this->busca' onchange=\"$this->funcaoAtualizarListagem('$this->pagina', this.value, '$this->filtro', '$this->ordem')\"/> <div class=\"input-group-prepend\" style=\"cursor: pointer\"><span class=\"input-group-text\"><i class=\"fa fa-search\"></i></span></div></div>";

                $html .= "</div>";
            }
            elseif ($this->legenda)
            {
                $html .= "<div class='col-md-2'>";

                $html .= "<span style='color: #c8e9f3;background-color: #97b99c;border: none;height: ;line-height: 30px;padding: 0 10px;text-transform: uppercase;font-weight: bold;'></span> &nbsp;&nbsp;Entradas";

                $html .= "</div>";

                $html .= "<div class='col-md-2'>";

                $html .= "<span style='color: #ffcdcc;background-color: #d8abaa;border: none;height: ;line-height: 30px;padding: 0 10px;text-transform: uppercase;font-weight: bold;'></span> &nbsp;&nbsp;Saídas";

                $html .= "</div>";
            }

            $html .= "</div>";
        }

        //TABELA
        $html .= "<div class='table-responsive'>";

        $html .= "<table id='{$this->idTabela}' class='{$this->classTabela}'>";

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

                $style = '';
                $classeOrdena = '';
                if ($coluna['filtro'])
                {
                    if ($this->filtro == $coluna['filtro'])
                    {
                        if ($coluna['ordem'] == "asc")
                            $classeOrdena = "sorting_asc";
                        else
                            $classeOrdena = "sorting_desc";

                        $style = "color: #8e0000";
                    }
                    else
                        $classeOrdena = "sorting";
                }

                if (isset($coluna['nome']) && $coluna['nome'] != '#')
                    $html .= "<th class='th-listagem {$classeOrdena}' style='{$style}' onclick=\"$this->funcaoAtualizarListagem('$this->pagina', '$this->busca', '{$coluna["filtro"]}', '{$coluna["ordem"]}')\">{$coluna['nome']}</th>";
                elseif (isset($coluna['checkbox']))
                    $html .= "<th><input type='checkbox' class='' onchange='AllCheckbox(this)'></th>";
                else
                    $html .= "<th>{$coluna['nome']}</th>";
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
                    $option = isset($celula['option']) ? $celula['option'] : '';
                    $colspan = isset($celula['colspan']) ? $celula['colspan'] : '';
                    if (isset($celula['checkbox']))
                        $html .= "<td><input type='checkbox' {$option} class='checkbox-lis' value='{$celula["checkbox"]}'></td>";

                    elseif (isset($celula['editar']))
                        $html .= "<td><a id='editar' class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Modificar' onclick='$this->funcaoModificar({$celula["editar"]})' style='color: #0a6aa1; font-size: 125%; cursor: pointer'></a></td>";

                    elseif (isset($celula['dados']) || $celula['dados'] == "")
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

        $html .= "</div>";

        if ($this->permitiPaginacao === true)
        {
            //SELECT DE PAGINAÇÃO
            $html .= "<div class='row'><div class='col-md-1' style='margin-left: 44%'><select class='form-control' onchange=\"$this->funcaoAtualizarListagem(this.value, '$this->busca', '$this->filtro', '$this->ordem')\">";

            if ($this->totalRegistros > $this->totalRegistrosPaginacao)
            {
                $select[$this->pagina] = "selected";

                for ($pag = 1; $pag <= $paginas; $pag++)
                {
                    $select[$pag] = isset($select[$pag]) ? $select[$pag] : '';

                    $html .= "<option value='$pag' $select[$pag]>{$pag}</option>";
                }
            }
            elseif ($this->totalRegistros <= $this->totalRegistrosPaginacao)
                $html .= "<option>{$this->pagina}</option>";

            $html .= "</select></div></div>";
        }

        if ($this->retornarHtml === false)
            echo $html;
        else
            return $html;
    }
}
?>