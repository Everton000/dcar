<?php
/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 25/11/2018
 * Time: 22:32
 */

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
                    
                    .borda {
                    padding: 25px;
                    border: 1px solid #000;
                    }
                </style>
                </head>
                <body>
            ";;

$html .= '<h2 style="text-align:center">Ordem de Serviço</h2><br><br>';

$html .= '<div class="borda"><table class="table">
                <tr>
                    <td><b>Cliente:</b> <u>'.$dados['cliente'].'</u></td>
                    <td><b>Veículo:</b> <u>'.$dados['veiculo'].'</u></td>
                </tr>
                <tr>
                     <td><b>Placa:</b> <u>'.strtoupper($dados['placa']).'</u></td>
                    <td><b>Quilometragem:</b> <u>'.$dados['quilometragem'].'</u></td>
                </tr>
                <tr>
                    <td><b>Data Inicial:</b> <u>'.Utils::convertDateTimeSistema($dados['data_hora_inicio']).'</u></td>
                    <td><b>Data Final:</b> <u>'.Utils::convertDateTimeSistema($dados['data_hora_fim']).'</u></td>
                </tr>
                <tr>
                    <td><b>Prazo de Garantia:</b> <u>'.Utils::convertDateTimeSistema($dados['data_garantia'], 'd/m/Y').'</u></td>
                    <td><b>Valor Total O.S:</b> R$ <u>'.Utils::convertFloatSistema($dados['valor']).'</u></td>
                </tr>
            </table>';

$html .= '<hr><br><h3>Serviços</h3>';

$html .= '<table class="table table-bordered">';

$html .= '<thead>
                <tr>
                    <th><b>Descrição</b></th>
                    <th><b>Valor</b></th>
                </tr>
          </thead>';

$html .= '<tbody>';

foreach ($servicos as $servico)
{
    $html .= '<tr>
                  <td>' . $servico['descricao'] . '</u></td>
                  <td> R$ ' . Utils::convertFloatSistema($servico['valor']) . '</u></td>
              </tr> ';
}
$html .= '</tbody></table>';

if (count($produtos) > 0)
{
    $html .= '<br><hr><br><h3>Produtos</h3>';

    $html .= '<table class="table table-bordered">';

    $html .= '<thead>
                <tr>
                    <th><b>Produto</b></th>
                    <th><b>Quantidade</b></th>
                    <th><b>Valor Unitário</b></th>
                    <th><b>Valor Total</b></th>
                </tr>
          </thead>';

    $html .= '<tbody>';

    foreach ($produtos as $produto)
    {
        $html .= '<tr>
                  <td>' . $produto['rotulo'] . '</u></td>
                  <td>' . $produto['quantidade'] . '</u></td>
                  <td> R$ ' . Utils::convertFloatSistema($produto['valor_unitario']) . '</u></td>
                  <td> R$ ' . Utils::convertFloatSistema($produto['valor']) . '</u></td>
              </tr> ';
    }

    $html .= '</tbody></table>';
}

if ($dados['descricao'] != "") {
    $html .= '<hr><br><p><b>Descrição:</b> <u>' . $dados['descricao'] . '</u></p></div>';
}

// CREATE AN INSTANCE OF THE CLASS:
$mpdf = new \Mpdf\Mpdf();
// WRITE SOME HTML CODE:
$mpdf->WriteHTML(file_get_contents('modulos/ordem_servico/template/ordem_servico_css.pdf.php'));
$mpdf->WriteHTML($html);
// OUTPUT A PDF FILE DIRECTLY TO THE BROWSER
$mpdf->Output();
?>