<?php
namespace App\Core;
use PDO;
use App\Core\Database;
class AbstracteRipository{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
    }
}


