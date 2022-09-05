<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\ArticleInterface;

use PDO;

class ArticleRepository implements ArticleInterface
{
    protected $database;
    protected $currentDate;

    const DEFAULT_USER_ID = 0;

    public function __construct($database)
    {
        $this->database = $database;
        $this->currentDate = date("Y-m-d H:i:s");
    }

    public function create($articleData): bool
    {
        $article = $this->database->connect()->prepare("INSERT INTO `articles` (`subject`, `content`, `author`, `created_at` ,`updated_at`) VALUES (:subject, :content, :author, :created_at, :updated_at);");
        $article->bindParam(":subject", $articleData['subject']);
        $article->bindParam(":content", $articleData['content']);
        $article->bindParam(":author", sessions()->get('userId'), PDO::PARAM_INT);
        $article->bindParam(":created_at", $this->currentDate);
        $article->bindParam(":updated_at", $this->currentDate);
        $article->execute();
        if ($article)
            return true;
        return false;
    }

    public function update($id, $articleData): bool
    {
        $article = $this->database->connect()->prepare("UPDATE `articles` SET `subject`=:subject, `content`=:content, `updated_at`=:updated_at WHERE `id`=:id;");
        $article->bindParam(":subject", $articleData['subject']);
        $article->bindParam(":content", $articleData['content']);
        $article->bindParam(":updated_at", $this->currentDate);
        $article->bindParam(":id", $id, PDO::PARAM_INT);
        $article->execute();
        if ($article)
            return true;
        return false;
    }

    public function get($start, $limit, $orderColumn, $orderDescOrAsc): array
    {
        $rowCounts = $this->database->connect()->prepare("SELECT count(`id`) FROM `articles`;");
        $rowCounts->execute();
        $total_results = $rowCounts->fetchColumn();
        $total_pages = (int) ceil($total_results / $limit);
        $starting_rows = ($start - 1) * $limit;

        $article = $this->database->connect()->prepare("SELECT `id` articleId, `subject` articleSubject, (SELECT `name` FROM `users` WHERE `users`.`id` = `articles`.`author`) author , `content` articleContent , created_at creationdate, created_at lastModifiedDate  FROM `articles` ORDER BY $orderColumn $orderDescOrAsc LIMIT :startFrom, :perPage;");
        $article->bindParam(":startFrom", $starting_rows, PDO::PARAM_INT);
        $article->bindParam(":perPage", $limit, PDO::PARAM_INT);
        $article->execute();

        $getArticle = $article->fetchAll(PDO::FETCH_ASSOC);

        $articleData = [];
        if ($getArticle) {
            $articleData = [
                'articles' => $getArticle,
                'paginator' => paginator($total_pages, $start)
            ];
        }
        return $articleData;
    }

    public function find($id): array
    {
        $article = $this->database->connect()->prepare("SELECT `id` articleId, `subject` articleSubject , `content` articleContent , (SELECT `name` FROM `users` WHERE `users`.`id` = `articles`.`author`) author , created_at creationdate, created_at lastModifiedDate FROM `articles` WHERE id=:id;");
        $article->bindParam(":id", $id, PDO::PARAM_INT);
        $article->execute();
        $getArticle = $article->fetch(PDO::FETCH_ASSOC);
        if ($getArticle)
            return $getArticle;
        return [];
    }

    public function delete($id): bool
    {
        $article = $this->database->connect()->prepare("DELETE FROM `articles` WHERE id=:id;");
        $article->bindParam(":id", $id, PDO::PARAM_INT);
        $articleExec = $article->execute();

        if ($articleExec)
            return true;
        return false;
    }

    public function comments(int $articleId): array
    {
        $comments = $this->database->connect()->prepare("SELECT `id`, `comment`, (SELECT `name` FROM users WHERE `users`.`id` = `comments`.`author` ) authorName , `author` , created_at creationdate FROM `comments`WHERE `article_id`=:id;");
        $comments->bindParam(":id", $articleId, PDO::PARAM_INT);
        $comments->execute();
        $getComments = $comments->fetchAll(PDO::FETCH_ASSOC);
        if ($getComments)
            return $getComments;
        return [];
    }
}