<?php

use app\Security;
use app\db\Pagination;
use controllers\EmployeController;

$title = "Employes";
require_once '../layout/header.php';

// initialiser la page : recupérer les employes
$resultat = EmployeController::index();
$employes = $resultat['data'];
$nombre_employes = count(EmployeController::index('age', false)['data']);

//pagination
$elements_par_page = $resultat['elements_par_page'];
$page_courante = $resultat['page_courante'];
$nombre_pages = $resultat['nombre_pages'];

$pagination = new Pagination($elements_par_page, $page_courante, $nombre_pages);

?>
<div class="mt-4">
    <h4 class="text-secondary mt-4">Informations des <span class="fs-bold text-success"><?= $nombre_employes ?> employés</span></h4>
    <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-sm btn-outline-danger rounded-pill px-4 my-2" href="./etat.php"><i class="bi bi-file-pdf me-1"></i> Imprimer</a>
        <a class="btn btn-sm btn-primary rounded-pill px-4 my-2" href="../../pages/employes/create.php"><i class="bi-person-plus-fill me-1"></i> Ajouter un nouveau employé</a>
    </div>
    <!-- <h2 class="text-secondary my-4">Liste des employés</h2> -->
    <?php foreach ($employes as $employe) : ?>
        <div class="mx-1 row bg-white p-2 rounded border-start my-2 border-5 border-info">
            <div class="col-lg-2 col-md-4 col-sm-8 col-12">
                <div class="h6 text-secondary my-2">Nom et prenom</div>
                <p><?= $employe->prenom ?> <?= $employe->nom ?> </p>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-6">
                <div class="h6 text-secondary my-2">Age</div>
                <p><?= $employe->age ?> ans</p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-8 col-6">
                <div class="h6 text-secondary my-2">Ancienneté</div>
                <?php if($employe->anciennete <= 0) : ?>
                    <p> < 1 an </p>
                <?php elseif($employe->anciennete <= 1 ) : ?>
                    <p><?= $employe->anciennete ?> an </p>
                <?php else : ?>
                    <p><?= $employe->anciennete ?> ans </p>
                <?php endif ?>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-2 col-6">
                <div class="h6 text-secondary my-2">Arrivée</div>
                <p><?= $employe->arrivee ?></p>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6 col-6">
                <div class="h6 text-secondary my-2">Age à l'arrivée</div>
                <p><?= $employe->age_arrivee ?> ans</p>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-12 col- text-center">
                <div class="h6 text-secondary my-2">Actions</div>
                <div>
                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Voir" class="btn btn-outline-info btn-sm rounded-pill my-1" href="../employes/read.php?id=<?= $employe->id ?>"><i class="bi-eye-fill"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modifier" class="btn btn-outline-primary btn-sm rounded-pill my-1" href="../employes/update.php?id=<?= $employe->id ?>"><i class="bi-pencil-fill"></i></a>
                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer" class="btn btn-outline-danger btn-sm rounded-pill my-1" href="../employes/delete.php?id=<?= $employe->id ?>"><i class="bi-trash-fill"></i></a>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <div class="mt-4">
        <?php $pagination->afficherPagination() ?>
    </div>

</div>





<?php require_once '../layout/footer.php' ?>