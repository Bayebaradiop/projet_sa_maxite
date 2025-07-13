<?php


namespace App\Service;

use App\Ripository\TransactionRipository;

class TransactionService
{
    private TransactionRipository $transactionRepo;

    public function __construct(TransactionRipository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }


    public function getLast10TransactionsByUserId(int $userId): array
    {
        return $this->transactionRepo->getLast10Transactions($userId);
    }

        public function afficheTOusLesTransactions(int $userId): array
    {
        return $this->transactionRepo->afficheTOusLesTransactions($userId);
    }
    
    

    public static function getInstance(): self
    {
        return new self(TransactionRipository::getInstance());
    }
}
