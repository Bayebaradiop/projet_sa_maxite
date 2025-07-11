<?php
namespace App\Ripository;
use PDO;
use App\Entity\Compte;
use App\Core\AbstracteController;
use App\Core\AbstracteRipository;

class CompteRipository extends AbstracteRipository
{

    public function __construct()
    {
        parent::__construct();

    }





public function findByUserId(int $userId): array
{
    $sql = "SELECT c.id, c.numero, c.datecreation, c.solde, c.numerotel, c.typecompte, 
                  u.id as userid, u.nom, u.prenom
           FROM compte c
           INNER JOIN users u ON u.id = c.userid
           WHERE u.id = :userid";
    $statement = $this->pdo->prepare($sql);
    $statement->bindParam(':userid', $userId, PDO::PARAM_INT);
    $statement->execute();
    
    $comptes = [];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $userData = [
            'id' => $row['userid'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom']
        ];
        
        $compteData = $row;
        $compteData['user'] = $userData;
        
        $comptes[] = Compte::toObject($compteData);
    }
    
    return $comptes;
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
}


