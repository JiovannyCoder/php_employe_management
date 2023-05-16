<?php

namespace app\CRUD;

use app\db\Database;

trait Create
{
    public function create() {
        // extraction du nom de la class
        $className = strtolower(self::class);
        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 
        
        // extraction des noms des propriétés de la classe donné
        $nomVars = self::get('requiredFields');

        // extraction de la chaine des caratère pour les colonnes dans la requete sql
        $nomColonnes = '';
        foreach($nomVars as $var) {
            $nomColonnes = $nomColonnes . $var . ',';
        }
        $nomColonnes = substr($nomColonnes, 0, -1);

        // extraction de la chaine des caratère pour les parametre dans la requete sql
        $nomParametres = ''; 
        foreach($nomVars as $var) {
            $nomParametres =  $nomParametres . ':'. $var . ',';
        }
        $nomParametres = substr($nomParametres, 0, -1);

        // definition de la requête sql dynamiquement
        $sql = "INSERT INTO $className($nomColonnes) VALUES($nomParametres)";

        //definition des variables et les attributers au getters
        foreach($nomVars as $var) {
            $nomGetter = 'get'. ucfirst($var);
            ${$var} = self::$nomGetter();
        }

        $connex = Database::connect();
        $result = $connex->prepare($sql);

        foreach($nomVars as $var) {
            $result->bindParam(':'. $var, ${$var});
        }

        $result->execute();

        // renvoyer le dernier id si le model a un id
        $lastid = true;

        if(property_exists(self::class, 'id')) {
            $sql = "SELECT MAX(id) as id FROM $className";
            $lastid = $connex->query($sql)->fetch()->id;
    
            $this->id = $lastid;
        }
        
        Database::disconnect();

        return $lastid;
    }
}