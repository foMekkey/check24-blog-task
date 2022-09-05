<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface ArticlesService
{
    public function create($articleData);

    public function update($id, $articleData);

    public function get($start, $limit, $orderColumn, $orderDescOrAsc);

    public function find($id);

    public function delete($id);

    public function comments($articleId);
}