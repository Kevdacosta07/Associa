<?php

namespace App;

class AutoLoader
{
    static function register(): void
    {
        spl_autoload_register([
            __CLASS__,
            'autoLoad'
        ]);
    }

    static function autoLoad($class)
    {
        $class = str_replace(__NAMESPACE__ . "\\", "", $class);

        //On remplace les "\" par des "/"
        $class = str_replace("\\", "/", $class);

        $file = __DIR__."/".$class.".php";
        
        if (file_exists($file))
        {
            require_once $file;
        }
    }
}
