<?php

use App\Core\App;

return [
    '/'           => [
        'controller' => App::getDependency('securiteController'),
        'method' => 'login'
    ],
    '/login'      => [
        'controller' => App::getDependency('securiteController'),
        'method' => 'login'
    ],
    '/inscription' => [
        'controller' => App::getDependency('securiteController'),
        'method' => 'Inscription'
    ],
    '/store'      => [
        'controller' => App::getDependency('compteController'),
        'method' => 'store'
    ],
    '/logout'     => [
        'controller' => App::getDependency('securiteController'),
        'method' => 'destroy'
    ],
    '/erreur'     => [

        'controller' => App::getDependency('erreurController'),
        'method' => 'erreur404'
    ],


    '/solde' => [

        'controller' => App::getDependency('compteController'),
        'method' => 'index',
        "middleware" => [
            'auth',
            'isClient'
        ]
    ],


    '/historique' => [

        'controller' => App::getDependency('TransactionController'),
        'method' => 'index',
        "middleware" => [
            'auth',
            'isClient'
        ]
    ],

];
