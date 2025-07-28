<?php

namespace App\Ripository;

use PDO;
use App\Core\AbstracteRipository;
use App\Entity\Transaction;

class TransactionRipository extends AbstracteRipository
{
    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
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
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }

    public function afficheTOusLesTransactions($userId): array
    {
        $sql = "SELECT t.* 
            FROM transactions t
            INNER JOIN compte c ON t.compteid = c.id
            WHERE c.userid = :userid and c.typecompte='principal'
            ORDER BY t.date DESC";
        $statement = $this->pdo->prepare($sql);
        $statement->bindParam(':userid', $userId, PDO::PARAM_INT);
        $statement->execute();

        $transactions = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = Transaction::toObject($row);
        }
        return $transactions;
    }

    public function effectuerDepot(
        int $compteSourceId,
        int $compteDestId,
        float $montant,
        float $commission = 0
    ): bool {
        try {
            $this->pdo->beginTransaction();

            // Débiter le compte source (montant + commission)
            $sqlDebit = "UPDATE compte SET solde = solde - :total WHERE id = :id";
            $stmtDebit = $this->pdo->prepare($sqlDebit);
            $stmtDebit->execute([
                ':total' => $montant + $commission,
                ':id' => $compteSourceId
            ]);

            // Créditer le compte destinataire (montant)
            $sqlCredit = "UPDATE compte SET solde = solde + :montant WHERE id = :id";
            $stmtCredit = $this->pdo->prepare($sqlCredit);
            $stmtCredit->execute([
                ':montant' => $montant,
                ':id' => $compteDestId
            ]);

            // Enregistrer la transaction de débit
            $sqlTransDebit = "INSERT INTO transactions (date, typetransaction, montant, compteid)
                              VALUES (NOW(), 'depot', :montant, :compteid)";
            $stmtTransDebit = $this->pdo->prepare($sqlTransDebit);
            $stmtTransDebit->execute([
                ':montant' => -($montant + $commission),
                ':compteid' => $compteSourceId
            ]);

            // Enregistrer la transaction de crédit
            $sqlTransCredit = "INSERT INTO transactions (date, typetransaction, montant, compteid)
                               VALUES (NOW(), 'depot', :montant, :compteid)";
            $stmtTransCredit = $this->pdo->prepare($sqlTransCredit);
            $stmtTransCredit->execute([
                ':montant' => $montant,
                ':compteid' => $compteDestId
            ]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            error_log("Erreur SQL dépôt : " . $e->getMessage());
            return false;
        }
    }
}
