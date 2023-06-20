<?php

namespace App\Controllers;

use App\Models\BlogModel;

class PostsController extends Controller
{
    public function index(): void
    {
        $model = new BlogModel();

        $posts = $model->findAll();

        $this->render('posts/index', $posts);
    }
}