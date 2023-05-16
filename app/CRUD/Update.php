<?php

namespace app\CRUD;

use app\db\Database;

trait Update
{
    public function update(int $id) {

        // extraction du nom de la class (le namespace)
        $className = strtolower(self::class);

        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 

        // extraction des noms des champ requis de la classe donné
        $nomVars = self::get('requiredFields');

        // extraction de la chaine des caratère pour les colonnes dans la requete sql
        $colonneParametre= '';
        foreach($nomVars as $var) {
            // colonne = :parametre
            $colonneParametre = $colonneParametre . $var . '=' . ':'. $var. ',';

            //definition des variables et les attributers au getters
            $nomGetter = 'get'. ucfirst($var); // getNom
            ${$var} = self::$nomGetter();
        }
        $colonneParametre = substr($colonneParametre, 0, -1);

        // definition de la requête sql dynamiquement
        $sql = "UPDATE $className SET $colonneParametre WHERE id = $id";

        $connex = Database::connect();
        $result = $connex->prepare($sql);

        foreach($nomVars as $var) {
            $result->bindParam(':'. $var, ${$var});
        }
        
        $result->execute();

        return $nomVars;
    }
}