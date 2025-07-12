<?php


namespace App\Controller;

use App\Core\AbstracteController;
use App\Core\App;

class TransactionController extends AbstracteController
{
    private  $transactionService;

    public function __construct()
    {
        parent::__construct();
        $this->transactionService = App::getDependency('transactionService');
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

    public function destroy() {}
    public function create()
    {
        // Logique pour créer une transaction
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
    public static function getInstance()
    {
        return new self();
    }
}
