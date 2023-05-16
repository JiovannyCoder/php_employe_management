<?php

namespace app\db;

use app\Security;
use PDOException;

class Query 
{
    private string $sql;
    private string $error = '';
    private array $data = [];

    // poour la pagination
    private $elements_par_page;
    private $page_courante;
    private $offset;
    private $total_elements;
    private $nombre_pages;

    public function __construct(string $SQL) 
    {
        $this->sql = $SQL;
    }

    public function getResult(): array {
        $connex = Database::connect();

        try {
            $result = $connex->query($this->sql);
            $this->data = $result->fetchAll();
            Database::disconnect();

        } catch(PDOException $e) {

            $this->error = 'Erreur : sql invalide !';
            Database::disconnect();
        }

        return [
            'data' => $this->data,
            'error' => $this->error
        ];
    }

    public function paginate(int $elements_par_page = 10) {
        $connex = Database::connect();

        $this->elements_par_page = $elements_par_page;
        $this->total_elements = count($this->getResult()['data']);
        $this->nombre_pages = ceil($this->total_elements / $this->elements_par_page);
        
        // le page courante doit comprise entre 0 et le nombre de page sinon on renvoit toujours la page 1
        $this->page_courante = (isset($_GET['page']) && (int)Security::secure($_GET['page']) > 0 && (int)Security::secure($_GET['page']) <= $this->nombre_pages) ? (int)Security::secure($_GET['page']) : 1;
        $this->offset = ($this->page_courante - 1) * $this->elements_par_page;
        

        // modifier la requête et ajouter un limiteur
        $this->sql = $this->sql . " LIMIT $this->offset, $this->elements_par_page";
        try {
            $result = $connex->query($this->sql);
            $this->data = $result->fetchAll();
            Database::disconnect();

        } catch(PDOException $e) {
            $this->error = 'Erreur : sql invalide !';
            Database::disconnect();
        }

        return [
            'data' => $this->data,
            'elements_par_page' => $this->elements_par_page,
            'nombre_pages' => $this->nombre_pages,
            'page_courante' => $this->page_courante,
            'error' => $this->error
        ];
    }

    public function getError() {
        return $this->error;
    }
}