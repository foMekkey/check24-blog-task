<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\ArticlesService;
use App\Repositories\Interfaces\ArticleInterface;
use App\Providers\ServiceProvider;

class ArticlesServiceImpl implements ArticlesService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = ServiceProvider::getInstance()->get(ArticleInterface::class);
    }

    public function create($articleData)
    {
        return $this->repository->create($articleData);
    }

    public function update($id, $articleData)
    {
        return $this->repository->update($articleData);
    }

    public function get($start, $limit, $orderColumn, $orderDescOrAsc)
    {
        return $this->repository->get($start, $limit, $orderColumn, $orderDescOrAsc);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function comments($articleId)
    {
        return $this->repository->comments($articleId);
    }
}