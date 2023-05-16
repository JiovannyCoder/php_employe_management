<?php
namespace app\models;

use app\CRUD\Read;
use app\CRUD\Index;
use app\CRUD\Create;
use app\CRUD\Delete;
use app\CRUD\Update;
use app\db\Database;
use app\interfaces\Model;

class Exerce implements Model
{
    private int $id_employe;
    private string $id_metier;
    private string $id_service;
    private $temps;

    private array $data = [];
    private array $requiredFields = ['id_employe', 'id_metier', 'id_service', 'temps'];

    use Create, Read, Update;

    public function __construct(array $post_data)
    {
        $this->data = $post_data;

        if(array_key_exists('id_employe', $post_data)) {
            $this->id_employe = $post_data['id_employe'];
        }
        if(array_key_exists('id_metier', $post_data)) {
            $this->id_metier = $post_data['id_metier'];
        }
        if(array_key_exists('id_service', $post_data)) {
            $this->id_service = $post_data['id_service'];
        }
        if(array_key_exists('temps', $post_data)) {
            $this->temps = $post_data['temps'];
        }
    }

        // getters
        public function getId_employe(): string {
            return $this->id_employe;
        }
    
        public function getId_metier(): string {
            return $this->id_metier;
        }
    
        public function getId_service(): string {
            return $this->id_service;
        }
        public function getTemps(): string {
            return $this->temps;
        }
    
        //setters
        public function setId_employe(string $id_employe): void {
            $this->id_employe = $id_employe;
        }
    
        public function setId_metier(string $id_metier): void {
            $this->id_metier = $id_metier;
        }
    
        public function setId_service(string $id_service): void {
            $this->id_service = $id_service;
        }
        public function setTemps(string $temps): void {
            $this->temps = $temps;
        }

    // getter universel
    public function get(string $name) {
        if(property_exists($this, $name)) {
            return $this->$name;
        }
        return null;
    }

    public function deleteExerce() {

        if(!$this->id_employe || !$this->id_metier || !$this->id_service) {
            return [
                'error' => 'Erreur '
            ];
        }

        // extraction du nom de la class
        $className = strtolower(self::class);
        // renvoier le nom de la class à la fin du namepase
        $className = substr($className, strrpos($className, '\\') + 1); 
        
        if($className !== 'exerce') {
            return;
        }
        // definition de la requête sql dynamiquement
        $sql = "DELETE FROM $className WHERE id_employe = $this->id_employe AND id_metier = $this->id_metier AND id_service = $this->id_service";

        $connex = Database::connect();
        $result = $connex->query($sql);
        $result->execute();

        Database::disconnect();
    }
}