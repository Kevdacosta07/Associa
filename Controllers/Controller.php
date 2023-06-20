<?php

namespace App\Controllers;

abstract class Controller
{
    public function render($file, $data = [])
    {
        // On extrait les données de $data
        extract($data);

        $path = ROOT."/Views/".$file.".php";

        if (file_exists($path))
        {
            require_once $path;
        }

        else
        {
            http_response_code(501);
            header("Location: main/index.php");
        }
    }
}