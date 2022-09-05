<?php

declare(strict_types=1);

namespace App\Controllers\WebControllers;

use App\Controllers\BaseController;
use App\Providers\ServiceProvider;
use App\Services\Interfaces\ArticlesService;

use Exception;

class ArticlesController extends BaseController
{
    protected $articleService;

    public function __construct()
    {
        $this->articleService = ServiceProvider::getInstance()->get(ArticlesService::class);
    }

    public function index(int $start, int $limit, $orderColumn, $orderDescOrAsc)
    {
        $articlesList = $this->showArticles($start, $limit, $orderColumn, $orderDescOrAsc);
        return view('index', compact('articlesList', 'start'));
    }

    public function createNewArticle(array $articleData): array
    {
        try {

            $rules =  [
                'subject' => 'required',
                'content' => "required",
                'author' => 'nullable|exist:users,id'
            ];

            $validation = $this->validate($articleData, $rules);

            if (count($validation) > 0)
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);

            $article = $this->articleService->create($articleData);
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $articleData);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function updateArticle(int $id, $articleData): array
    {
        try {
            if ($this->articleService->find($id)['author'] !== (int) sessions()->get('userId'))
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => "you can't modify this article , you are not the article owner !"]);

            $rules =  [
                'subject' => 'required',
                'content' => "required",
                'author' => 'nullable|exist:users,id'
            ];

            $validation = $this->validate($articleData, $rules);
            if (count($validation) > 0)
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);

            $article = $this->articleService->update($id, $articleData);

            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $articleData);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function showArticles(int $start, int $limit, string $orderColumn, string $orderDescOrAsc): array
    {
        try {
            $getArticle = $this->articleService->get($start, $limit, $orderColumn, $orderDescOrAsc);
            if (count($getArticle) > 0)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $getArticle);

            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function findArticle(int $id): array
    {
        try {
            $getArticle = $this->articleService->find($id);
            if ($getArticle) {
                $fullArticleWithComments = [
                    "article" => $getArticle,
                    "comments" => $this->articleService->comments($id)
                ];
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $fullArticleWithComments);
            }
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function deleteArticle(int $id): array
    {
        try {
            if ($this->articleService->find($id)['author'] !== (int) sessions()->get('userId'))
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => "you can't modify this article , you are not the article owner !"]);

            $article = $this->articleService->delete($id);
            if ($article)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, ["desc" => "deleted"]);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, ["desc" => "not found"]);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }
}