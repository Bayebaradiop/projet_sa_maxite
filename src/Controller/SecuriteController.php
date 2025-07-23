<?php

namespace App\Controller;

use App\Core\App;
use App\Core\Validator;
use Exception;
use App\Core\AbstracteController;
use App\Service\SecurityService;
use App\Core\Session;

class SecuriteController extends AbstracteController
{
    private $securityService;
    private $url;

    public function __construct(SecurityService $securityService, Session $session)
    {
        parent::__construct( );
        $this->layout = 'securite';
        $this->session = $session;
        $this->securityService = $securityService;
        $this->url = getenv('URL');
    }

    public function register() {}
    public function create() {}
    public function delete() {}
    public function edit() {}
    public function show() {}
    public function store() {}
    public function update() {}

    public function index()
    {
        $this->render('login/login');
    }

    public function login()
    {
        $errors = $this->session->get('errors');
        if ($errors) $this->session->unset('errors');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $loginData = [
                'login' => $_POST['login'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $rules = [
                'login' => [
                    'required',
                    ['minLength', 4, "Le login doit contenir au moins 4 caractères"]
                ],
                'password' => [
                    'required',
                    ['minLength', 4, "Le mot de passe doit contenir au moins 4 caractères"]
                ]
            ];

            $validator = Validator::getInstance();
            if (!$validator->validate($loginData, $rules)) {
                $this->session->set('errors', $validator->getErrors());
                header('Location: ' . $this->url . '/');
                exit();
            }

            try {
                $user = $this->securityService->login($loginData['login'], $loginData['password']);
                if (!$user) {
                    $validator->addError('password', "Identifiant incorrect");
                    $this->session->set('errors', $validator->getErrors());
                    header('Location: ' . $this->url . '/');
                    exit();
                }

                $this->session->set('user', $user->toArray());
                $this->session->set('typeuser', $user->getId());
                $userType = $user->getTypeUser()->value;

                if ($userType === 'client') {
                    header('Location: ' . $this->url . '/solde');
                } elseif ($userType === 'serviceCommercial') {
                } else {
                    header('Location: ' . $this->url . '/solde');
                }
                exit();
            } catch (Exception $e) {
                $validator->addError('system', "Erreur système");
                $this->session->set('errors', $validator->getErrors());
                header('Location: ' . $this->url . '/');
                exit();
            }
        } else {
            $this->render('login/login', ['errors' => $errors]);
        }
    }

    public function Inscription()
    {
        $errors = $_SESSION['errors'] ?? [];
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }

        $this->render('login/Inscription', [
            'errors' => $errors
        ]);
    }

    public function destroy()
    {
        $this->session->destroy('user');
        header('Location: ' . $this->url . '/');
        exit();
    }
    
}
