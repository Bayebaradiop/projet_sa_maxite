<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getInstance(): PDO
    {
        if (self::$connection === null) {
            try {
                // Utilisation des constantes définies dans env.php
                $host = DB_HOST;
                $port = DB_PORT;
                $dbname = DB_DATABASE;
                $username = DB_USERNAME;
                $password = DB_PASSWORD;

                $dsn = "pgsql:host={$host};port={$port};dbname={$dbname};";
                
                self::$connection = new PDO(
                    $dsn,
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données: " . $e->getMessage());
            }
        }
        
        return self::$connection;
    }
}





