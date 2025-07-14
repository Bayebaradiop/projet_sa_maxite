<?php

namespace App\Controller;

use App\Core\AbstracteController;
use App\Core\App;
use App\Core\Validator;
use App\middlewares\CryptPassword;

class CompteController extends AbstracteController
{
    private $compteService;
    private $smsService;
    private $url;

    public function __construct()
    {
        parent::__construct();
        $this->compteService = App::getDependency('compteService');
        $this->smsService = App::getDependency('smsService');
        $this->url = getenv('URL');
    }

    public function create() {}
    public function delete() {}
    public function edit() {}
    public function show() {}
    public function update() {}
    public function destroy() {}

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Validator::resetErrors();
            Validator::validateInscription($_POST, $_FILES, $this->compteService);

            if (!Validator::isValid()) {
                $this->session->set('errors', Validator::getErrors());
                header('Location: ' . $this->url . '/inscription');
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

            header('Location: ' . $this->url . '/login');
            exit;
        }
    }



    public function index()
    {
        $user = $this->session->get('user');
        $userId = $user['id'];

        try {
                $comptePrincipal = $this->compteService->getComptePrincipalByUserId($userId);
            $this->render('Compte/solde', [
                'comptePrincipal' => $comptePrincipal
            ]);
        } catch (\Exception $e) {
            $this->session->set('errors', ['message' => $e->getMessage()]);
            header('Location: ' . $this->url . '/erreur');
            exit;
        }
    }


    public function AjouterCompteAffiche()
    {
        $user = $this->session->get('user');
        $userId = $user['id'];
                $comptePrincipal = $this->compteService->getComptePrincipalByUserId($userId);
              
        $secondaires = $this->compteService->getComptesSecondaireByUserId((int)$userId);
        $this->render("Compte/AjouterCompte", [
            'comptes' => $comptePrincipal,
            'comptesSecondaires' => $secondaires
        ]);
    }




    public function ajouterCompteSecondaire()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $user = $this->session->get('user');
                $userId = $user['id'];
                $comptePrincipal = $this->compteService->getComptePrincipalByUserId($userId);

                // Validation
            Validator:: validateCompteSecondaire($_POST, $this->compteService);

                if (!Validator::isValid()) {
                    $this->session->set('errors', Validator::getErrors());
                    $this->session->set('openPopup', true);
                    header('Location: ' . $this->url . '/AjouterCompte');
                    exit;
                }

                $numerotel = $_POST['numerotel'];
                $solde = isset($_POST['solde']) ? floatval($_POST['solde']) : 0;

                if ($solde > 0 && $comptePrincipal->getSolde() < $solde) {
                    $this->session->set('errors', ['solde' => 'Solde principal insuffisant']);
                    $this->session->set('openPopup', true);
                    header('Location: ' . $this->url . '/AjouterCompte');
                    exit;
                }

                $compteData = [
                    'numero' => rand(1000000000, 9999999999),
                    'datecreation' => date('Y-m-d H:i:s'),
                    'solde' => $solde,
                    'numerotel' => $numerotel,
                    'typecompte' => 'secondaire',
                    'userid' => $userId
                ];

                if ($solde > 0) {
                    $this->compteService->retirerSolde($comptePrincipal->getId(), $solde);
                }

                $this->compteService->ajouterCompteSecondaire($compteData);

                $this->session->set('success', 'Compte secondaire ajouté avec succès');
                header('Location: ' . $this->url . '/AjouterCompte');
                exit;
            } catch (\Exception $e) {
                $this->session->set('errors', ['message' => $e->getMessage()]);
                $this->session->set('openPopup', true);
                header('Location: ' . $this->url . '/AjouterCompte');
                exit;
            }
        }
    }


    public static function getInstance()
    {
        return new self();
    }
}
