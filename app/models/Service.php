<?php
namespace app\models;

use app\db\Query;
use app\CRUD\Read;
use app\CRUD\Index;
use app\CRUD\Create;
use app\CRUD\Delete;
use app\CRUD\Update;
use app\interfaces\Model;

class Service implements Model
{
    private int $id;
    private string $nom;

    private array $data = [];
    private array $requiredFields = ['nom'];

    use Index, Create, Read, Update, Delete;

    public function __construct(array $post_data)
    {
        $this->data = $post_data;
        
        if(array_key_exists('id', $post_data)) {
            $this->id = $post_data['id'];
        }
        if(array_key_exists('nom', $post_data)) {
            $this->nom = $post_data['nom'];
        }
    }

    // getter universel
    public function get(string $name) {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }


    public function getId(): int {
        return $this->id;
    }
    
    public function getNom(): string {
        return $this->nom;
    }

    public function setNom(string $nom): void {
        $this->nom = $nom;
    }

        // relation metier
        public static function getMetiers(int $id) {
            $query = new Query("SELECT DISTINCT
                                    metier.id AS id,  
                                    metier.Nom AS metier  
                                FROM   
                                    exerce
                                INNER JOIN metier ON exerce.id_metier = metier.id
                                INNER JOIN service ON exerce.id_service = service.id
                                
                                WHERE service.id = $id
                                ");
            return $query->getResult()['data'];
        }
}