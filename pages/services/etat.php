<?php

use app\pdf\PDF;
use app\Security;
use controllers\ServiceController;

require_once('../../vendor/autoload.php');

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = ServiceController::read($id);
$service = $resultat['data'];
$employesDuService = $resultat['employesDuService']['data'];

if($resultat['error']) {
    echo 'Service non trouvé !';
} else {


    $pdf = new PDF();

    $pdf->AliasNbPages();
    $pdf->AddPage();
    // premiere line
    $pdf->SetFont('Helvetica','B',16);
    $pdf->SetTextColor(13,110,253);
    $pdf->Cell(190,10, utf8_decode('Service ' . $service->nom), 0, 1);

    // 2em ligne
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->SetTextColor(33,37,41);
    $pdf->Cell(190,10, utf8_decode('Liste des employés de ce service '), 0, 1);

    // tableau
    $pdf->Ln(5);
    //entete
    $pdf->SetFont('Helvetica', 'B', 12);
    $pdf->SetTextColor(33,37,41);
    $pdf->SetFillColor(233,236,239);
    $pdf->SetDrawColor(222,226,230);

    $pdf->Cell(71,10,'Nom et prenom ', 1, 0, 'C', true);
    $pdf->Cell(71,10,'Metier', 1, 0, 'C', true);
    $pdf->Cell(48,10,'Temps', 1, 1, 'C', true);

    //corps
    foreach($employesDuService as $employe) {
        $pdf->SetFont('Helvetica', '', 12);
        $pdf->SetTextColor(33,37,41);
        $pdf->Cell(71,10, utf8_decode($employe->nom . '  '. $employe->prenom), 1, 0, 'C');
        $pdf->Cell(71,10,utf8_decode($employe->metier), 1, 0, 'C');
        $pdf->Cell(48,10,utf8_decode($employe->temps), 1, 1, 'C');
    }

    $pdf->Output();

}