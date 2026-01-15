<?php

namespace App;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            // Docker service name
            $host = 'mysql';

            // Database naam uit docker-compose
            $db = 'developmentdb';

            // Gebruiker uit docker-compose
            $user = 'developer';
            $pass = 'secret123';

            // Charset expliciet definiëren
            $charset = 'utf8mb4';

            // DSN opbouwen
            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

            self::$pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$pdo;
    }
}