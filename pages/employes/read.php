<?php

use app\Security;
use controllers\EmployeController;

$title = "Employes | read";
require_once '../layout/header.php';

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = EmployeController::read($id);
$employe = $resultat['data'];

?>


<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger border-0 border-start border-5 border-danger">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="bg-white mt-4 p-4 rounded row border-0 border-start border-5 border-primary">
        <h2 class="text-primary"><?= $employe->prenom . ' ' . $employe->nom ?></h2>
        <p class="text-secondary h6">Arrivé le <?= $employe->date_arrivee ?></p>
        <p class="lead">
            <a href="../affectations/read.php?id=<?= $employe->id ?>">Voir les metiers affectiés à cet employe</a>
        </p>
    </div>

<?php endif ?>
<div class="my-4">
    <a href="/" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retourner à l'acceuil</a>
</div>




<?php require_once '../layout/footer.php' ?>