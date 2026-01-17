<?php

namespace App;

use PDO;

class Database
{
    private static ?PDO $pdo = null;

    public static function pdo(): PDO
    {
        if (self::$pdo === null) {
            //Docker service name
            $host = 'mysql';

            //Database naam uit docker-compose
            $db = 'developmentdb';

            //Gebruiker uit docker-compose
            $user = 'developer';
            $pass = 'secret123';

            //Charset expliciet definiëren
            $charset = 'utf8mb4';

            //DSN opbouwen
            $dsn = "mysql:host={$host};dbname={$db};charset={$charset}";

            self::$pdo = new PDO($dsn, $user, $pass, [

                //Zorgt ervoor dat PDO exceptions gooit bij fouten
                //voorkomt silent failures en maakt debugging veiliger
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                //Resultaten standaard als associative array
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                //voorkomt dat PDO queries emuleert
                //echte prepared statements
                //extra bescherming tegen SQL-injectie
                PDO::ATTR_EMULATE_PREPARES   => false,

            ]);
        }

        return self::$pdo;
    }
}