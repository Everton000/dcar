<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 18/10/2018
 * Time: 06:46
 */

$veiculo = new Veiculo();

//FUNÇAO QUE BUSCA OS DADOS DA BASE DE DADOS
$veiculo->setIdCliente(isset($linha["id"]) ? $linha["id"] : 0);
$dados = $veiculo->listarVeiculos();

$dadosLinha = [];
//DADOS DAS COLUNAS
$dadosColuna["dados_th"][] = array("nome" => "Modelo");
$dadosColuna["dados_th"][] = array("nome" => "Marca");
$dadosColuna["dados_th"][] = array("nome" => "Placa");
$dadosColuna["dados_th"][] = array("nome" => "Chassi");
$dadosColuna["dados_th"][] = array("nome" => "Ano");
$dadosColuna["dados_th"][] = array("nome" => "Cor");
$dadosColuna["dados_th"][] = array("nome" => "Kilometragem");
$dadosColuna["dados_th"][] = array("nome" => "Data Hora Cadastro");
$dadosColuna["dados_th"][] = array("nome" => "Status");
$dadosColuna["dados_th"][] = array("nome" => "#");
$dadosColuna["dados_th"][] = array("nome" => "#");

$hidden = "";
$dadosHidden = "";
if ($dados !== false)
{
    //DADOS DAS LINHAS
    if (count($dados[0]) > 0)
    {
        $x = 0;
        foreach ($dados[0] as $linha)
        {
            $dadosHidden .= "<input type='hidden' id='id_veiculo_historico' name='id_veiculo_historico[{$x}]' value='{$linha["id"]}'>";
            //DADOS GUARDADOS PARA ARMAZENAR NA BASE DE DADOS
            $hidden  = "<input type='hidden' id='linha_edita_id_veiculo' name='linha_edita_id_veiculo[{$x}]' value='{$linha["id"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_marca' name='linha_edita_marca[{$linha["id"]}]' value='{$linha["marca"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_placa' name='linha_edita_placa[{$linha["id"]}]' value='{$linha["placa"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_chassis' name='linha_edita_chassis[{$linha["id"]}]' value='{$linha["chassis"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_ano' name='linha_edita_ano[{$linha["id"]}]' value='{$linha["ano"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_cor' name='linha_edita_cor[{$linha["id"]}]' value='{$linha["cor"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_km' name='linha_edita_km[{$linha["id"]}]' value='{$linha["kilometragem"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_veiculo_ativo' name='linha_edita_veiculo_ativo[{$linha["id"]}]' value='{$linha["status"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_modelo' name='linha_edita_modelo[{$linha["id"]}]' value='{$linha["modelo"]}'>";
            $hidden .= "<input type='hidden' id='linha_edita_data_hora_cadastro' name='linha_edita_data_hora_cadastro[{$linha["id"]}]' value='{$linha["data_hora_cadastro"]}'>";

            //NOMEIA UM ID PARA A TD
            $dadosLinha["id_tr"][$x]    = array("id"    => $linha["id"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["modelo"] . $hidden);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["marca"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["placa"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["chassis"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["ano"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["cor"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["kilometragem"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => Utils::convertDateTimeSistema($linha["data_hora_cadastro"]));
            $dadosLinha["dados_tr"][$x][] = array("dados" => $linha["status"]);
            $dadosLinha["dados_tr"][$x][] = array("dados" => "<span style='color: #0a6aa1; font-size: 125%; cursor: pointer' class='fa fa-edit' data-toggle='tooltip' title='Modificar' onclick='EditarVeiculo(this, true)'></span>");
            $dadosLinha["dados_tr"][$x][] = array("dados" => "<span style='color: #ff4441; font-size: 125%; cursor: pointer' class='fas fa-window-close' data-toggle='tooltip' data-placement='top' title='Excluir' onclick='ExcluirVeiculo(this)'></span>");

            unset($hidden);
            $x++;
        }
    }
}

//GERAR TABELA LISTAGEM
$tabela = new Tabela();
$tabela->dadosColuna = $dadosColuna;
$tabela->dadosLinha = $dadosLinha;
$tabela->permitiPaginacao = false;
$tabela->idTabela = "tabela_veiculo";
$tabela->dadosHidden = $dadosHidden;
$tabela->txtSemRegistro = '-';
$tabela->gerar();
?>