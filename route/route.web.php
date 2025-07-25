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
        'method' => 'Inscription',
        
        
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
        'middleware' => 'auth'
    ],

    '/historique' => [
        'controller' => App::getDependency('TransactionController'),
        'method' => 'index',
        'middleware' => 'auth'
    ],

    '/afficheTOusLesTransactions'=>[
        'controller' => App::getDependency('TransactionController'),
        'method' => 'afficheTOusLesTransactions',
        'middleware' => 'auth'
    ],

    '/AjouterCompte'=>[
        'controller' => App::getDependency('compteController'),
        'method' => 'AjouterCompteAffiche',
        'middleware' => 'auth'
    ],

    '/ajouterCompteSecondaire' => [
        'controller' => App::getDependency('compteController'),
        'method' => 'ajouterCompteSecondaire',
        'middleware' => 'auth'
    ],

    '/changerComptePrincipal' => [
        'controller' => App::getDependency('compteController'),
        'method' => 'changerComptePrincipal',
        'middleware' => 'auth'
    ],

    '/depot' => [
        'controller' => App::getDependency('TransactionController'),
        'method' => 'depot',
        'middleware' => 'auth'
    ],
];
