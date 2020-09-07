<?php
$a = "'";

$html = '<!DOCTYPE html>
                <html lang="pt-br">
                <head>
                 </head>
                <body>
                        <div class="container">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <p>Curitiba, '.$dia.' de '.$mes.' de '.$ano.'.</p>
                    
                                    <p>Prezado '.$cliente['nome'].',
                    
                                    Consta em nosso sistema que o pagamento da conta de valor R$'.Utils::convertFloatSistema($cliente['valor']).', referente á manutenção do veículo '.$cliente['modelo_veiculo'].' realizada na data '.Utils::convertDateTimeSistema($cliente['data_hora_inicio'],'d/m/Y').', com vencimento na data '.Utils::convertDateTimeSistema($cliente['data_vencimento'],'d/m/Y').', ainda não foi realizado.</p>
                    
                                    <p>Pedimos que o pagamento seja efetuado o quanto antes.</p>
                    
                                    <p>Se tiver dúvidas, por gentileza, entre em contato pelo telefone 3586-0626 ou 98420-4580.</p><br>
                    
                                    <p>Atenciosamente,</p><br>
                    
                                    <p>Administração D'.$a.' CAR.</p>
                            </div>
                        </div>
                    </div>
                </body>';
?>