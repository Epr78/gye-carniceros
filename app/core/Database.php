<?php

class Database
{
    private static $connection = null;

    public static function connect()
    {
        if (self::$connection === null) {

            $config = require __DIR__ . '/../config/database.php';

            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']};charset={$config['charset']}";

            self::$connection = new PDO(
                $dsn,
                $config['username'],
                $config['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        }

        return self::$connection;
    }
}
?>