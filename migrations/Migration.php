<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__)); 
$dotenv->load();

$dsn = $_ENV['dsn'] ?? $_ENV['DSN'];
$user = $_ENV['DB_USERNAME'];
$pass = $_ENV['DB_PASSWORD'];

$driver = '';
if (stripos($dsn, 'pgsql:host') === 0) {
    $driver = 'pgsql';
} elseif (stripos($dsn, 'mysql:host') === 0) {
    $driver = 'mysql';
}

preg_match('/dbname=([^;]+)/', $dsn, $matches);
$dbName = $matches[1] ?? null;

if ($driver === 'pgsql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', 'dbname=postgres', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE \"$dbName\"");
        echo "Base de données \"$dbName\" créée ou déjà existante.\n";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'already exists') === false) {
            die("Erreur création base: " . $e->getMessage());
        }
    }
}
if ($driver === 'mysql' && $dbName) {
    $dsnDefault = preg_replace('/dbname=([^;]+)/', '', $dsn);
    try {
        $pdo = new PDO($dsnDefault, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Base de données `$dbName` créée ou déjà existante.\n";
    } catch (PDOException $e) {
        die("Erreur création base: " . $e->getMessage());
    }
}

class Migration
{
    private static ?\PDO $pdo = null;
    private static string $driver = '';

    private static function connect()
    {
        global $dsn, $user, $pass, $driver;
        if (self::$pdo === null) {
            self::$pdo = new \PDO($dsn, $user, $pass);
            self::$driver = $driver;
        }
    }

    private static function type($type)
    {
        // Adapte les types selon le SGBD
        $map = [
            'id' => [
                'pgsql' => 'SERIAL PRIMARY KEY',
                'mysql' => 'INT AUTO_INCREMENT PRIMARY KEY'
            ],
            'date' => [
                'pgsql' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
                'mysql' => 'DATETIME DEFAULT CURRENT_TIMESTAMP'
            ]
        ];
        return $map[$type][self::$driver] ?? $type;
    }

    public static function up()
    {
        self::connect();

        $queries = [
            "CREATE TABLE IF NOT EXISTS users (
                id " . self::type('id') . ",
                nom VARCHAR(100) NOT NULL,
                prenom VARCHAR(100) NOT NULL,
                login VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                numerocarteidentite VARCHAR(50) NULL UNIQUE,
                photorecto VARCHAR(255),
                photoverso VARCHAR(255),
                adresse TEXT,
                typeuser " . (self::$driver === 'pgsql'
    ? "VARCHAR(20) NOT NULL CHECK (typeuser IN ('client', 'service_commercial'))"
    : "ENUM('client','service_commercial') NOT NULL"
) . "
            )",
            "CREATE TABLE IF NOT EXISTS compte (
                id " . self::type('id') . ",
                numero VARCHAR(20) NOT NULL UNIQUE,
                datecreation " . self::type('date') . ",
                solde DECIMAL(15, 2) DEFAULT 0.00,
                numerotel VARCHAR(20) NOT NULL,
                typecompte " . (self::$driver === 'pgsql'
    ? "VARCHAR(20) NOT NULL CHECK (typecompte IN ('principal', 'secondaire'))"
    : "ENUM('principal','secondaire') NOT NULL"
) . ",
                userid INTEGER NOT NULL,
                FOREIGN KEY (userid) REFERENCES users(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS transactions (
                id " . self::type('id') . ",
                date " . self::type('date') . ",
                typetransaction " . (self::$driver === 'pgsql'
    ? "VARCHAR(20) NOT NULL CHECK (typetransaction IN ('depot', 'retrait', 'paiement'))"
    : "ENUM('depot','retrait','paiement') NOT NULL"
) . ",
                montant DECIMAL(15, 2) NOT NULL,
                compteid INTEGER NOT NULL,
                FOREIGN KEY (compteid) REFERENCES compte(id) ON DELETE CASCADE
            )"
        ];

        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "Migration terminée avec succès pour le SGBD : " . self::$driver . "\n";
    }
}

Migration::up();