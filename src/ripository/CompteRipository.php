<?php

namespace App\Ripository;

use PDO;
use App\Entity\Compte;
use App\Core\AbstracteRipository;

class CompteRipository extends AbstracteRipository
{

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getComptePrincipalByUserId($userId): ?Compte
    {
        $sql = "SELECT * FROM compte WHERE userid = :userid AND typecompte = 'principal' LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return Compte::toObject($row);
        }
        return null;
    }

    public function insertUserAndCompte(array $userData, array $compteData): bool
    {
        try {
            $this->pdo->beginTransaction();

            $sqlUser = "INSERT INTO users (nom, prenom, login, password, numeroCarteidentite, photorecto, photoverso, adresse, typeuser)
                    VALUES (:nom, :prenom, :login, :password, :numeroCarteidentite, :photorecto, :photoverso, :adresse, :typeuser)";
            $stmtUser = $this->pdo->prepare($sqlUser);
            $stmtUser->execute([
                ':nom' => $userData['nom'],
                ':prenom' => $userData['prenom'],
                ':login' => $userData['login'],
                ':password' => $userData['password'],
                ':numeroCarteidentite' => $userData['numeroCarteidentite'],
                ':photorecto' => $userData['photorecto'],
                ':photoverso' => $userData['photoverso'],
                ':adresse' => $userData['adresse'],
                ':typeuser' => $userData['typeuser']
            ]);
            $userId = $this->pdo->lastInsertId();

            $sqlCompte = "INSERT INTO compte (numero, datecreation, solde, numerotel, typecompte, userid)
                      VALUES (:numero, :datecreation, :solde, :numerotel, :typecompte, :userid)";
            $stmtCompte = $this->pdo->prepare($sqlCompte);
            $stmtCompte->execute([
                ':numero' => $compteData['numero'],
                ':datecreation' => $compteData['datecreation'],
                ':solde' => $compteData['solde'],
                ':numerotel' => $compteData['numerotel'],
                ':typecompte' => $compteData['typecompte'],
                ':userid' => $userId
            ]);

            $this->pdo->commit();
            return true;
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }


    public function isPhoneUnique(string $phone): bool
    {
        $sql = "SELECT COUNT(*) FROM compte WHERE numerotel = :phone";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    public function isCniUnique(string $cni): bool
    {
        $sql = "SELECT COUNT(*) FROM users WHERE numeroCarteidentite = :cni";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cni', $cni);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    public static function getInstance(): self
    {
        return new self();
    }


    public function ajouterSecondaire(array $data): bool
    {
        $sql = "INSERT INTO compte (numero, datecreation, solde, numerotel, typecompte, userid)
            VALUES (:numero, :datecreation, :solde, :numerotel, 'secondaire', :userid)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':numero' => $data['numero'],
            ':datecreation' => $data['datecreation'],
            ':solde' => $data['solde'],
            ':numerotel' => $data['numerotel'],
            ':userid' => $data['userid']
        ]);
    }




    public function retirerSolde(int $compteId, float $montant): bool
    {
        $sql = "UPDATE compte SET solde = solde - :montant WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':montant' => $montant,
            ':id' => $compteId
        ]);
    }

    public function getComptesSecondaireByUserId(int $userId): array
    {
        $sql = "SELECT * FROM compte WHERE userid = :userid AND typecompte = 'secondaire'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userid', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $comptes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comptes[] = Compte::toObject($row);
        }
        return $comptes;
    }

public function basculerEnprincipal(int $userId, int $compteSecondaireId): void
{
    $sql1 = "UPDATE compte SET typecompte = 'secondaire' WHERE userid = :userid AND typecompte = 'principal'";
    $stmt1 = $this->pdo->prepare($sql1);
    $stmt1->bindParam(':userid', $userId, \PDO::PARAM_INT);
    $stmt1->execute();
    $sql2 = "UPDATE compte SET typecompte = 'principal' WHERE id = :id AND userid = :userid";
    $stmt2 = $this->pdo->prepare($sql2);
    $stmt2->bindParam(':id', $compteSecondaireId, \PDO::PARAM_INT);
    $stmt2->bindParam(':userid', $userId, \PDO::PARAM_INT);
    $stmt2->execute();
}
}
