<?php

namespace App\Service;

use App\Core\Singleton;
use App\Ripository\TransactionRipository;

class TransactionService
{
    use Singleton;

    private TransactionRipository $transactionRepo;

    public function __construct()
    {
        $this->transactionRepo = \App\Core\App::getDependency('TransactionRipository');
    }

    public function getLast10TransactionsByUserId(int $userId): array
    {
        return $this->transactionRepo->getLast10Transactions($userId);
    }

    public function afficheTOusLesTransactions(int $userId): array
    {
        return $this->transactionRepo->afficheTOusLesTransactions($userId);
    }
}
