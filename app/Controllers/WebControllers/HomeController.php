<?php

declare(strict_types=1);

namespace App\Controllers\WebControllers;

use App\Controllers\WebControllers\ArticlesController;
use App\Controllers\WebControllers\CommentsController;
use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function loginForm()
    {
        return view('login');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function articleForm()
    {
        return view('article_form');
    }

    public function getArticle($id)
    {
        $article = new ArticlesController;
        $articleData = $article->findArticle((int) $id);
        return view('article', compact('articleData'));
    }

    public function commentUpdateForm(int $id, int $articleId)
    {
        $comment = new CommentsController;
        $commentData = $comment->findComment($id);
        return view('comment', compact('commentData', 'id', 'articleId'));
    }
}