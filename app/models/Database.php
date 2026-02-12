<?php
namespace app\models;
use PDO;
use PDOException;

class Database {
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            $config = include __DIR__ . '/../config/config.php';
            $db = $config['database'];

            $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8mb4";

            try {
                self::$pdo = new PDO(
                    $dsn,
                    $db['user'],
                    $db['password'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                die('Database connection error');
            }
        }

        return self::$pdo;
    }
}

?>