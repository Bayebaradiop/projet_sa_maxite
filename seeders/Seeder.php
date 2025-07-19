<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$dsn = $_ENV['dsn'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

class Seeder {
    public static function seed() {
        $pdo = new PDO($GLOBALS['dsn'], $GLOBALS['user'], $GLOBALS['pass']);

        // Seed users
        $users = [
            [
                'nom'      => 'M.wane',
                'prenom'   => 'M.wane',
                'login'    => 'wane@gmail.com',
                 'password' => password_hash('passer123', PASSWORD_BCRYPT),
                'cni'      => 'CNI20250001',
                'recto'    => 'recto1.jpg',
                'verso'    => 'verso1.jpg',
                'adresse'  => 'Dakar, Sénégal',
                'typeuser' => 'client'
            ],
            [
                'nom'      => 'A.Diop',
                'prenom'   => 'Awa',
                'login'    => 'adiop@gmail.com',
                'password' => password_hash('passer123', PASSWORD_BCRYPT),
                'cni'      => 'CNI20250002',
                'recto'    => 'recto2.jpg',
                'verso'    => 'verso2.jpg',
                'adresse'  => 'Thiès, Sénégal',
                'typeuser' => 'client'
            ],
            [
                'nom'      => 'M.Ba',
                'prenom'   => 'Moussa',
                'login'    => 'mba@gmail.com',
                'password' => password_hash('passer123', PASSWORD_BCRYPT),
                'cni'      => 'CNI20250003',
                'recto'    => 'recto3.jpg',
                'verso'    => 'verso3.jpg',
                'adresse'  => 'Saint-Louis, Sénégal',
                'typeuser' => 'service_commercial'
            ]
        ];

        $sqlUser = "INSERT INTO users (nom, prenom, login, password, numerocarteidentite, photorecto, photoverso, adresse, typeuser)
                VALUES (:nom, :prenom, :login, :password, :cni, :recto, :verso, :adresse, :typeuser)";
        $stmtUser = $pdo->prepare($sqlUser);

        foreach ($users as $user) {
            $stmtUser->execute($user);
        }

        echo count($users) . " utilisateurs seedés avec succès.\n";

        $userIds = [];
        $stmt = $pdo->query("SELECT id FROM users ORDER BY id ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $userIds[] = $row['id'];
        }

        $compte = [
            [
                'numero'      => 'CP001',
                'datecreation'=> date('Y-m-d H:i:s'),
                'solde'       => 1000.00,
                'numerotel'   => '0612345678',
                'typecompte'  => 'principal',
                'userid'      => $userIds[0] ?? 1
            ],
            [
                'numero'      => 'CP002',
                'datecreation'=> date('Y-m-d H:i:s'),
                'solde'       => 2000.00,
                'numerotel'   => '0634567890',
                'typecompte'  => 'principal',
                'userid'      => $userIds[1] ?? 2
            ],
            [
                'numero'      => 'CP003',
                'datecreation'=> date('Y-m-d H:i:s'),
                'solde'       => 3000.00,
                'numerotel'   => '0645678901',
                'typecompte'  => 'principal',
                'userid'      => $userIds[2] ?? 3
            ]
        ];

        $compteIndex = 1;
        foreach ($userIds as $index => $uid) {
            for ($i = 1; $i <= 5; $i++) {
                $compte[] = [
                    'numero'      => 'CS' . str_pad($compteIndex, 3, '0', STR_PAD_LEFT),
                    'datecreation'=> date('Y-m-d H:i:s'),
                    'solde'       => rand(100, 1000),
                    'numerotel'   => '07' . rand(10000000, 99999999),
                    'typecompte'  => 'secondaire',
                    'userid'      => $uid
                ];
                $compteIndex++;
            }
        }

        $sqlCompte = "INSERT INTO compte (numero, datecreation, solde, numerotel, typecompte, userid)
                      VALUES (:numero, :datecreation, :solde, :numerotel, :typecompte, :userid)";
        $stmtCompte = $pdo->prepare($sqlCompte);

        foreach ($compte as $compte) {
            $stmtCompte->execute($compte);
        }

        echo count($compte) . " compte seedés avec succès.\n";

        // Récupérer les IDs des compte insérés
        $compteIds = [];
        $stmt = $pdo->query("SELECT id FROM compte ORDER BY id ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $compteIds[] = $row['id'];
        }

        // Générer 5 transactions pour chaque compte
        $transactions = [];
        foreach ($compteIds as $cid) {
            for ($i = 1; $i <= 5; $i++) {
                $transactions[] = [
                    'date'             => date('Y-m-d H:i:s', strtotime("-$i days")),
                    'typetransaction'  => ['depot', 'retrait', 'paiement'][array_rand(['depot', 'retrait', 'paiement'])],
                    'montant'          => rand(100, 2000),
                    'compteid'         => $cid
                ];
            }
        }

        $sqlTransaction = "INSERT INTO transactions (date, typetransaction, montant, compteid)
                           VALUES (:date, :typetransaction, :montant, :compteid)";
        $stmtTransaction = $pdo->prepare($sqlTransaction);

        foreach ($transactions as $transaction) {
            $stmtTransaction->execute($transaction);
        }

        echo count($transactions) . " transactions seedées avec succès.\n";
    }
}

Seeder::seed();