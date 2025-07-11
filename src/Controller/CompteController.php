<?php
namespace App\Controller;

use App\Core\Session;
use App\Service\CompteService;
use App\Core\AbstracteController;
use App\Core\Validator;
use App\middlewares\CryptPassword;
use App\Service\SmsService;
class CompteController extends AbstracteController
{
    private CompteService $compteService;
    private SmsService $smsService;

    public function __construct()
    {
        parent::__construct(); 
        $this->compteService = new CompteService();
        $this->smsService = new SmsService();
    }

    public function create()
    {
     
    }

    public function delete()
    {

    }

    public function edit()
    {
        
    }

    public function show()
    {

    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Validator::resetErrors();

            if (Validator::isEmpty($_POST['nom'])) {
                Validator::addError('nom', 'Le nom est obligatoire.');
            }
            if (Validator::isEmpty($_POST['prenom'])) {
                Validator::addError('prenom', 'Le prénom est obligatoire.');
            }
            if (Validator::isEmpty($_POST['login'])) {
                Validator::addError('login', 'Le login est obligatoire.');
            }
            if (Validator::isEmpty($_POST['password'])) {
                Validator::addError('password', 'Le mot de passe est obligatoire.');
            }
            if (Validator::isEmpty($_POST['adresse'])) {
                Validator::addError('adresse', 'L\'adresse est obligatoire.');
            }
            if (Validator::isEmpty($_POST['numeroCarteidentite'])) {
                Validator::addError('numeroCarteidentite', 'Le numéro de carte d\'identité est obligatoire.');
            }
            if (Validator::isEmpty($_POST['numerotel'])) {
                Validator::addError('numerotel', 'Le numéro de téléphone est obligatoire.');
            }
            if (empty($_FILES['photorecto']['name'])) {
                Validator::addError('photorecto', 'La photo recto est obligatoire.');
            }
            if (empty($_FILES['photoverso']['name'])) {
                Validator::addError('photoverso', 'La photo verso est obligatoire.');
            }

            if (!Validator::isEmpty($_POST['numerotel'])) {
                if (!Validator::isValidPhone($_POST['numerotel'])) {
                    Validator::addError('numerotel', 'Le numéro de téléphone n\'est pas valide.');
                }
                if (!$this->compteService->isPhoneUnique($_POST['numerotel'])) {
                    Validator::addError('numerotel', 'Ce numéro de téléphone existe déjà.');
                }
            }

            if (!Validator::isEmpty($_POST['numeroCarteidentite'])) {
                if (!Validator::isValidCni($_POST['numeroCarteidentite'])) {
                    Validator::addError('numeroCarteidentite', 'Le numéro de CNI n\'est pas valide (13 chiffres).');
                }
                if (!$this->compteService->isCniUnique($_POST['numeroCarteidentite'])) {
                    Validator::addError('numeroCarteidentite', 'Ce numéro de CNI existe déjà.');
                }
            }
            if (!Validator::isValid()) {
                $this->session->set('errors', Validator::getErrors());
                header('Location: /inscription');
                exit;
            }


            $userData = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'login' => $_POST['login'],
                'password' => CryptPassword::crypt($_POST['password']),
                'numeroCarteidentite' => $_POST['numeroCarteidentite'],
                'photorecto' => $_FILES['photorecto']['name'] ?? '',
                'photoverso' => $_FILES['photoverso']['name'] ?? '',
                'adresse' => $_POST['adresse'],
                'typeuser' => 'client'
            ];

            $dateCreation = date('Y-m-d H:i:s');
            $solde = 65000;

            $compteData = [
                'numero' => rand(1000000000, 9999999999), 
                'datecreation' => $dateCreation,
                'solde' => $solde,
                'numerotel' => $_POST['numerotel'],
                'typecompte' => 'principal'
            ];

             $this->compteService->insertUserAndCompte($userData, $compteData);

        $this->smsService->sendSms($_POST['numerotel'], 'Votre compte a été créé avec succès !');

        header('Location: /login');
        exit;
        }
    }



    
 

    public function update()
    {

    }

    public function index()
    {
         $session = Session::getInstance();
        $user =$session->get('user');
        $userId = $user['id'];

 
        try {
            $comptes = $this->compteService->getComptesByUserId((int)$userId);
            
            $this->render('Compte/solde',
             [
                'comptes' => $comptes,
                'nombreComptes' => count($comptes)
            ]  
        );
          
            
        } catch (\Exception $e) {
            $this->session->set('errors', ['message' => $e->getMessage()]);
            header('Location: /erreur');
            exit;
        }
    }

    public function destroy()
    {

    }
   
   
}