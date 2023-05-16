<?php 
namespace app;

use app\db\Query;
use app\interfaces\Model;
use DateTime;

class Validator
{
    private array $errors = [];
    private Model $model;
    private array $data = [];
    private array $fields = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->fields = $this->model->get('requiredFields');
        $this->data = $this->model->get('data');
    }

    // validation du formulaire des champs requises
    public function validateForm() {
        foreach($this->fields as $field) {
            if(!array_key_exists($field, $this->data) || !$this->data[$field]) {
                $this->addError($field, "Veuillez remplir ce champ");
                // $this->addError($field, "Le champ $field est requis !");
            }
        }
        // arreter les autres si besoin
        if($this->errors) {
            return false;
        }
        return true;
    }

    // list des validations possibles

    // validation des noms
    public function validateNom() {
        if(!is_string($this->model->get('nom'))) {
            $this->addError('nom', 'Le nom doit etre une chaine de  caractere');
        } else if(strlen($this->model->get('nom')) < 5) {
            $this->addError('nom', 'Le nom doit avoir 5 caracteres minimum');
        } else if(strlen($this->model->get('nom')) > 100) {
            $this->addError('nom', 'Le nom doit avoir 100 caracteres maximum');
        }
    }

    // validation des prenoms
    public function validatePrenom() {
        if(!is_string($this->model->get('prenom'))) {
            $this->addError('prenom', 'Le prenom doit etre une chaine de  caractere');
        } else if(strlen($this->model->get('prenom')) < 5) {
            $this->addError('prenom', 'Le prenom doit avoir 5 caracteres minimum');
        } else if(strlen($this->model->get('prenom')) > 100) {
            $this->addError('prenom', 'Le prenom doit avoir 100 caracteres maximum');
        }
    }

    // validation des dates

    // validateur par defaut
    public function validateDate(string $date) {
        $regex = '/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
        if(preg_match($regex, $date)){
            return true;
        }
        return false;
    }

    public function compareDate(string $debut, string $fin) {
        $date1 = new DateTime($debut);
        $date2 = new DateTime($fin);

        if($date1 > $date2) {
            return true;
        }
        return false;
    }

    //validation date de naissance
    public function validateDateNaissance() {
        // format de date valide
        if(!$this->validateDate($this->model->get('date_naissance'))){
            $this->addError('date_naissance', 'La date de naissance est invalide');
        } 
        // la date naissance ne peut postérieur à la date d'arrivée
        else if($this->compareDate($this->model->get('date_naissance'), $this->model->get('date_arrivee'))){
            $this->addError('date_naissance', 'La date de naissance ne peut pas être postérieur à la date d\'arrivée ');
        } 
        // la date naissance ne peut égal à la date d'arrivée
        else if($this->model->get('date_naissance') === $this->model->get('date_arrivee')){
            $this->addError('date_naissance', 'La date de naissance ne peut pas être égale à la date d\'arrivée ');
        } 
        // la date naissance ne peut postérieur à la date d'aujoud'hui
        else if($this->compareDate($this->model->get('date_naissance'), date('Y-m-d'))){
            $this->addError('date_naissance', 'La date de naissance ne peut pas être postérieur à aujourd\'hui ! ');
        } 
        // la date naissance ne peut égale à la date d'aujourd'hui
        else if($this->model->get('date_naissance') === date('Y-m-d')){
            $this->addError('date_naissance', 'L\'employe ne peut pas naître aujourd\'hui ! ');
        }
    }

    //validation date de naissance
    public function validateDateArrivee() {
        // format de date valide
        if(!$this->validateDate($this->model->get('date_arrivee'))){
            $this->addError('date_arrivee', 'La date d\'arrivee est invalide');
        } 
        // la date d'arrivee ne peut être antérieur à sa date de naissance
        else if($this->compareDate($this->model->get('date_naissance'), $this->model->get('date_arrivee'))){
            $this->addError('date_arrivee', 'La date d\'arrivee ne peut pas être antérieur à la date de naissance ');
        } 
        // la date d'arrivée ne peut être égale à sa date de naissance
        else if($this->model->get('date_naissance') === $this->model->get('date_arrivee')){
            $this->addError('date_arrivee', 'La date d\'arrivee ne peut pas être égale à la date de naissance ');
        }
        // la date naissance ne peut postérieur à la date d'aujoud'hui
        else if($this->compareDate($this->model->get('date_arrivee'), date('Y-m-d'))){
            $this->addError('date_arrivee', 'La date de naissance ne peut pas être postérieur à aujourd\'hui ! ');
        }
    }

    // validation de temps 
    public function validateTemps(){
        if($this->data['temps'] !== 'plein' && $this->data['temps'] !== 'mi-temps') {
            $this->addError('temps', 'Temps invalide');
        }
    }

    // validation des metiers 
    public function validateMetiers() {
        if(is_null($this->data['metiers'])) {
            $this->addError('metiers', 'Veuillez sélectionner au moins un metier');
        } else if (!is_array($this->data['metiers'])) {
            $this->addError('metiers', 'Metiers invalides');
        }
    }

    public function validateExerce() {
        $id_employe = $this->model->get('id_employe');
        $id_metier = $this->model->get('id_metier');
        $id_service = $this->model->get('id_service');

        $sql = "SELECT * FROM exerce WHERE id_employe = $id_employe AND id_metier = $id_metier AND id_service = $id_service";
        $query = new Query($sql);

        if($query->getResult()['data']) {
            $this->addError('exerce', 'L\'employe a déjà été affecté à ce metier dans ce service !');
        }
    }


    public function validate() : array {
        $this->validateForm();
        // var_dump($this->errors);

        if(array_key_exists('nom', $this->data) && !array_key_exists('nom', $this->errors)) {
            $this->validateNom();
        }
        if(array_key_exists('prenom', $this->data) && !array_key_exists('prenom', $this->errors)) {
            $this->validatePrenom();
        }
        if(array_key_exists('date_naissance', $this->data) && !array_key_exists('date_naissance', $this->errors)) {
            $this->validateDateNaissance();
        }
        if(array_key_exists('date_arrivee', $this->data) && !array_key_exists('date_arrivee', $this->errors)) {
            $this->validateDateArrivee();
        }
        if(array_key_exists('temps', $this->data) && !array_key_exists('temps', $this->errors)) {
            $this->validateTemps();
        }
        if(array_key_exists('metiers', $this->data) && !array_key_exists('metiers', $this->errors)) {
            $this->validateMetiers();
        }
        if((array_key_exists('id_employe', $this->data) && !array_key_exists('id_employe', $this->errors)) || (array_key_exists('id_metier', $this->data) && !array_key_exists('id_metier', $this->errors)) || (array_key_exists('id_service', $this->data) && !array_key_exists('id_service', $this->errors))) {
            $this->validateExerce();
        }
        

        return $this->errors;
    }

    private function addError(string $key, string $message) {
        $this->errors[$key] = $message;
    }

    public function isValide(): bool {
        if(!$this->errors) {
            return true;
        }
        return false;
    }
}