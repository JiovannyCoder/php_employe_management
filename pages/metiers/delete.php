<?php

use app\Security;
use controllers\MetierController;

$title = "metiers | delete";
require_once '../layout/header.php';

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = MetierController::read($id);
$metier = $resultat['data'];


if($_POST && isset($_POST['delete'])) {
    $response = (bool)Security::secure($_POST['delete']);

    if($response) {
        $delete = MetierController::delete(Security::secure($_GET['id']));
        $errors = $delete['error'];
        header('location: /pages/metiers/index.php');
    } else {
        header('location: /pages/metiers/index.php');
    }
}


?>


<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger border-0 border-start border-5 border-danger">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="mx-1 alert alert-danger border-0 border-start border-5 border-danger mt-4 p-4 rounded row">
        <div class="col-md-8">
            <p class="text-danger">Voulez-vous vraiment supprimer definitivement ce metier ?</p>
            <h4 class="text-secondary"><?= $metier->nom ?></h4>
          
        </div>
        <div class="col-md-4 d-flex align-items-center justify-content-end">
            <form action="<?= Security::secure($_SERVER['PHP_SELF']) . '?id='. $id ?>" class="form" method="POST">
                <div class="action-group">
                    <button type="submit" name="delete" value="1" class="m-1 btn btn-danger btn-sm rounded-pill">Confirmer</button>
                    <button type="submit" name="delete" value="0" class="m-1 btn btn-primary btn-sm rounded-pill">Annuler</button>
                </div>
            </form>
        </div>
    </div>

<?php endif ?>
<div class="my-4">
    <a href="../metiers/index.php" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retour</a>
</div>


<?php require_once '../layout/footer.php' ?>