<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\UsersInterface;
use PDO;

class UsersRepository implements UsersInterface
{
    protected $database;
    protected $currentDate;

    public function __construct($database)
    {
        $this->database = $database;
        $this->currentDate = date("Y-m-d H:i:S");
    }

    public function create($userData): bool
    {
        $password = password_hash($userData['password'], PASSWORD_BCRYPT);
        $user = $this->database->connect()->prepare("INSERT INTO `users` (`name`, `email`, `password`, `created_at`) VALUES(:name, :email, :password, :created_at);");
        $user->bindParam(":name", $userData['name']);
        $user->bindParam(":email", $userData['email']);
        $user->bindParam(":password", $password);
        $user->bindParam(":created_at", $this->currentDate);
        $userExec = $user->execute();
        if ($userExec)
            return true;
        return false;
    }

    public function update($id, $userData): bool
    {
        $password = password_hash($userData['password'], PASSWORD_BCRYPT);
        $user = $this->database->connect()->prepare("UPDATE `users` SET `name`=:name, `email`=:email, `password`=:password WHERE `id`=:id");
        $user->bindParam(":name", $userData['name']);
        $user->bindParam(":email", $userData['email']);
        $user->bindParam(":password", $password);
        $user->bindParam(":id", $id, PDO::PARAM_INT);
        $userExec = $user->execute();
        if ($userExec)
            return true;
        return false;
    }

    public function get($start, $limit, $orderColumn, $orderDescOrAsc): array
    {
        $rowCounts = $this->database->connect()->prepare("SELECT count(`id`) FROM `users`;");
        $rowCounts->execute();
        $total_results = $rowCounts->fetchColumn();
        $total_pages = (int) ceil($total_results / $limit);
        $starting_rows = ($start - 1) * $limit;

        $users = $this->database->connect()->prepare("SELECT `id` userid, `name` username , `email` useremail , created_at creationdate  FROM users ORDER BY $orderColumn $orderDescOrAsc LIMIT :startFrom, :perPage;");
        $users->bindParam(":startFrom", $starting_rows, PDO::PARAM_INT);
        $users->bindParam(":perPage", $limit, PDO::PARAM_INT);
        $users->execute();
        $getUsers = $users->fetchAll(PDO::FETCH_ASSOC);

        if ($getUsers) {
            $userData = [
                'users' => $getUsers,
                'paginator' => paginator($total_pages, $start)
            ];
            return $userData;
        }
        return [];
    }

    public function find($id): array
    {
        $user = $this->database->connect()->prepare("SELECT `id` userid, `name` username , `email` useremail , created_at creationdate FROM `users` WHERE id=:id;");
        $user->bindParam(":id", $id, PDO::PARAM_INT);
        $user->execute();
        $getUser = $user->fetch(PDO::FETCH_ASSOC);
        if ($getUser) {
            return $getUser;
        }
        return [];
    }

    public function delete($id): bool
    {
        $user = $this->database->connect()->prepare("DELETE FROM `users` WHERE id=:id;");
        $user->bindParam(":id", $id, PDO::PARAM_INT);
        $userExec = $user->execute();
        if ($userExec)
            return true;
        return false;
    }
}