<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\AuthInterface;

use PDO;

class AuthRepository implements AuthInterface
{
    protected $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function login($email): array
    {
        $checkLogin = $this->database->connect()->prepare("SELECT `id`, `password` FROM `users` WHERE `email` = :email; ");
        $checkLogin->bindParam(':email', $email);
        $checkLogin->execute();
        $currentUserDetails = $checkLogin->fetch(PDO::FETCH_ASSOC);
        if ($currentUserDetails)
            return $currentUserDetails;
        return [];
    }
}