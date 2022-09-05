<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface UsersService
{
    public function create($userData);

    public function update($id, $userData);

    public function get($start, $limit, $orderColumn, $orderDescOrAsc);

    public function find($id);

    public function delete($id);
}