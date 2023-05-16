<?php

use app\Security;
use controllers\metierController;

$title = "metiers | update";
require_once '../layout/header.php';

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = MetierController::read($id);
$metier = $resultat['data'];

$errors = [];
$message = '';

if($_POST && Security::isVerified(['update', 'nom'], Security::POST_TYPE)) {
    $post_data = [
        'nom' => Security::secure($_POST['nom'])
    ];

    $update = MetierController::update( Security::secure($_GET['id']), $post_data);
    $errors = $update['errors'];
    $message = $update['message'];
}

?>


<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger border-0 border-start border-5 border-danger mx-auto" style="max-width:600px">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="bg-white mt-4 p-4 border-0 border-top border-5 border-success rounded mx-auto" style="max-width:600px">
        <h2 class="text-success my-4">Modification du metier</h2>
        <form action="<?= Security::secure($_SERVER['PHP_SELF']) . '?id='. $id ?> " class="form" method="POST">
            <div class="form-group mb-3">
                <input type="text" name="nom" value="<?= isset($post_data['nom']) ? $post_data['nom'] : Security::secure($metier->nom) ?>" id="nom" class="form-control" placeholder="Votre nom">
                <?php if(isset($errors['nom'])) : ?>
                    <p class="text-danger"><?= $errors['nom'] ?></p>
                <?php endif ?>
            </div>
            <div class="form-group mb-3">
                <button type="submit" name="update" value="update" class="btn w-100 btn-success rounded-pill"><i class="bi-folder-plus me-1"></i> Modifier</button>
            </div>
            <?php if($message) : ?>
                <div class="alert alert-success border-0 border-5 border-start my-2 border-success">
                    <?= $message ?>
                </div>
            <?php endif ?>
        </form>       
    </div> 

<?php endif ?>
<div class="my-4 mx-auto" style="max-width:600px">
    <a href="../metiers/index.php" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i>  Retour</a>
</div>



<?php require_once '../layout/footer.php' ?>