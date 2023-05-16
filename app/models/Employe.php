<?php

namespace app\models;

use app\CRUD\Read;
use app\CRUD\Index;
use app\CRUD\Create;
use app\CRUD\Delete;
use app\CRUD\Update;
use app\db\Query;
use app\interfaces\Model;

class Employe implements Model
{
    private int $id;
    private string $nom;
    private string $prenom;
    private $date_naissance;
    private $date_arrivee;

    private array $metiers = [];

    private array $data = [];
    private array $requiredFields = ['nom', 'prenom', 'date_naissance', 'date_arrivee'];

    use Index, Create, Read, Update, Delete;

    public function __construct(array $post_data)
    {
        $this->data = $post_data;

        if (array_key_exists('id', $post_data)) {
            $this->id = $post_data['id'];
        }
        if (array_key_exists('nom', $post_data)) {
            $this->nom = $post_data['nom'];
        }
        if (array_key_exists('prenom', $post_data)) {
            $this->prenom = $post_data['prenom'];
        }
        if (array_key_exists('date_naissance', $post_data)) {
            $this->date_naissance = $post_data['date_naissance'];
        }
        if (array_key_exists('date_arrivee', $post_data)) {
            $this->date_arrivee = $post_data['date_arrivee'];
        }
    }
    // getter universel
    public function get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }
    // getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getDate_naissance(): string
    {
        return $this->date_naissance;
    }
    public function getDate_arrivee(): string
    {
        return $this->date_arrivee;
    }

    //setters
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setDate_naissance(string $date_naissance): void
    {
        $this->date_naissance = $date_naissance;
    }
    public function setDate_arrivee(string $date_arrivee): void
    {
        $this->date_arrivee = $date_arrivee;
    }

    //relation metiers de l'employe
    public static function getMetiers(int $id)
    {
        $query = new Query("SELECT DISTINCT
                                metier.id AS id_metier,  
                                metier.nom AS nom_metier,
                                
                                service.id AS id_service,
                                service.nom AS nom_service,
                                exerce.temps AS temps
                            FROM   
                                exerce
                                
                            INNER JOIN metier ON exerce.id_metier = metier.id
                            INNER JOIN service ON exerce.id_service = service.id
                            
                            WHERE exerce.id_employe = $id
                            ");
        return $query->getResult()['data'];
    }
    //tous les metiers
    public static function getMetiersEtServices()
    {
        $query = new Query("SELECT DISTINCT
                                metier.id AS id_metier,  
                                metier.nom AS nom_metier,
                                
                                service.id AS id_service,
                                service.nom AS nom_service
                            FROM   
                                exerce
                                
                            INNER JOIN metier ON exerce.id_metier = metier.id
                            INNER JOIN service ON exerce.id_service = service.id
                            
                            ORDER BY metier.id
                            ");
        return $query->getResult()['data'];
    }

    public function addMetier(array $metier)
    {
        $post_data = [
            'id_employe' => $metier['id_employe'],
            'id_metier' => $metier['id_metier'],
            'id_service' => $metier['id_service'],
            'temps' => $metier['temps']
        ];

        $exerce = new Exerce($post_data);
        $exerce->create();
    }


}
