<?php

namespace App\Core;

class App
{
    private static array $container = [];
    private static bool $initialized = false;
    
    public static function run(): void
    {
        self::initialize();
    }
    
    private static function initialize(): void
    {
        if (self::$initialized) {
            return;
        }
        
        $dependencies = [
            'core' => [
                'database' => \App\Core\Database::class,
                'session' => \App\Core\Session::class,
                'router' => \App\Core\Router::class,
            ],
            'abstract' => [
                'abstractRepository' => \App\Core\AbstracteRipository::class,
                'abstractService' => \App\Core\AbstracteService::class,
                'abstractEntity' => \App\Core\AbstractEntity::class,
                'abstractController' => \App\Core\AbstracteController::class,
            ],
            'services' => [
                'smsService' => \App\Service\SmsService::class,
                'compteService' => \App\Service\CompteService::class,
                'securityService' => \App\Service\SecurityService::class,
                'transactionService' => \App\Service\TransactionService::class,
            ],
            'controllers' => [
                'compteController' => \App\Controller\CompteController::class,
                'securiteController' => \App\Controller\SecuriteController::class,
                'erreurController' => \App\Controller\ErreurController::class,
                'TransactionController' => \App\Controller\TransactionController::class,
            ],
            'repositories' => [
    'userRepository' => \App\Ripository\UserRipository::class,
    'compteRepository' => \App\Ripository\CompteRipository::class,
    'TransactionRipository' => \App\Ripository\TransactionRipository::class,
],
        ];
        
        foreach ($dependencies as $category => $services) {
            foreach ($services as $key => $class) {
                self::$container[$category][$key] = fn() => $class::getInstance();
            }
        }
        
        self::$initialized = true;
    }
    
    
    public static function getDependency(string $key): mixed
    {
        self::initialize();
        
        foreach (self::$container as $category => $services) {
            if (array_key_exists($key, $services)) {
                $factory = $services[$key];
                return $factory();
            }
        }
        
        throw new \Exception("Dependency not found: " . $key);
    }
}

