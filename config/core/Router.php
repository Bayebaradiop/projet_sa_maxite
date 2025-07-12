<?php

namespace App\Core;

require_once __DIR__ . '/../middleware.php';

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
                if (is_array($route['middleware'])) {
                    foreach ($route['middleware'] as $middleware) {
                        sama_middlewear($middleware);
                    }
                } else {
                    sama_middlewear($route['middleware']);
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
