<?php

declare(strict_types=1);

namespace App\Controllers\WebControllers;

use App\Controllers\BaseController;
use App\Providers\ServiceProvider;
use App\Services\Interfaces\AuthService;

class AuthController extends BaseController
{
    protected $authService;

    public function __construct()
    {
        $this->authService = ServiceProvider::getInstance()->get(AuthService::class);
    }

    public function login(string $email, string $password)
    {
        $loginData = [
            "email" => $email,
        ];

        $rules = ['email' => "required|email|exist:users,email"];

        $validation = $this->validate($loginData, $rules);

        if (count($validation) > 0)
            return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => 'invalid credentials']);

        $currentUserDetails = $this->authService->login($email);
        if (password_verify($password, $currentUserDetails['password'])) {
            sessions()->set('userId', $currentUserDetails['id']);
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, []);
        }
        return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, ["desc" => 'invalid credentials']);
    }
}