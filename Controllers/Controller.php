<?php

namespace App\Controllers;

abstract class Controller
{
    public function render($file, $data = [], $layout = true)
    {

        // On extrait les données de $data
        extract($data);

        ob_start();

        $path = ROOT."/Views/".$file.".php";

        if (file_exists($path))
        {
            require_once $path;
        }

        else
        {
            http_response_code(501);
            header("Location: /main");
        }

        $content = ob_get_clean();

        if ($layout === null)
        {
            if (file_exists(ROOT."/Views/assocLayout.php"))
            {
                require_once ROOT."/Views/assocLayout.php";
            }
        }

        if ($layout)
        {
            if (file_exists(ROOT."/Views/layout.php"))
            {
                require_once ROOT."/Views/layout.php";
            }
        }

        else if ($layout === false)
        {
            if (file_exists(ROOT."/Views/dashboardLayout.php"))
            {
                require_once ROOT."/Views/dashboardLayout.php";
            }
        }
    }
}