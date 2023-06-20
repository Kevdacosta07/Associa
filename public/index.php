<?php

define("ROOT", dirname(__DIR__));

use App\AutoLoader;
use App\Core\Main;

require_once ROOT."/AutoLoader.php";
AutoLoader::register();

$app = new Main();

$app->start();
