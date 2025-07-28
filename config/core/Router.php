<?php

namespace App\Core;
use App\Config\Middleware;

class Router
{
    public static function resolve(array $routes): void
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $currentUri = trim($requestUri, '');

        if (isset($routes[$currentUri])) {
            $route = $routes[$currentUri];
            $controllerAlias = $route['controller']; // Doit être l'alias YAML (ex: 'securiteController')
            $method = $route['method'];

            if (isset($route['middleware'])) {
                $middlewares = Middleware::getMiddlewares();
                if (isset($middlewares[$route['middleware']])) {
                    $middlewares[$route['middleware']](); 
                }
            }

            // Utilise le conteneur pour injecter les dépendances du contrôleur
            $controller = \App\Core\App::getDependency($controllerAlias);
            $controller->$method();
        } else {
            header('Location: /erreur');
            exit;
        }
    }
}
