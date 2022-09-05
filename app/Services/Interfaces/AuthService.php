<?php

declare(strict_types=1);

namespace App\Services\Interfaces;

interface AuthService
{
    public function login($email);
}