<?php

namespace App\Core;

use Symfony\Component\Yaml\Yaml;
use ReflectionClass;
use Exception;

class App
{
    private static array $services = [];
    private static array $instances = [];
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

        $dependencies = Yaml::parseFile(__DIR__ . '/../../config/service.yaml');
        // On aplatit toutes les catégories en un seul tableau [alias => class]
        foreach ($dependencies as $category => $services) {
            foreach ($services as $key => $class) {
                // Si c'est un tableau (ex: database), prends la clé 'class'
                if (is_array($class) && isset($class['class'])) {
                    self::$services[$key] = $class['class'];
                } else {
                    self::$services[$key] = $class;
                }
            }
        }

        self::$initialized = true;
    }

    public static function getDependency(string $key): object
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

