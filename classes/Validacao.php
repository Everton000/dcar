<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 14/10/2018
 * Time: 22:31
 */
class Validacao
{

    static function validarObrigatorio($campos)
    {
        if (is_array($campos))
        {
            foreach ($campos as $campo)
            {
                if (empty($campo))
                {
                    throw new Exception("Por favor, preencha os campos obrigatórios!");
                }
            }
        }
        else
        {
            if (empty($campos))
            {
                throw new Exception("Por favor, preencha os campos obrigatórios!");
            }
        }
    }

    static function validarMoneyObrigatorio($campos)
    {
        if (is_array($campos))
        {
            foreach ($campos as $campo)
            {
                if ($campo == "0,00")
                {
                    throw new Exception("Por favor, preencha os campos obrigatórios!");
                }
            }
        }
        else
        {
            if ($campos == "0,00")
            {
                throw new Exception("Por favor, preencha os campos obrigatórios!");
            }
        }
    }
}