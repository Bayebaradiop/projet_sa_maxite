<?php


namespace App\Ripository;

use PDO;
use App\Core\AbstracteRipository;
use App\Entity\Users;
use App\middlewares\CryptPassword;

class UserRipository extends AbstracteRipository
{

    public function __construct()
    {
        parent::__construct();
    }

    public function selectloginandpassword($login, $password): ?Users
    {
        $query = "SELECT * FROM users WHERE login = :login";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':login', $login);
        $statement->execute();

        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            if (CryptPassword::verify($password, $row['password'])) {
                return Users::toObject($row);
            }
        }
        return null;
    }

    public static function getInstance(): self
    {
        return new self();
    }
}
