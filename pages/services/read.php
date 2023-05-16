<?php

use app\Security;
use controllers\ServiceController;

$title = "Employes | read";
require_once '../layout/header.php';

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = ServiceController::read($id);
$service = $resultat['data'];
$employesDuService = $resultat['employesDuService']['data'];

?>

<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger border-0 border-start border-5 border-danger">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="bg-white mt-4 p-4 rounded row ">
        <h2 class="text-primary">Service <?= $service->nom ?></h2>
        <p class="text-secondary">Liste des employes du service</p>
        <p>
        <a href="./etat.php?id=<?= Security::secure($id) ?>" class="btn btn-outline-danger rounded-pill"><i class="bi bi-file-pdf me-1"></i> Imprimer</a>
        </p>
        <div class="mt-4">
            <?php foreach ($employesDuService as $employe) : ?>
                <div class="mx-1 row bg-light rounded border-start shadow-sm border-5 p-2 my-2">
                    <div class="col-md-3">
                        <div class="h6 text-secondary my-2">Nom et prenom</div>
                        <p><?= $employe->prenom ?> <?= $employe->nom ?> </p>
                    </div>
                    <div class="col-md-3">
                        <div class="h6 text-primary my-2">Metier</div>
                        <p><?= $employe->metier ?></p>
                    </div>
                    <div class="col-md-3">
                        <div class="h6 text-secondary my-2">Temps</div>
                        <p class="fw-bold <?= ($employe->temps == 'plein') ? 'text-plein' : 'text-mi-temps' ?>"><?= $employe->temps ?></p>
                    </div>
                </div>
            <?php endforeach ?>


        </div>
    </div>

<?php endif ?>
<div class="my-4">
    <a href="../services/index.php" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retour</a>
</div>




<?php require_once '../layout/footer.php' ?>