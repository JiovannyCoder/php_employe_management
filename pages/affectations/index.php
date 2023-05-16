<?php

use app\Security;
use app\db\Pagination;
use controllers\EmployeController;

$title = "Affectation";
require_once '../layout/header.php';

// initialiser la page : recupérer les employes
$resultat = EmployeController::affectationIndex();
$employes = $resultat['data'];

$k = -1;
$post_data = [];

if ($_POST && isset($_POST['k']) && $_POST['k']) {
    $k = Security::secure($_POST['k']);
    $post_data['k'] = $k;
    $resultat = EmployeController::affectationIndex($k);
    $employes = $resultat['data'];
}

//pagination
$elements_par_page = $resultat['elements_par_page'];
$page_courante = $resultat['page_courante'];
$nombre_pages = $resultat['nombre_pages'];

$pagination = new Pagination($elements_par_page, $page_courante, $nombre_pages);


?>
<div class="mt-4">
    <div class="row">
        <div class="col-md-6 d-flex align-items-center">
            <h4 class="text-secondary my-4">Métiers et services d'affectation</h4>
        </div>
        <div class="col-md-6 justify-content-md-end d-flex align-items-center">
            <!-- <a class="btn btn-sm btn-primary rounded-pill px-4 my-2" href="../../pages/employes/create.php"><i class="bi-person-plus-fill me-1"></i> Ajouter un nouveau employé</a> -->
            <form class="d-flex" action="<?= Security::secure($_SERVER['PHP_SELF']) ?> " method="POST">
                <div class="input-group">
                    <input type="search" class="form-control rounded-pill mx-2" name="k" value="<?= isset($post_data['k']) ? $post_data['k'] : '' ?>" placeholder="Rechercher un employé">
                    <button class="btn btn-primary  rounded-pill" type="submit"><i class="bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <?php if ($resultat['error']) : ?>
        <div class="alert alert-warning border-0 border-start border-5 py-4 border-warning">
            <?= $resultat['error'] ?>
        </div>
    <?php else : ?>
        <?php foreach ($employes as $employe) : ?>
            <div class="mx-1 row bg-white p-2 rounded border-start my-2 border-5 border-info">
                <div class="col-md-3">
                    <div class="h6 text-secondary my-2">Nom et prenom</div>
                    <p><?= $employe->prenom ?> <?= $employe->nom ?> </p>
                </div>
                <div class="col-md-3">
                    <div class="h6 text-success my-2">Metier</div>
                    <p><?= $employe->metier ?></p>
                </div>
                <div class="col-md-2">
                    <div class="h6 text-primary my-2">Service</div>
                    <p><?= $employe->service ?></p>
                </div>
                <div class="col-md-2">
                    <div class="h6 text-secondary my-2">Temps</div>
                    <p class="fw-bold <?= ($employe->temps == 'plein') ? 'text-plein' : 'text-mi-temps' ?>"><?= $employe->temps ?></p>
                </div>
                <div class="col-md-2">
                    <div class="h6 text-secondary my-2">Action</div>
                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Affecter l'employe" class="btn btn-outline-primary btn-sm rounded-pill" href="../affectations/read.php?id=<?= $employe->id ?>"><i class="bi bi-pencil"></i></a>
                </div>
            </div>
        <?php endforeach ?>
        <div class="mt-4">
            <?php $pagination->afficherPagination() ?>
        </div>

    <?php endif ?>
</div>


<?php require_once '../layout/footer.php' ?>