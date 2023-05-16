<?php

namespace app\CRUD;

use app\db\Database;

trait Index
{
    public static function index(): array {
        $className = strtolower(self::class);
        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 

        $connex = Database::connect();
        $result = $connex->query("SELECT * FROM $className");

        $data = $result->fetchAll();
        Database::disconnect();
        
        return $data;
    }

}