<?php
return [
    '/'           => [
        'controller' => 'securiteController',
        'method' => 'login'
    ],
    '/login'      => [
        'controller' => 'securiteController',
        'method' => 'login'
    ],
    '/inscription' => [
        'controller' => 'securiteController',
        'method' => 'Inscription',
    ],
    '/store'      => [
        'controller' => 'securiteController',
        'method' => 'store'
    ],
    '/logout'     => [
        'controller' => 'securiteController',
        'method' => 'destroy'
    ],
    '/erreur'     => [
        'controller' => 'erreurController',
        'method' => 'erreur404'
    ],
    '/solde' => [
        'controller' => 'compteController',
        'method' => 'index',
        'middleware' => 'auth'
    ],
    '/historique' => [
        'controller' => 'TransactionController',
        'method' => 'index',
        'middleware' => 'auth'
    ],
    '/afficheTOusLesTransactions'=>[
        'controller' => 'TransactionController',
        'method' => 'afficheTOusLesTransactions',
        'middleware' => 'auth'
    ],
    '/AjouterCompte'=>[
        'controller' => 'compteController',
        'method' => 'AjouterCompteAffiche',
        'middleware' => 'auth'
    ],
    '/ajouterCompteSecondaire' => [
        'controller' => 'compteController',
        'method' => 'ajouterCompteSecondaire',
        'middleware' => 'auth'
    ],
    '/changerComptePrincipal' => [
        'controller' => 'compteController',
        'method' => 'changerComptePrincipal',
        'middleware' => 'auth'
    ],
    '/depot' => [
        'controller' => 'TransactionController',
        'method' => 'depot',
        'middleware' => 'auth'
    ],
];