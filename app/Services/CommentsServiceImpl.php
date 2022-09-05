<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\CommentsService;
use App\Repositories\Interfaces\CommentsInterface;
use App\Providers\ServiceProvider;

class CommentsServiceImpl implements CommentsService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = ServiceProvider::getInstance()->get(CommentsInterface::class);
    }

    public function create($commentData)
    {
        return $this->repository->create($commentData);
    }

    public function update($id, $commentData)
    {
        return $this->repository->update($id, $commentData);
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
}