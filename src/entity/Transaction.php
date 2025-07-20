<?php

namespace App\Entity;

use App\Entity\TypeTransaction;

class Transaction
{
    private ?int $id = null;
    private \DateTime $date;
    private TypeTransaction $typeTransaction;
    private float $montant;
    private ?Compte $compte;

    public function __construct(
        \DateTime $date,
        TypeTransaction $typeTransaction,
        float $montant,
        ?Compte $compte = null
    ) {
        $this->date = $date;
        $this->typeTransaction = $typeTransaction;
        $this->montant = $montant;
        $this->compte = $compte;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDate(): \DateTime
    {
        return $this->date;
    }
    public function setDate(\DateTime $date): void
    {
        $this->date = $date;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }
    public function setCompte(?Compte $compte): void
    {
        $this->compte = $compte;
    }

    public function getTypeTransaction(): TypeTransaction
    {
        return $this->typeTransaction;
    }
    public function setTypeTransaction(TypeTransaction $typeTransaction): void
    {
        $this->typeTransaction = $typeTransaction;
    }

    public function getMontant(): float
    {
        return $this->montant;
    }
    public function setMontant(float $montant): void
    {
        $this->montant = $montant;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'typeTransaction' => $this->typeTransaction->value,
            'montant' => $this->montant,
        ];
    }

    public static function toObject(array $data): self
    {
        $compte = null;
        if (isset($data['compte']) && is_array($data['compte'])) {
            $compte = \App\Entity\Compte::toObject($data['compte']);
        }
    
        return new self(
            new \DateTime($data['date']),
            TypeTransaction::from($data['typetransaction']),
            (float)$data['montant'],
            $compte
        );
    }
}
