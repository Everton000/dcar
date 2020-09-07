<?php
spl_autoload_register(function($nomeClasse)
{
    if(file_exists("modulos" . DIRECTORY_SEPARATOR . ConverteClasse($nomeClasse) . DIRECTORY_SEPARATOR . $nomeClasse . ".php") === true)
    {
        require_once ("modulos" . DIRECTORY_SEPARATOR . ConverteClasse($nomeClasse) . DIRECTORY_SEPARATOR . $nomeClasse . ".php");
    }
    elseif (file_exists("classes" . DIRECTORY_SEPARATOR . $nomeClasse . ".php") === true)
    {
        require_once ("classes" . DIRECTORY_SEPARATOR . $nomeClasse . ".php");
    }
});

function ConverteClasse($name)
{
    $name = preg_replace('/([a-z])([A-Z])/', "$1_$2", $name);
    $name = strtr($name, " ", "_");
    return strtolower($name);
}