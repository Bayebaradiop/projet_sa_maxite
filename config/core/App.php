<?php

namespace App\Core;

class App
{
    private static array $dependencies = [];

    public static function run()
    {
        self::$dependencies = [
            // 'App\Core\Session' => Session::getInstance(),
            // 'App\Ripository\ProduitRipository' => new \App\Ripository\ProduitRipository(),
            // 'App\Ripository\CommandeRipository' => new \App\Ripository\CommandeRipository(),
            // 'App\Ripository\ClientRipository' => new \App\Ripository\ClientRipository(),
            // 'App\Service\CommandeService' => new \App\Service\CommandeService(new \App\Ripository\CommandeRipository()),
            // 'App\Service\ClientService' => new \App\Service\ClientService(new \App\Ripository\ClientRipository()),
            // 'App\Core\Database' => Database::getInstance(),
        ];
    }

    public static function getDependency(string $key)
    {
        if (array_key_exists($key, self::$dependencies)) {
            return self::$dependencies[$key];
        }
        throw new \Exception("Dependency not found: " . $key);
    }
}



