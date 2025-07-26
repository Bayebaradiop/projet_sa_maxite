<?php

namespace App\Service;

use App\Ripository\TransactionRipository;
use App\Ripository\CompteRipository;
use Exception;

class TransactionService
{
    private TransactionRipository $transactionRepo;
    private CompteRipository $compteRepo;

    public function __construct(TransactionRipository $transactionRepo, CompteRipository $compteRepo)
    {
        $this->transactionRepo = $transactionRepo;
        $this->compteRepo = $compteRepo;
    }

    public function getLast10TransactionsByUserId(int $userId): array
    {
        return $this->transactionRepo->getLast10Transactions($userId);
    }

    public function afficheTOusLesTransactions(int $userId): array
    {
        return $this->transactionRepo->afficheTOusLesTransactions($userId);
    }

    /**
     * Effectue un dépôt transactionnel (avec gestion des frais)
     */
    public function depotParTelephone(int $userIdSource, string $numeroTelDest, float $montant): void
    {
        $compteSource = $this->compteRepo->getComptePrincipalByUserId($userIdSource);
        $compteDest = $this->compteRepo->getCompteByNumeroTel($numeroTelDest);

        if (!$compteDest) {
            throw new \Exception("Aucun compte trouvé avec ce numéro de téléphone.");
        }

        $typeSource = $compteSource->getTypeCompte();
        $typeDest = $compteDest->getTypeCompte();

        error_log(
            "DEBUG: typeSource=" . $typeSource->value .
            ", typeDest=" . $typeDest->value .
            ", sourceTel=" . $compteSource->getNumeroTel() .
            ", destTel=" . $compteDest->getNumeroTel()
        );

        if (
            $typeSource->value !== 'principal' ||
            !in_array($typeDest->value, ['principal', 'secondaire'])
        ) {
            throw new \Exception("Transfert non autorisé.");
        }

        $commission = 0;
        if ($typeSource->value === 'principal' && $typeDest->value === 'principal') {
            $commission = min($montant * 0.08, 5000);
        }

        if ($compteSource->getSolde() < ($montant + $commission)) {
            throw new \Exception("Solde insuffisant.");
        }

        // Transaction SQL atomique (débit, crédit, enregistrement)
        $result = $this->transactionRepo->effectuerDepot(
            $compteSource->getId(),
            $compteDest->getId(),
            $montant,
            $commission
        );

        if (!$result) {
            throw new \Exception("Erreur lors de la transaction.");
        }
    }
}

