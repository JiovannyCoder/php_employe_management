<?php

namespace controllers;

use app\db\Query;
use app\Validator;
use app\models\Employe;
use app\models\Exerce;

abstract class EmployeController
{
    public static function index(string $filtre = 'age', bool $paginate = true)
    {
        $query = new Query("SELECT
                                id,
                                nom,
                                prenom,
                                (YEAR(CURDATE()) - YEAR(date_naissance)) - (RIGHT(CURDATE(),5) < RIGHT(date_naissance,5)) AS age,
                                (YEAR(CURDATE()) - YEAR(date_arrivee)) - (RIGHT(CURDATE(),5) < RIGHT(date_arrivee,5)) AS anciennete,
                                YEAR(date_arrivee) AS arrivee,
                                (YEAR(date_arrivee) - YEAR(date_naissance)) - (RIGHT(date_arrivee,5) < RIGHT(date_naissance,5)) AS age_arrivee
                            FROM
                                employe
                            ORDER BY
                                $filtre ASC
                            ");
        if($paginate) {
            $result = $query->paginate(5);
        } else {
            $result = $query->getResult();
        }

        if (!$result['error'] && !$result['data']) {
            $result['error'] = 'Pas encore de Employe disponible pour le moment';
        }

        return $result;
    }

    public static function affectationIndex(string $k = '')
    {
        $sql = "SELECT
            employe.id as id,
            employe.nom,
            employe.prenom,
            metier.nom AS metier,
            service.nom AS service,
            exerce.temps
            FROM (
            employe  
            INNER JOIN exerce ON employe.id = exerce.id_employe
            INNER JOIN metier ON metier.id = exerce.id_metier
            INNER JOIN service ON service.id = exerce.id_service
            ) ";
        if($k) {
            $sql .= "WHERE (employe.nom LIKE '%$k%' OR employe.prenom LIKE '%$k%')";
        }

        $query = new Query($sql);
        $result = $query->paginate(5);

        
        if (!$result['error'] && !$result['data'] && !$k) {
            $result['error'] = 'Pas encore de Employe disponible pour le moment';
        }
        if ((!$result['error'] && !$result['data']) && $k) {
            $result['error'] = "Aucun résultats trouvé pour la recherche '$k'";
        }

        $result['nombre_employes'] = count($query->getResult());

        return $result;
    }

    public static function read(int $id)
    {
        $data = Employe::read($id);
        $error = '';

        if (!$data) {
            $error = 'Employe non trouvé pour le moment';
        }

        return [
            'data' => $data,
            'error' => $error
        ];
    }

    public static function create(array $post_data)
    {
        $Employe = new Employe($post_data);

        $validation = new Validator($Employe);
        $message = '';

        $validation->validate();

        if ($validation->isValide()) {
            $Employe->create();

            if(array_key_exists('metiers', $post_data) && array_key_exists('temps', $post_data)) {
                $metier = [
                    'id_employe' => $Employe->getId(),
                    'id_metier' => $post_data['metiers'][0],
                    'id_service' => $post_data['metiers'][1],
                    'temps' => $post_data['temps']
                ];

                $Employe->addMetier($metier);
            }

            $message = "Nouveau employé ajouté avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }

    public static function update(int $id, array $post_data)
    {
        $Employe = new Employe($post_data);

        $validation = new Validator($Employe);
        $message = '';

        $validation->validate();

        if ($validation->isValide()) {
            $Employe->update($id);
            $message = "Employe modifié avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }


    public static function delete(int $id)
    {
        $data = Employe::read($id);
        $error = '';

        if (!$data) {
            $error = 'Le Employe n\'existe pas et ne peut être supprimé !';
        } else {
            Employe::delete($id);
        }

        return [
            'data' => $data,
            'error' => $error
        ];
    }

    public static function addMetier(array $post_data) {

        $exerce = new Exerce($post_data);
        $message = '';

        $validation = new Validator($exerce);

        $errors = $validation->validate();

        if($validation->isValide()) {
            $exerce->create();
            $message = "Metier et service affectée à l'employe avec success !";
        }

        return [
            'message' => $message,
            'errors' => $errors,
            'data' => $post_data
        ];
    }

    public static function deleteMetier(array $metier) {
        $exerce = new Exerce($metier);
        $exerce->deleteExerce();
    }
}
