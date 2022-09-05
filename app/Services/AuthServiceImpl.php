<?php

declare(strict_types=1);

namespace App\Services;

use App\Services\Interfaces\AuthService;
use App\Repositories\Interfaces\AuthInterface;
use App\Providers\ServiceProvider;

class AuthServiceImpl implements AuthService
{
    protected $repository;

    public function __construct()
    {
        $this->repository = ServiceProvider::getInstance()->get(AuthInterface::class);
    }

    public function login($email)
    {
        return $this->repository->login($email);
    }
}