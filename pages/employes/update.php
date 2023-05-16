<?php

use app\Security;
use controllers\EmployeController;

$title = "Employes | update";
require_once '../layout/header.php';

$id = -1;

if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
}

$resultat = EmployeController::read($id);
$employe = $resultat['data'];

$errors = [];
$message = '';

if($_POST && Security::isVerified(['update', 'nom', 'date_naissance', 'date_arrivee'], Security::POST_TYPE)) {
    $post_data = [
        'nom' => Security::secure($_POST['nom']),
        'prenom' => Security::secure($_POST['prenom']),
        'date_naissance' => Security::secure($_POST['date_naissance']),
        'date_arrivee' => Security::secure($_POST['date_arrivee'])
    ];

    $update = EmployeController::update( Security::secure($_GET['id']), $post_data);
    $errors = $update['errors'];
    $message = $update['message'];
}

?>


<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger mx-auto border-0 border-start border-5 border-danger" style="max-width:600px">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="bg-white mt-4 p-4 border-0 border-top border-5 border-success rounded mx-auto" style="max-width:600px">
        <h2 class="text-success my-4">Modification d'un employe</h2>
        <form action="<?= Security::secure($_SERVER['PHP_SELF']) . '?id='. $id ?> " class="form" method="POST">
            <div class="form-group mb-3">
                <input type="text" name="nom" value="<?= isset($post_data['nom']) ? $post_data['nom'] : Security::secure($employe->nom) ?>" id="nom" class="form-control" placeholder="Votre nom">
                <?php if(isset($errors['nom'])) : ?>
                    <p class="text-danger"><?= $errors['nom'] ?></p>
                <?php endif ?>
            </div>
            <div class="form-group mb-3">
                <input type="text" name="prenom" value="<?= isset($post_data['prenom']) ? $post_data['prenom'] : Security::secure($employe->prenom) ?>" id="prenom" class="form-control" placeholder="Votre prenom">
                <?php if(isset($errors['prenom'])) : ?>
                    <p class="text-danger"><?= $errors['prenom'] ?></p>
                <?php endif ?>
            </div>
            <div class="form-group mb-3">
                <label for="date_naissance" class="mb-3">Date de naissance</label>
                <input type="date" name="date_naissance" value="<?= isset($post_data['date_naissance']) ? $post_data['date_naissance'] : Security::secure($employe->date_naissance) ?>" id="date_naissance" class="form-control">
                <?php if(isset($errors['date_naissance'])) : ?>
                    <p class="text-danger"><?= $errors['date_naissance'] ?></p>
                <?php endif ?>
            </div>
            <div class="form-group mb-3">
                <label for="date_arrivee" class="mb-3">Date d'arrivée</label>
                <input type="date" name="date_arrivee" value="<?= isset($post_data['date_arrivee']) ? $post_data['date_arrivee'] : Security::secure($employe->date_arrivee) ?>" id="date_arrivee" class="form-control">
                <?php if(isset($errors['date_arrivee'])) : ?>
                    <p class="text-danger"><?= $errors['date_arrivee'] ?></p>
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
    <a href="/" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i>  Retourner à l'acceuil</a>
</div>



<?php require_once '../layout/footer.php' ?>