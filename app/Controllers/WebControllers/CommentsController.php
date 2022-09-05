<?php

declare(strict_types=1);

namespace App\Controllers\WebControllers;

use App\Controllers\BaseController;
use App\Providers\ServiceProvider;
use App\Services\Interfaces\CommentsService;
use Exception;

class CommentsController extends BaseController
{

    protected $commentService;

    public function __construct()
    {
        $this->commentService = ServiceProvider::getInstance()->get(CommentsService::class);
    }

    public function createNewComment(array $commentData): array
    {
        try {
            $rules = [
                'comment' => "required",
                'author' => 'nullable|exist:users,id',
                'article_id' => 'nullable|exist:articles,id'
            ];
            $validation = $this->validate($commentData, $rules);

            if (count($validation) > 0)
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);
            $this->commentService->create($commentData);
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $commentData);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function updateComment(int $id, array $commentData): array
    {
        try {
            if ($this->commentService->find($id)['author'] !== (int) sessions()->get('userId'))
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => "you can't modify this comment , you are not the comment owner !"]);
            $rules = [
                'comment' => "required"
            ];
            $validation = $this->validate($commentData, $rules);
            if (count($validation) > 0) {
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);
            }
            $this->commentService->update($id, $commentData);
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $commentData);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function showComments(int $start, int $limit, string $orderColumn, string $orderDescOrAsc): array
    {
        try {
            $getComment = $this->commentService->get($start, $limit, $orderColumn, $orderDescOrAsc);
            if ($getComment)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $getComment);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function findComment(int $id): array
    {
        try {
            $getComment = $this->commentService->find($id);
            if ($getComment)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $getComment);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function deleteComment(int $id): array
    {
        try {
            if ($this->commentService->find($id)['author'] !== (int) sessions()->get('userId'))
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => "you can't modify this comment , you are not the comment owner !"]);
            $comment = $this->commentService->delete($id);
            if ($comment)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, ["desc" => "deleted"]);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, ["desc" => "no data to deleted"]);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }
}