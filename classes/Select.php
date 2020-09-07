<?php

/**
 * Created by PhpStorm.
 * User: Everton
 * Date: 01/11/2018
 * Time: 01:55
 */
class Select
{
    static function selectDefault($name, $id, $registros, $selectedId = '', $class = 'form-control', $options = false)
    {
        $html = "<select $options name='$name' id='$id' class='$class'>";

        $html .= "<option value=''>Selecione</option>";
        foreach ($registros as $option)
        {
            if ($selectedId == $option['id'])
                $html .= "<option selected value='{$option["id"]}'> {$option["value"]}</option>";
            else
                $html .= "<option value='{$option["id"]}'> {$option["value"]}</option>";
        }

        $html .= "</select>";

        echo $html;
    }
}