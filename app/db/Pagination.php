<?php

namespace app\db;

use PDOException;

class Pagination 
{
    // pour la pagination
    private $elements_par_page;
    private $page_courante;
    private $nombre_pages;

    public function __construct(int $elements_par_page, int $page_courante, int $nombre_pages) 
    {
        $this->elements_par_page = $elements_par_page;
        $this->page_courante = $page_courante;
        $this->nombre_pages = $nombre_pages;
    }

    public function afficherPagination() {
        $html = '<nav aria-label="...">
                    <ul class="pagination">';
        $disablePrecedent = ($this->page_courante == 1) ? ' disabled ' : '';
        $precedant = ($this->page_courante == 1) ? $this->nombre_pages : $this->page_courante - 1;
        $html .= '<li class="page-item me-1 ' . $disablePrecedent .'">';
        $html .= '<a class="page-link" href="?page='. $precedant.'"> <i class="bi-chevron-compact-left"></i></a>';
        $html .= '</li>';

        for($page = 1; $page <= $this->nombre_pages; $page++) {
            $active = ($this->page_courante === $page) ? ' active ' : '';

            $html .= '<li class="page-item me-1' . $active . '">';
            $html .= '<a class="page-link" href="?page='. $page .'">'. $page .'</a>';
            $html .= '</li>';
        }

        $disableSuivant = ($this->page_courante == $this->nombre_pages) ? ' disabled ' : '';
        $suivant = ($this->page_courante == $this->nombre_pages) ? 1 : $this->page_courante + 1;
        $html .= '<li class="page-item '. $disableSuivant .' ">';
        $html .= '<a class="page-link" href="?page='. $suivant.'"> <i class="bi-chevron-compact-right"></i></a>';
        $html .= '</li>';            


        $html .=         '</ul>';
        $html .=     '</nav>';

        echo $html;
    }

    
}