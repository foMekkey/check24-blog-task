<?php

declare(strict_types=1);

namespace App\Controllers\WebControllers;

use App\Controllers\BaseController;
use App\Providers\ServiceProvider;
use App\Services\Interfaces\UsersService;
use Exception;

class UsersController extends BaseController
{

    protected $usersService;

    public function __construct()
    {
        $this->usersService = ServiceProvider::getInstance()->get(UsersService::class);
    }

    public function createNewUser(array $userData): array
    {
        try {

            $rules =  [
                'name'  => 'required',
                'email' => "required|email|unique:users,email",
                'password'  => 'required|min:6',
                'conf_password'  => 'required|min:6|same:password'
            ];

            $validation = $this->validate($userData, $rules);

            if (count($validation) > 0)
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);

            $user = $this->usersService->create($userData);
            if ($user) {
                unset($userData['password']);
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $userData);
            }
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, ["desc" => "no data inserted"]);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function updateUser(int $id, array $userData): array
    {
        try {

            $userDetails = $this->usersService->find($id);
            if (count($userDetails) === 0)
                return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, ["desc" => "user not found"]);

            $userCurrentEmail = $userDetails['useremail'];
            $rules =  [
                'name'  => 'required',
                'email' => "required|email|unique:users,email,$userCurrentEmail",
                'password'  => 'required|min:6'
            ];

            $validation = $this->validate($userData, $rules);
            if (count($validation) > 0)
                return response(SELF::UNPROCESSABLE_ENTITY, SELF::UNPROCESSABLE_MSG, $validation);

            $user = $this->usersService->update($id, $userData);
            if ($user) {
                unset($userData['password']);
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $userData);
            }
            return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, ["desc" => "no data updated"]);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function showUsers(int $start, int $limit, string $orderColumn, string $orderDescOrAsc): array
    {
        try {
            $getUsers = $this->usersService->get($start, $limit, $orderColumn, $orderDescOrAsc);
            if (count($getUsers) > 0)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $getUsers);

            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function findUser(int $id): array
    {
        try {
            $getUser = $this->usersService->find($id);
            if ($getUser)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, $getUser);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, []);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }

    public function deleteUser(int $id): array
    {
        try {
            $user = $this->usersService->delete($id);
            if ($user)
                return response(SELF::SUCCESS_STATUS, SELF::SUCCESS_MSG, ["desc" => "deleted"]);
            return response(SELF::NOT_FOUND, SELF::NOT_FOUND_MSG, ["desc" => "no data to delete"]);
        } catch (Exception $e) {
            return response(SELF::INTERNAL_ERROR, SELF::INTERNAL_ERROR_MSG, ["desc" => $e->getMessage()]);
        }
    }
}