<?php

use app\models\Employe;
use app\Security;
use controllers\EmployeController;

$title = "Employes | create";
require_once '../layout/header.php';

$errors = [];
$message = '';
$post_data = [];
$metiers = Employe::getMetiersEtServices();

if ($_POST && Security::isVerified(['create', 'nom', 'date_naissance', 'date_arrivee', 'metiers', 'temps'], Security::POST_TYPE)) {
    $post_data = [
        'nom' => Security::secure($_POST['nom']),
        'prenom' => Security::secure($_POST['prenom']),
        'date_naissance' => Security::secure($_POST['date_naissance']),
        'date_arrivee' => Security::secure($_POST['date_arrivee']),
        'metiers' => json_decode(Security::secure($_POST['metiers'])),
        'temps' => Security::secure($_POST['temps'])
    ];
    $update = EmployeController::create($post_data);
    $errors = $update['errors'];
    $message = $update['message'];
}
?>


<!-- <?php if ($errors) : ?>
    <div class="alert alert-danger mx-auto" style="max-width:600px">
        <?= $errors ?>
    </div>
<?php endif ?> -->
<div class="bg-white mt-4 p-4 border-0 border-top border-5 border-primary rounded mx-auto" style="max-width:960px">
    <h2 class="text-primary my-4">Ajouter un employe</h2>
    <form action="<?= Security::secure($_SERVER['PHP_SELF']) ?>" class="form" method="POST">
        <div class="row">
            <div class="col-md-7">
                <div class="form-group mb-3">
                    <input type="text" name="nom" id="nom" value="<?= isset($post_data['nom']) ? $post_data['nom'] : '' ?>" class="form-control" placeholder="Nom de l'employe">
                    <?php if (isset($errors['nom'])) : ?>
                        <p class="text-danger"><?= $errors['nom'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <input type="text" name="prenom" value="<?= isset($post_data['prenom']) ? $post_data['prenom'] : '' ?>" id="prenom" class="form-control" placeholder="Prenom de l'employe">
                    <?php if (isset($errors['prenom'])) : ?>
                        <p class="text-danger"><?= $errors['prenom'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <label for="date_naissance" class="mb-3">Date de naissance</label>
                    <input type="date" name="date_naissance" value="<?= isset($post_data['date_naissance']) ? $post_data['date_naissance'] : '' ?>" id="date_naissance" class="form-control">
                    <?php if (isset($errors['date_naissance'])) : ?>
                        <p class="text-danger"><?= $errors['date_naissance'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <label for="date_arrivee" class="mb-3">Date d'arrivée</label>
                    <input type="date" name="date_arrivee" value="<?= isset($post_data['date_arrivee']) ? $post_data['date_arrivee'] : '' ?>" id="date_arrivee" class="form-control">
                    <?php if (isset($errors['date_arrivee'])) : ?>
                        <p class="text-danger"><?= $errors['date_arrivee'] ?></p>
                    <?php endif ?>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group mb-3">
                    <label class="mb-3">Metier de l'employe </label>
                    <select class="form-select" name="metiers">
                        <option selected value="null">Sélectionner un metier</option>
                        <?php foreach ($metiers as $metier) : ?>
                            <option <?= (isset($post_data['metiers']) && $metier->id_metier == $post_data['metiers'][0] && $metier->id_service == $post_data['metiers'][1]) ? 'selected' : '' ?> class="rounded mt-1 py-2 px-3" value="<?= Security::secure(json_encode([$metier->id_metier, $metier->id_service])) ?>">
                                <div class="row">
                                    <div class="col-6"><?= $metier->nom_metier ?> | </div>
                                    <div class="col-6 text-end"> <?= $metier->nom_service ?></div>
                                </div>
                            </option>
                        <?php endforeach ?>
                    </select>
                    <?php if (isset($errors['metiers'])) : ?>
                        <p class="text-danger"><?= $errors['metiers'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <label class="mb-3">Temps de travail</label>
                    <select class="form-select" name="temps">
                        <option selected value="plein">plein</option>
                        <option <?= isset($post_data['temps']) && $post_data['temps'] === 'mi-temps' ? 'selected' : '' ?> value="mi-temps">mi-temps</option>
                    </select>
                    <?php if (isset($errors['temps'])) : ?>
                        <p class="text-danger"><?= $errors['temps'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="create" value="create" class="btn w-100 btn-primary rounded-pill"><i class="bi-folder-plus me-1"></i> Sauvegarder</button>
                </div>
                <?php if ($message) : ?>
                    <div class="alert alert-success rounded border-0 border-5 border-start my-2 border-success">
                        <?= $message ?>
                    </div>
                <?php endif ?>
            </div>
        </div>


    </form>
</div>

<div class="my-4 mx-auto" style="max-width:960px">
    <a href="/" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retourner à l'acceuil</a>
</div>



<?php require_once '../layout/footer.php' ?>