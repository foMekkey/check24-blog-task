<?php

declare(strict_types=1);

namespace App\Rules;

use Rakit\Validation\Rule;
use PDO;

class ExistRule extends Rule
{
    protected $message = ":attribute is not found in our records";

    protected $fillableParams = ['table', 'column'];

    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function check($value): bool
    {
        $this->requireParameters(['table', 'column']);
        $column = $this->parameter('column');
        $table = $this->parameter('table');

        $stmt = $this->pdo->prepare("select count(*) as count from `{$table}` where `{$column}` = :value");
        $stmt->bindParam(':value', $value);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return intval($data['count']) !== 0;
    }
}