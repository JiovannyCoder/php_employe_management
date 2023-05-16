<?php

use app\pdf\PDF;
use controllers\EmployeController;

require_once('../../vendor/autoload.php');

// initialiser la page : recupérer les employes
$resultat = EmployeController::index('anciennete', false);
$employes = $resultat['data'];

if($resultat['error']) {
    echo 'Impossible de générer le pdf !';
} else {
    $pdf = new PDF();

    $pdf->AliasNbPages();
    $pdf->AddPage();
    // premiere line
    $pdf->SetFont('Helvetica','B',16);
    $pdf->SetTextColor(13,110,253);
    $pdf->Cell(190,10, utf8_decode('Gestion du personnel '), 0, 1);

    // 2em ligne
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->SetTextColor(33,37,41);
    $pdf->Cell(190,10, utf8_decode('Informations des employés de l\'entreprise '), 0, 1);

    // tableau
    $pdf->Ln(5);
    //entete
    $pdf->SetFont('Helvetica', 'B', 11);
    $pdf->SetTextColor(33,37,41);
    $pdf->SetFillColor(233,236,239);
    $pdf->SetDrawColor(222,226,230);

    $pdf->Cell(66,10,utf8_decode('Nom et prenom '), 1, 0, 'C', true);
    $pdf->Cell(26,10,utf8_decode('Age'), 1, 0, 'C', true);
    $pdf->Cell(26,10,utf8_decode('Ancienneté'), 1, 0, 'C', true);
    $pdf->Cell(36,10,utf8_decode('Arrivée'), 1, 0, 'C', true);
    $pdf->Cell(36,10,utf8_decode('Age à l\'arrivée'), 1, 1, 'C', true);

    //corps
    foreach($employes as $employe) {
        $pdf->SetFont('Helvetica', '', 11);
        $pdf->SetTextColor(33,37,41);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(66,10,utf8_decode($employe->nom . ' ' . $employe->prenom), 1, 0, 'C', true);
        $pdf->Cell(26,10,utf8_decode($employe->age . ' ans'), 1, 0, 'C', true);

        if($employe->anciennete <= 0) {
            $pdf->Cell(26,10,utf8_decode(' < 1 an'), 1, 0, 'C', true);
        } else if($employe->anciennete <= 1) {
            $pdf->Cell(26,10,utf8_decode($employe->anciennete . ' an'), 1, 0, 'C', true);
        } else {
            $pdf->Cell(26,10,utf8_decode($employe->anciennete . ' ans'), 1, 0, 'C', true);
        }

        $pdf->Cell(36,10,utf8_decode($employe->arrivee), 1, 0, 'C', true);
        $pdf->Cell(36,10,utf8_decode($employe->age_arrivee . ' ans'), 1, 1, 'C', true);
    }

    $pdf->Ln(5);
    $pdf->SetFont('Helvetica', 'B', 11);
    $pdf->SetTextColor(33,37,41);
    $pdf->Cell(190,10, utf8_decode('Il y a en tout ' . count($employes) . ' employés dans l\'entreprise.'), 0, 1);

    $pdf->Output();

}