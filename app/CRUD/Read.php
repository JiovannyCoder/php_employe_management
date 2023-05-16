<?php

namespace app\CRUD;

use app\db\Database;

trait Read
{
    public static function read(int $id) {
        
        $className = strtolower(self::class);
        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 

        $connex = Database::connect();
        $result = $connex->query("SELECT * FROM $className WHERE id = $id");

        $data = $result->fetch();

        Database::disconnect();
        return $data;
    }
}