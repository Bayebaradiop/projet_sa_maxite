<?php

namespace App\Service;

use App\Entity\Compte;
use App\Ripository\CompteRipository;

class CompteService 
{
    private CompteRipository $compteRipository;
    
    public function __construct()
    {
        $this->compteRipository = new CompteRipository();
        
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
    
}