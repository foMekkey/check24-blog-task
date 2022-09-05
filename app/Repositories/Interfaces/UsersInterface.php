<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface UsersInterface
{
    public function create($postData);

    public function update($id, $postData);

    public function get($start, $limit, $orderColumn, $orderDescOrAsc);

    public function find($id);

    public function delete($id);
}