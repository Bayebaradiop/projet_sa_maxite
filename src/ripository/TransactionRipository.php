<?php


namespace App\Ripository;

use PDO;
use App\Core\AbstracteRipository;
use App\Entity\Transaction;
class TransactionRipository extends AbstracteRipository
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getLast10Transactions($userId): array
    {
        $sql = "SELECT t.* 
            FROM transactions t
            INNER JOIN compte c ON t.compteid = c.id
            WHERE c.userid = :userid and c.typecompte='principal'
            ORDER BY t.date DESC
            LIMIT 10";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userid', $userId, PDO::PARAM_INT);
        $statement->execute();

        $transactions = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = \App\Entity\Transaction::toObject($row);
        }
        return $transactions;
    }


   public function afficheTOusLesTransactions($userId): array
    {
        $sql = "SELECT t.* 
            FROM transactions t
            INNER JOIN compte c ON t.compteid = c.id
            WHERE c.userid = :userid and c.typecompte='principal'
            ORDER BY t.date DESC
            ";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userid', $userId, PDO::PARAM_INT);
        $statement->execute();

        $transactions = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }


    public static function getInstance(): self
    {
        return new self();
    }
}
