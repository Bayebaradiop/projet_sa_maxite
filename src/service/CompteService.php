<?php

namespace App\Service;

use App\Core\App;

class CompteService
{
    private  $compteRipository;

    public function __construct()
    {
        $this->compteRipository = App::getDependency('compteRepository');
    }

    public function getComptesByUserId(int $userId): array
    {
        return $this->compteRipository->findByUserId($userId);
    }

    public function insertUserAndCompte(array $userData, array $compteData): bool
    {
        return $this->compteRipository->insertUserAndCompte($userData, $compteData);
    }

    public function isPhoneUnique(string $phone): bool
    {
        return $this->compteRipository->isPhoneUnique($phone);
    }

    public function isCniUnique(string $cni): bool
    {
        return $this->compteRipository->isCniUnique($cni);
    }

    public static function getInstance(): self
    {
        return new self();
    }

public function ajouterCompteSecondaire(array $data): bool
{
    return $this->compteRipository->ajouterSecondaire($data);
}

    public function getComptePrincipalByUserId(int $userId): ?\App\Entity\Compte
    {
        return $this->compteRipository->getComptePrincipalByUserId($userId);
    }


public function retirerSolde(int $compteId, float $montant): bool
{
    return $this->compteRipository->retirerSolde($compteId, $montant);
}

public function getComptesSecondaireByUserId(int $userId): array
{
    return $this->compteRipository->getComptesSecondaireByUserId($userId);
}
}
