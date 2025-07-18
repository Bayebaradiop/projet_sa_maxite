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
            $controllerClass = $route['controller'];
            $method = $route['method'];

            if (isset($route['middleware'])) {
                $middlewares = Middleware::getMiddlewares();
                if (isset($middlewares[$route['middleware']])) {
                    $middlewares[$route['middleware']](); 
                }
            }

            $controller = new $controllerClass();
            $controller->$method();
        } else {
            header('Location: /erreur');
            exit;
        }
    }
}
