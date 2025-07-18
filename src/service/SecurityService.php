<?php

namespace App\Service;

use App\Core\Singleton;
use App\Entity\Users;
use Exception;
use App\Ripository\UserRipository;

class SecurityService
{
    use Singleton;

    private UserRipository $userRipository;

    public function __construct()
    {
        $this->userRipository = \App\Core\App::getDependency('userRepository');
    }

    public function login(string $login, string $password): ?Users
    {
        try {
            return $this->userRipository->selectloginandpassword($login, $password);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la connexion: " . $e->getMessage(), 0, $e);
        }
    }
}
