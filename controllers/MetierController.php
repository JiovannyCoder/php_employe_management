<?php
namespace controllers;

use app\db\Query;
use app\Validator;
use app\models\Metier;

abstract class MetierController
{
    public static function index(string $filtre = '') {

        $query = new Query("SELECT * FROM metier");

        $result = $query->paginate(5);
        if(!$result['error'] && !$result['data']) {
            $result['error'] = 'Pas encore de metiers disponibles pour le moment';
        }

        return $result;
    }

    public static function read(int $id) {
        $data = Metier::read($id);
        $error = '';

        if(!$data) {
            $error = 'Metier non trouvé pour le moment';
        }

        return [
            'data' => $data,
            'error' => $error
        ];
    }

    public static function create(array $post_data) {
        $metier = new Metier($post_data);

        $validation = new Validator($metier);
        $message = '';

        $validation->validate();

        if($validation->isValide()) {
            $metier->create();
            $message = "Metier créé avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }

    public static function update(int $id, array $post_data) {
        $metier = new Metier($post_data);

        $validation = new Validator($metier);
        $message = '';
        
        $validation->validate();

        if($validation->isValide()) {
            $metier->update($id);
            $message = "Metier modifié avec success !";
        }

        return [
            'message' => $message,
            'errors' => $validation->validate(),
            'data' => $post_data
        ];
    }


    public static function delete(int $id) {
        $data = Metier::read($id);
        $error = '';

        if(!$data) {
            $error = 'Le metier n\'existe pas et ne peut être supprimé !';
        }else {
            Metier::delete($id);
        }
        
        return [
            'data' => $data,
            'error' => $error
        ];
    }
}