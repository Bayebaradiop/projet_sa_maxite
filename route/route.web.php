<?php


use App\Controller\SecuriteController;
use App\Controller\ErreurController;
use App\Controller\CompteController;

return [
        '/'=>['controller'=> SecuriteController::class, 'method' => 'login'],
       '/login'=>['controller'=> SecuriteController::class, 'method' => 'login'],
    '/inscription'=>['controller'=> SecuriteController::class, 'method' => 'Inscription'],
    '/store'=>['controller'=> CompteController::class, 'method' => 'store'],
    '/logout'=>['controller'=> SecuriteController::class, 'method' => 'destroy'],
    '/solde'=>['controller'=> CompteController::class, 'method' => 'index'],
    '/erreur' => ['controller' => ErreurController::class, 'method' => 'erreur404'],   

];


