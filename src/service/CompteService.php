<?php

namespace App\Service;

use App\Core\App;
use App\Ripository\CompteRipository;

class CompteService
{
    private  $compteRepository;

    public function __construct(CompteRipository $compteRepository)
    {
        $this->compteRepository = $compteRepository;

    }

    public function getComptesByUserId(int $userId): array
    {
        return $this->compteRepository->findByUserId($userId);
    }

    public function insertUserAndCompte(array $userData, array $compteData): bool
    {
        return $this->compteRepository->insertUserAndCompte($userData, $compteData);
    }

    public function isPhoneUnique(string $phone): bool
    {
        return $this->compteRepository->isPhoneUnique($phone);
    }

    public function isCniUnique(string $cni): bool
    {
        return $this->compteRepository->isCniUnique($cni);
    }

    public static function getInstance(): self
    {
        return new self();
    }

    public function ajouterCompteSecondaire(array $data): bool
    {
        return $this->compteRepository->ajouterSecondaire($data);
    }

    public function getComptePrincipalByUserId(int $userId): ?\App\Entity\Compte
    {
        return $this->compteRepository->getComptePrincipalByUserId($userId);
    }


    public function retirerSolde(int $compteId, float $montant): bool
    {
        return $this->compteRepository->retirerSolde($compteId, $montant);
    }

    public function getComptesSecondaireByUserId(int $userId): array
    {
        return $this->compteRepository->getComptesSecondaireByUserId($userId);
    }


public function basculerEnprincipal(int $userId, int $compteSecondaireId): void
{
    $this->compteRepository->basculerEnprincipal($userId, $compteSecondaireId);
}

}
