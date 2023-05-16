<?php

namespace app\CRUD;

use app\db\Database;

trait Delete
{
    public static function delete(int $id) {

        // extraction du nom de la class
        $className = strtolower(self::class);
        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 
        
        // definition de la requête sql dynamiquement
        $sql = "DELETE FROM $className WHERE id = $id";

        $connex = Database::connect();
        $result = $connex->query($sql);
        $result->execute();

        Database::disconnect();
    }

}