<?php
namespace App\Core;

use Symfony\Component\Yaml\Yaml;
use ReflectionClass;
use Exception;

class App
{
    // Liste des services déclarés dans le fichier YAML
    private static array $services = [];

    // Objets déjà créés (pour ne pas recréer plusieurs fois)
    private static array $instances = [];

    // Initialise les services depuis le fichier YAML
    public static function run(): void
    {
        if (!self::$services) {
            $data = Yaml::parseFile(__DIR__ . '/../../config/service.yaml');
            self::$services = $data['services'] ?? [];
        }
    }

    // Récupère un service (par son nom dans le YAML)
    public static function getDependency(string $alias): object
    {
        // Si déjà créé → retourne l'objet
        if (isset(self::$instances[$alias])) {
            return self::$instances[$alias];
        }

        // Vérifie que le service existe dans le YAML
        if (!isset(self::$services[$alias])) {
            throw new Exception("Service '$alias' non trouvé.");
        }

        $className = self::$services[$alias];

        // Crée l'objet automatiquement
        $object = self::build($className);

        // Sauvegarde pour réutiliser plus tard
        self::$instances[$alias] = $object;

        return $object;
    }

    // Fonction qui crée un objet (avec ses dépendances)
    private static function build(string $className): object
    {
        if (!class_exists($className)) {
            throw new Exception("Classe '$className' introuvable.");
        }

        $reflection = new ReflectionClass($className);

        // Si pas de constructeur → on instancie directement
        if (!$reflection->getConstructor()) {
            return new $className();
        }

        // Sinon on regarde les paramètres du constructeur
        $dependencies = [];
        foreach ($reflection->getConstructor()->getParameters() as $param) {
            $type = $param->getType();

            // Si c’est un type de classe (ex : Logger), on crée cette dépendance
            if ($type && !$type->isBuiltin()) {
                $depClass = $type->getName();
                $dependencies[] = self::build($depClass);
            } else {
                throw new Exception("Paramètre non injectable dans '$className'");
            }
        }

        // Crée l'objet avec ses dépendances
        return $reflection->newInstanceArgs($dependencies);
    }
}
