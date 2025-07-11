<?php
namespace App\Controller;
use App\Core\Validator;

use Exception;
use App\Service\SecurityService;
use App\Core\AbstracteController;
use App\Ripository\UserRipository;

class SecuriteController extends AbstracteController
{
        private SecurityService $securityService;

    public function __construct()
    {
        parent::__construct();        
        $this->layout = 'securite';
        $userRepository = new UserRipository();
        $this->securityService = new SecurityService($userRepository);
    }


    public function register()
    {

    }

     public function create()
    {
     
    }
    public function delete(){

    }
    public function edit()
    {
        
    }
    public function show(){}
 
    public function store()
    {
        
    }
    public function update(){} 

    public function index()
    {

        $this->render('login/login');
    }

        public function login()
    {
        $errors = $this->session->get('errors');
        if ($errors) {
            $this->session->unset('errors');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';
            
            Validator::resetErrors();

            if (Validator::isEmpty($login)) {
                Validator::addError('login', 'Le login est obligatoire');
            }

            if (Validator::isEmpty($password)) {
                Validator::addError('password', 'Le mot de passe est obligatoire');
            }

            if (!Validator::isValid()) {
                $this->session->set('errors', Validator::getErrors());

                header('Location: /');
                exit();
            }
            
            try {
                $user = $this->securityService->login($login, $password);
                
                if ($user) {
                    $this->session->set('user',$user->toArray());
                    $this->session->set('typeuser', $user->getId());
                    
                    $userType = $user->getTypeUser()->value;

                    if ($userType === 'client') {
                        $this->session->set('success', 'Connexion réussie ! Bienvenue sur votre espace client.');
                        header('Location: /solde');
                    } else if ($userType === 'serviceCommercial') {
                        $this->session->set('success', 'Connexion réussie ! Bienvenue sur votre espace vendeur.');
                        // header('Location: /lister');
                        // exit();
                    } else {
                        $this->session->set('success', 'Connexion réussie !');
                        header('Location: /solde'); 
                    }
                    exit();
                } else {
                    Validator::addError('auth', 'Identifiants incorrects');
                    $this->session->set('errors', Validator::getErrors());

                    header('Location: /');
                    exit();
                }
            } catch (Exception $e) {
                Validator::addError('system', 'Une erreur est survenue lors de la connexion');
                $this->session->set('errors', Validator::getErrors());

                header('Location: /');
                exit();
            }
        } else {
            
            $this->render('login/login', [
                'errors' => $errors
            ]);
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
        header('Location: /');
        exit();
    }


}

?>