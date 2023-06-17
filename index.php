<?php

use App\AutoLoader;
use App\Models\BlogModel;
require_once "AutoLoader.php";
AutoLoader::register();

$model = new BlogModel();

echo "<pre>".var_dump($model->findBy(["title"=>"Le nouveau chocolat"]))."</pre>";