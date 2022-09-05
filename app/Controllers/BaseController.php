<?php

declare(strict_types=1);

namespace App\Controllers;

use Rakit\Validation\Validator;
use App\Rules\ExistRule;
use App\Rules\UniqueRule;
use App\Database\DB;

class BaseController
{
    const UNPROCESSABLE_ENTITY = 422;
    const SUCCESS_STATUS = 200;
    const INTERNAL_ERROR = 500;
    const NOT_FOUND = 404;
    const UNPROCESSABLE_MSG = "validation error";
    const SUCCESS_MSG = "success";
    const INTERNAL_ERROR_MSG = "internal error";
    const NOT_FOUND_MSG = "no data listed";

    protected function validate(array $postData, array $rules = []): array
    {
        $database = new DB;
        $validator = new Validator;
        $validator->addValidator('exist', new ExistRule($database->connect()));
        $validator->addValidator('unique', new UniqueRule($database->connect()));

        $validation = $validator->make($postData, $rules);
        $validation->validate();

        if ($validation->fails()) {
            $errors = $validation->errors();
            return $errors->firstOfAll();
        }
        return [];
    }
}