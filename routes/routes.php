<?php

declare(strict_types=1);

use App\Controllers\WebControllers\UsersController;
use App\Controllers\WebControllers\ArticlesController;
use App\Controllers\WebControllers\CommentsController;
use App\Controllers\WebControllers\AuthController;
use App\Controllers\WebControllers\HomeController;
use Steampixel\Route;

$homeController = new HomeController;
$articlePageLimit = 3;

Route::add('/', function () use ($articlePageLimit) {
    $ArticlesController = new ArticlesController;
    return $ArticlesController->index(1, $articlePageLimit, 'id', "desc");
});

Route::add('/page/([0-9-]*)', function (int $page) use ($articlePageLimit) {
    $ArticlesController = new ArticlesController;
    return $ArticlesController->index($page, $articlePageLimit, 'id', "desc");
});

Route::add('/article/([0-9-]*)', function ($id) use ($homeController) {
    return $homeController->getArticle($id);
});

if (!sessions()->has('userId')) {
    Route::add('/login', function () use ($homeController) {
        return $homeController->loginForm();
    });

    Route::add('/login', function () {
        $AuthController = new AuthController;
        $userData = $AuthController->login($_POST['email'], $_POST['password']);

        if ($userData['status'] === 200) {
            redirect('/');
        } else {
            $flashMessage = $userData;
            redirect('/login', $flashMessage);
        }
    }, 'post');


    Route::add('/register', function () use ($homeController) {
        return $homeController->registerForm();
    });

    Route::add('/register', function () {
        $user = new UsersController;
        $userData = $user->createNewUser($_POST);
        if ($userData['status'] === 200) {
            redirect('/login');
        } else {
            $flashMessage = $userData;
            redirect('/register', $flashMessage);
        }
    }, 'post');
} else {

    Route::add('/article', function () use ($homeController) {
        return $homeController->articleForm();
    });

    Route::add('/article', function () {
        $_POST['author'] = sessions()->get('userId');
        $article = new ArticlesController;
        $articleData = $article->createNewArticle($_POST);
        if ($articleData['status'] === 200) {
            redirect('/');
        } else {
            $flashMessage = $articleData;
            redirect($_POST['redirect'], $flashMessage);
        }
    }, 'post');

    Route::add('/comment', function () {
        $_POST['author'] = sessions()->get('userId');
        $comment = new CommentsController;
        $commentData = $comment->createNewComment($_POST);
        if ($commentData['status'] === 200) {
            redirect($_POST['redirect']);
        } else {
            $flashMessage = $commentData;
            redirect($_POST['redirect'], $flashMessage);
        }
    }, 'post');

    Route::add('/comment/([0-9-]*)/([0-9-]*)', function (int $id, int $articleId) use ($homeController) {
        return $homeController->commentUpdateForm($id, $articleId);
    });

    Route::add('/comment/([0-9-]*)', function (int $id) {
        $_POST['author'] = sessions()->get('userId');
        $comment = new CommentsController;
        $commentData = $comment->updateComment($id, $_POST);
        if ($commentData['status'] === 200) {
            redirect($_POST['redirect']);
        } else {
            $flashMessage = $commentData;
            redirect("", $flashMessage, true);
        }
    }, 'post');

    Route::add('/delete-comment/([0-9-]*)', function (int $id) {
        $comment = new CommentsController;
        $commentData = $comment->deleteComment($id);
        if ($commentData['status'] === 200) {
            redirect("", [], true);
        } else {
            $flashMessage = $commentData;
            redirect("",  $flashMessage, true);
        }
    }, 'get');

    Route::add('/logout', function () {
        sessions()->clear();
        redirect('/');
    });
}