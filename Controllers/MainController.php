<?php

namespace App\Controllers;

class MainController extends Controller
{
    public function index()
    {
        $title = "Associa | Accueil";

        $this->render("main/index", ["title"=>$title]);
    }
}