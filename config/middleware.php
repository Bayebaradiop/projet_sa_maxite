<?php

use App\Core\App;
use App\Entity\TypeUser;

const TYPE_CLIENT = TypeUser::Client;
const TYPE_SERVICE_COMMERCIAL = TypeUser::ServiceCommercial;

global $middlewares;

function getSession()
{
    return App::getDependency('session');
}


function isConnect()
{
    return getSession()->isset('user');
}


function getUser()
{
    $session = getSession();
    return $session->isset('user') ? $session->get('user') : null;
}


function sama_type($user, $type)
{
    if (is_object($user)) {
        return $user->getType() === $type;
    } else if (is_array($user) && isset($user['type'])) {
        return $user['type'] === $type;
    }
    return false;
}

$middlewares = [
    'auth' => function () {
        if (!isConnect()) {
            header('Location: /login');
            exit;
        }
        return true;
    },

    'isClient' => function () {
        $user = getUser();

        if ($user && sama_type($user, TYPE_CLIENT)) {
            return true;
        }

        header('Location: /erreur403');
        exit;
    },

    'service_commerce' => function () {
        $user = getUser();

        if ($user && sama_type($user, TYPE_SERVICE_COMMERCIAL)) {
            return true;
        }

        header('Location: /erreur403');
        exit;
    }
];


function sama_middlewear($middlewareName)
{
    global $middlewares;

    if (!is_array($middlewares) || empty($middlewares)) {
        throw new \Exception("Le tableau des middlewares n'est pas défini ou est vide");
    }

    if (!isset($middlewares[$middlewareName])) {
        $availableMiddlewares = implode(', ', array_keys($middlewares));
        throw new \Exception("Middleware '$middlewareName' n'existe pas. Middlewares disponibles: $availableMiddlewares");
    }

    $middleware = $middlewares[$middlewareName];
    return $middleware();
}
