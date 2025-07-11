<?php

namespace App\Entity;

use App\Entity\TypeTransaction;

class Transaction
{
    private ?int $id = null;
    private \DateTime $date;
    private TypeTransaction $typeTransaction;
    private float $montant;
    private int $compteId;
    private ?Compte $compte ;

    public function __construct(
        \DateTime $date,
        TypeTransaction $typeTransaction,
        float $montant,
        int $compteId,
        ?Compte $compte = null
    ) {
        $this->date = $date;
        $this->typeTransaction = $typeTransaction;
        $this->montant = $montant;
        $this->compteId = $compteId;
        $this->compte = $compte;
    }

    public function getId(): ?int { return $this->id; }
    public function getDate(): \DateTime { return $this->date; }
    public function setDate(\DateTime $date): void { $this->date = $date; }

    public function getCompte(): ?Compte { return $this->compte; }
    public function setCompte(?Compte $compte): void { $this->compte = $compte; }
    
    public function getTypeTransaction(): TypeTransaction { return $this->typeTransaction; }
    public function setTypeTransaction(TypeTransaction $typeTransaction): void { $this->typeTransaction = $typeTransaction; }

    public function getMontant(): float { return $this->montant; }
    public function setMontant(float $montant): void { $this->montant = $montant; }

    public function getCompteId(): int { return $this->compteId; }
    public function setCompteId(int $compteId): void { $this->compteId = $compteId; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'typeTransaction' => $this->typeTransaction->value,
            'montant' => $this->montant,
            'compteId' => $this->compteId,
        ];
    }

    public static function toObject(array $data): self
    {
        return new self(
            new \DateTime($data['date']),
            TypeTransaction::from($data['typeTransaction']),
            (float)$data['montant'],
            (int)$data['compteId']
        );
    }
}