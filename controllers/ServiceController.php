<?php
namespace controllers;

use app\db\Query;
use app\Validator;
use app\models\Service;

abstract class ServiceController
{
    public static function index(string $filtre = 'age') {

        $query = new Query("SELECT * FROM service");

        $result = $query->paginate(5);
        if(!$result['error'] && !$result['data']) {
            $result['error'] = 'Pas encore de services disponibles pour le moment';
        }

        return $result;
    }

    public static function read(int $id) {
        $data = Service::read($id);
        $query = new Query("SELECT
                                employe.nom,
                                employe.prenom,
                                metier.nom AS metier,
                                exerce.temps
                            FROM
                                employe
                            INNER JOIN exerce ON employe.id = exerce.id_employe
                            INNER JOIN metier ON metier.id = exerce.id_metier
                            WHERE
                                exerce.id_service = $id ");
        $employesDuService = $query->getResult();

        $error = '';

        if(!$employesDuService['error'] && !$employesDuService['data']) {
            $error = 'Pas encore d\'employés affectés à ce service pour le moment';
        }
        if(!$data) {
            $error = 'Service non trouvé pour le moment';
        }

        return [
            'data' => $data,
            'employesDuService' => $employesDuService,
            'error' => $error
        ];
    }

    public static function create(array $post_data) {
        $Service = new Service($post_data);

        $validation = new Validator($Service);
        $message = '';

        $validation->validate();

        if($validation->isValide()) {
            $Service->create();
            $message = "Service créé avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }

    public static function update(int $id, array $post_data) {
        $Service = new Service($post_data);

        $validation = new Validator($Service);
        $message = '';
        
        $validation->validate();

        if($validation->isValide()) {
            $Service->update($id);
            $message = "Service modifié avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }


    public static function delete(int $id) {
        $data = Service::read($id);
        $error = '';

        if(!$data) {
            $error = 'Le Service n\'existe pas et ne peut être supprimé !';
        }else {
            Service::delete($id);
        }
        
        return [
            'data' => $data,
            'error' => $error
        ];
    }
}