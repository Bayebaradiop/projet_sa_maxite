<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Migration
{
    private static ?\PDO $pdo = null;

    private static function connect()
    {
        if (self::$pdo === null) {
            $dsn = $_ENV['dsn'];
            $user = $_ENV['DB_USERNAME'];
            $pass = $_ENV['DB_PASSWORD'];
            self::$pdo = new \PDO($dsn, $user, $pass);
        }
    }

    public static function up()
    {
        self::connect();

        $queries = [
            "CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                nom VARCHAR(100),
                prenom VARCHAR(100),
                login VARCHAR(100) UNIQUE,
                password VARCHAR(255),
                numeroCarteIdentite VARCHAR(20) UNIQUE NULL,
                photoRecto VARCHAR(255) DEFAULT NULL,
                photoVerso VARCHAR(255) DEFAULT NULL,
                adresse VARCHAR(255),
                typeUser VARCHAR(20),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS comptes (
                id SERIAL PRIMARY KEY,
                numero VARCHAR(20) UNIQUE,
                datecreation TIMESTAMP,
                solde FLOAT,
                numerotel VARCHAR(20),
                typecompte VARCHAR(20),
                userid INT,
                FOREIGN KEY (userid) REFERENCES users(id)
            )",
            "CREATE TABLE IF NOT EXISTS transactions (
                id SERIAL PRIMARY KEY,
                date TIMESTAMP,
                typeTransaction VARCHAR(20),
                montant FLOAT,
                compteId INT,
                FOREIGN KEY (compteId) REFERENCES comptes(id)
            )"
        ];

        foreach ($queries as $sql) {
            self::$pdo->exec($sql);
        }

        echo "Migration terminée avec succès.\n";
    }
}

Migration::up();