<?php

switch ($this->appComando)
{
    case "home":

        try
        {
            $home = new Home();
            $home->setMes(date('m'));

            $contasReceber = $home->somarTotalContasReceberMes();
            $contasRecebidas = $home->somarTotalContasRecebidasMes();
            $contasPagar = $home->somarTotalContasPagarMes();

            $contasPagas = $home->somarTotalContasPagasMes();

        }
        catch (Exception $e)
        {

        }
        $template = "tpl.home.php";

        break;

    case "listar_grafico_total_contas":

        $home = new Home();
        $valores = $home->listarTotalContas();

        echo json_encode($valores);

        break;

    case "listar_grafico_total_contas_recebidas_mensal":

        $home = new Home();

        $mes = 1;
        $mesAtual = date('m');
        $mesReferencia = date('M', 01);
        $mesReferencias = ucfirst( utf8_encode( strftime("%b", strtotime($mesReferencia) ) ) );

        for ($x = 0; $x < $mesAtual; $x++)
        {
            $home->setMes($mes);

            $valores[$x]['dados'] = $home->somarTotalContasRecebidasMes();
            $valores[$x]['mes'] = $mesReferencias;
            $mes++;
            $mesReferencia = date("M",strtotime(date("M", strtotime($mesReferencia)) . " +1 month"));
            $mesReferencias = ucfirst( utf8_encode( strftime("%b", strtotime($mesReferencia) ) ) );

        }
        $valores['mes_atual'] = $mesAtual;

        echo json_encode($valores);

        break;
}
