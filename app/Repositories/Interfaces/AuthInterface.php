<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface AuthInterface
{
    public function login($email);
}