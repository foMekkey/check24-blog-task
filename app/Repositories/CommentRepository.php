<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\CommentsInterface;

use PDO;

class CommentRepository implements CommentsInterface
{
    protected $database;
    protected $currentDate;
    const DEFAULT_USER_ID = 0;

    public function __construct($database)
    {
        $this->database = $database;
        $this->currentDate = date("Y-m-d H:i:s");
    }

    public function create($commentData): bool
    {
        $comment = $this->database->connect()->prepare("INSERT INTO `comments` (`comment`, `author`, `article_id`, `created_at` ,`updated_at`) VALUES (:comment, :author, :article_id, :created_at, :updated_at);");
        $comment->bindParam(":comment", $commentData['comment']);
        $comment->bindParam(":author", sessions()->get('userId'), PDO::PARAM_INT);
        $comment->bindParam(":article_id", $commentData['article_id'], PDO::PARAM_INT);
        $comment->bindParam(":created_at", $this->currentDate);
        $comment->bindParam(":updated_at", $this->currentDate);
        $commentExec = $comment->execute();
        if ($commentExec)
            return true;
        return false;
    }

    public function update($id, $commentData): bool
    {
        $comment = $this->database->connect()->prepare("UPDATE `comments` SET `comment`=:comment, `updated_at`=:updated_at WHERE `id`=:id;");
        $comment->bindParam(":comment", $commentData['comment']);
        $comment->bindParam(":updated_at", $this->currentDate);
        $comment->bindParam(":id", $id, PDO::PARAM_INT);
        $commentExec = $comment->execute();
        if ($commentExec)
            return true;
        return false;
    }

    public function get($start, $limit, $orderColumn, $orderDescOrAsc): array
    {
        $rowCounts = $this->database->connect()->prepare("SELECT count(`id`) FROM `comments`;");
        $rowCounts->execute();
        $total_results = $rowCounts->fetchColumn();
        $total_pages = (int) ceil($total_results / $limit);
        $starting_rows = ($start - 1) * $limit;

        $comment = $this->database->connect()->prepare("SELECT `id` commentId, `comment` commentContent , created_at creationdate, created_at lastModifiedDate  FROM `comments` ORDER BY $orderColumn $orderDescOrAsc LIMIT :startFrom, :perPage;");
        $comment->bindParam(":startFrom", $starting_rows, PDO::PARAM_INT);
        $comment->bindParam(":perPage", $limit, PDO::PARAM_INT);
        $comment->execute();
        $getComment = $comment->fetchAll(PDO::FETCH_ASSOC);
        if ($getComment) {
            $commentData = [
                'comments' => $getComment,
                'paginator' => paginator($total_pages, $start)
            ];
            return $commentData;
        }
        return [];
    }

    public function find($id): array
    {
        $comment = $this->database->connect()->prepare("SELECT `id` commentId, `author`, `comment` commentContent , created_at creationdate, created_at lastModifiedDate FROM `comments` WHERE id=:id;");
        $comment->bindParam(":id", $id, PDO::PARAM_INT);
        $comment->execute();
        $getComment = $comment->fetch(PDO::FETCH_ASSOC);

        if ($getComment)
            return $getComment;
        return [];
    }

    public function delete($id): bool
    {
        $comment = $this->database->connect()->prepare("DELETE FROM `comments` WHERE id=:id;");
        $comment->bindParam(":id", $id, PDO::PARAM_INT);
        $commentExec = $comment->execute();
        if ($commentExec)
            return true;
        return false;
    }
}