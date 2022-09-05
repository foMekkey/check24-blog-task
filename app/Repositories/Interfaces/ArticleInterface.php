<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ArticleInterface
{
    public function create(array $postData);

    public function update(int $id, array $postData);

    public function get(int $start, int $limit, string $orderColumn, int $orderDescOrAsc);

    public function find(int $id);

    public function delete(int $id);

    public function comments(int $articleId);
}