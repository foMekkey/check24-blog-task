<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface CommentsService
{
    public function create($commentData);

    public function update($id, $commentData);

    public function get($start, $limit, $orderColumn, $orderDescOrAsc);

    public function find($id);

    public function delete($id);
}