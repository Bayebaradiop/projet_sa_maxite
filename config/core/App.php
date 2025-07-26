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

        if (isset(self::$instances[$key])) {
            return self::$instances[$key];
        }

        if (!isset(self::$services[$key])) {
            throw new Exception("Dependency not found: " . $key);
        }

        $className = self::$services[$key];
        $object = self::build($className);
        self::$instances[$key] = $object;
        return $object;
    }

    private static function build(string $className): object
    {
        // Cas particulier pour Session (singleton)
        if ($className === \App\Core\Session::class) {
            return \App\Core\Session::getInstance();
        }

        // Exemple d'extraction des arguments dans App.php
        if ($className === \PDO::class) {
            $dependencies = Yaml::parseFile(__DIR__ . '/../../config/service.yaml');
            $pdoConfig = $dependencies['core']['database'] ?? null;
            if ($pdoConfig && isset($pdoConfig['arguments'])) {
                $args = array_map(function($arg) {
                    if (preg_match('/^%(.*)%$/', $arg, $matches)) {
                        return $_ENV[$matches[1]];
                    }
                    return $arg;
                }, $pdoConfig['arguments']);
                return new \PDO(...$args);
            }
            throw new \Exception('PDO configuration missing in service.yaml');
        }

        if (!class_exists($className)) {
            throw new Exception("Class '$className' not found.");
        }

        $reflection = new ReflectionClass($className);

        if (!$reflection->getConstructor()) {
            return new $className();
        }

        $dependencies = [];
        foreach ($reflection->getConstructor()->getParameters() as $param) {
            $type = $param->getType();
            if ($type && !$type->isBuiltin()) {
                $depClass = $type->getName();
                // Recherche l'alias correspondant à la classe attendue
                $depKey = array_search($depClass, self::$services, true);
                if ($depKey === false) {
                    throw new Exception("No service defined for class $depClass");
                }
                $dependencies[] = self::getDependency($depKey);
            } else {
                // Valeur par défaut ou null si non injectable
                $dependencies[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
            }
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}