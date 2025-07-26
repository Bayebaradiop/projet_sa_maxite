<?php

namespace App\Controller;

use App\Core\AbstracteController;
use App\Service\CompteService;
use App\Service\SmsService;
use App\Core\Session;
use App\Core\Validator;
use App\middlewares\CryptPassword;

class CompteController extends AbstracteController
{
    private CompteService $compteService;
    private SmsService $smsService;
    private string $url;

    public function __construct(Session $session, CompteService $compteService, SmsService $smsService)
    {
        parent::__construct($session);
        $this->compteService = $compteService;
        $this->smsService = $smsService;
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
            $validator = Validator::getInstance();

            $rules = [
                'numerocarteidentite' => [
                    'required',
                    'isCNI'
                ],
                'login' => ['required'],
                'password' => [
                    'required',
                    ['minLength', 6, "Le mot de passe doit contenir au moins 6 caractères"]
                ],
                'adresse' => ['required'],
                'numerotel' => [
                    'required',
                    'isSenegalPhone'
                ]
            ];

            if (!$validator->validate($_POST, $rules)) {
                $this->session->set('errors', $validator->getErrors());
                header('Location: ' . $this->url . '/inscription');
                exit;
            }

            try {
                // Appel à l’API AppDAF
                $nci = $_POST['numerocarteidentite'];
                $url = "http://appdaf.com/api/citoyen/" . urlencode($nci);
                $response = @file_get_contents($url);

                if ($response === false) {
                    $error = error_get_last();
                    error_log("Erreur lors de l'appel à AppDAF: " . json_encode($error));
                    $this->session->set('errors', ['numerocarteidentite' => "Erreur de connexion à AppDAF"]);
                    header('Location: ' . $this->url . '/inscription');
                    exit;
                }

                $data = json_decode($response, true);

                if (!is_array($data) || !isset($data['statut'])) {
                    error_log("Réponse inattendue de AppDAF: " . $response);
                    $this->session->set('errors', ['numerocarteidentite' => "Réponse inattendue de AppDAF"]);
                    header('Location: ' . $this->url . '/inscription');
                    exit;
                }

                if ($data['statut'] !== 'success') {
                    error_log("NCI non trouvé dans AppDAF: " . $nci);
                    $this->session->set('errors', ['numerocarteidentite' => "Numéro de carte d'identité non trouvé dans AppDAF"]);
                    header('Location: ' . $this->url . '/inscription');
                    exit;
                }

                $citoyen = $data['data'];

                $userData = [
                    'nom' => $citoyen['nom'],
                    'prenom' => $citoyen['prenom'],
                    'login' => $_POST['login'],
                    'password' => CryptPassword::crypt($_POST['password']),
                    'numerocarteidentite' => $citoyen['nci'],
                    'photorecto' => $citoyen['url_carte_recto'],
                    'photoverso' => $citoyen['url_carte_verso'],
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

                $result = $this->compteService->insertUserAndCompte($userData, $compteData);
                if (!$result) {
                    error_log("Erreur lors de l'insertion en base pour le NCI: " . $nci);
                    $this->session->set('errors', ['message' => "Erreur lors de la création du compte"]);
                    header('Location: ' . $this->url . '/inscription');
                    exit;
                }

                $this->smsService->sendSms($_POST['numerotel'], 'Votre compte a été créé avec succès !');

                header('Location: ' . $this->url . '/login');
                exit;
            } catch (\Exception $e) {
                error_log("Exception dans CompteController::store: " . $e->getMessage());
                $this->session->set('errors', ['message' => "Erreur technique : " . $e->getMessage()]);
                header('Location: ' . $this->url . '/inscription');
                exit;
            }
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
            $validator = Validator::getInstance();

            $rules = [
                'numerotel' => [
                    'required',
                    'isSenegalPhone'
                ],
               
            ];

            if (!$validator->validate($_POST, $rules)) {
                $this->session->set('errors', $validator->getErrors());
                $this->session->set('openPopup', true);
                header('Location: ' . $this->url . '/AjouterCompte');
                exit;
            }

            try {
                $user = $this->session->get('user');
                $userId = $user['id'];
                $comptePrincipal = $this->compteService->getComptePrincipalByUserId($userId);

                // if (!Validator::isValid()) {
                //     $this->session->set('errors', Validator::getErrors());
                //     $this->session->set('openPopup', true);
                //     header('Location: ' . $this->url . '/AjouterCompte');
                //     exit;
                // }

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


public function changerComptePrincipal()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $this->session->get('user');
        $userId = $user['id'];
        $compteSecondaireId = $_POST['compte_id'] ?? null;

        if ($compteSecondaireId) {
            $this->compteService->basculerEnprincipal($userId, (int)$compteSecondaireId);
            $this->session->set('success', 'Le compte secondaire est maintenant principal.');
        }
        header('Location: ' . $this->url . '/AjouterCompte');
        exit;
    }
}


  
}
