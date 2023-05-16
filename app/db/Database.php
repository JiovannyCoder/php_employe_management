<?php
namespace app\db;

use config\Config;

class Database
{
    private static $conn = null;

    public static function connect() {
        try {
            self::$conn = new \PDO("mysql:host=".Config::SERVER_HOST.";dbname=".Config::DB_NAME, Config::DB_USER, Config::DB_PASSWORD,
            [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
            ]
        );

            return self::$conn;

        } catch(\PDOException $e) {
            header("location: ../../pages/errors/501.php");
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function disconnect() {
        self::$conn = null;
    }

}
