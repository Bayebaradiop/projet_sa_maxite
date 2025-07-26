<?php

namespace App\Controller;

use App\Core\AbstracteController;
use App\Service\TransactionService;
use App\Core\Session;

class TransactionController extends AbstracteController
{
    private TransactionService $transactionService;

    public function __construct(Session $session, TransactionService $transactionService)
    {
        parent::__construct($session);
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $user = $this->session->get('user');
        $userId = $user['id'];
        $transactions = $this->transactionService->getLast10TransactionsByUserId($userId);
        $this->render('Transaction/historique10derniere', [
            'transactions' => $transactions
        ]);
    }


    public function afficheTOusLesTransactions()
    {
        $user = $this->session->get('user');
        $userId = $user['id'];
        $transactions = $this->transactionService->afficheTOusLesTransactions($userId);

        $this->render("Transaction/TousLesTransaction", [
            'transactions' => $transactions
        ]);
    }

    public function depot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->session->get('user');
            $userId = $user['id'];
            $numeroTel = $_POST['numerotel'] ?? '';
            $montant = floatval($_POST['montant'] ?? 0);

            try {
                $this->transactionService->depotParTelephone($userId, $numeroTel, $montant);
                $this->session->set('success', 'Dépôt effectué avec succès.');
            } catch (\Exception $e) {
                $this->session->set('errors', ['message' => $e->getMessage()]);
            }
            // Redirige vers l'historique après le dépôt
            $url = getenv('URL') ?: '';
            header('Location: ' . $url . '/historique');
            exit;
        }
        // Affiche la page de dépôt si GET
        $this->render('Transaction/historique10derniere');
    }
    public function destroy() {}
    public function create()
    {
    }
    public function edit()
    {
        // Logique pour éditer une transaction
    }

    public function show()
    {
        // Logique pour afficher une transaction spécifique
    }
    public function store()
    {
        // Logique pour stocker une nouvelle transaction
    }
    public function update()
    {
        // Logique pour mettre à jour une transaction
    }


    
 
}
