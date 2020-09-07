<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 18/10/2018
 * Time: 03:08
 */
class Utils
{
    static function convertFloatBanco($num)
    {
        $num = str_replace(".", "", $num);
        return str_replace(",", ".", $num);
    }

    static function convertFloatSistema($num)
    {
        if(empty($num))
            $num = 0;

        return number_format((float)$num, 2, ",", ".");
    }

    static function convertDateTimeBanco($date, $format = 'Y-m-d H:i:s')
    {
        if ($date)
        {
            return date($format, strtotime(str_replace('/', '-', $date)));
        }
        else
        {
            return NULL;
        }
    }
    static function convertDateTimeSistema($date, $format = 'd/m/Y H:i')
    {
        if ($date)
        {
            return date($format, strtotime(str_replace('-', '/', $date)));
        }
        else
        {
            return NULL;
        }
    }

    static function mesAtual()
    {
        $mes = '';
        switch (date('m'))
        {
            case '01':
                $mes = 'Janeiro';
                break;
            case '02':
                $mes = 'Fevereiro';
                break;
            case '03':
                $mes = 'Março';
                break;
            case '04':
                $mes = 'Abril';
                break;
            case '05':
                $mes = 'Maio';
                break;
            case '06':
                $mes = 'Junho';
                break;
            case '07':
                $mes = 'Julho';
                break;
            case '08':
                $mes = 'Agosto';
                break;
            case '09':
                $mes = 'Setembro';
                break;
            case '10':
                $mes = 'Outubro';
                break;
            case '11':
                $mes = 'Novembro';
                break;
            case '12':
                $mes = 'Dezembro';
                break;
        }
        return $mes;
    }
}