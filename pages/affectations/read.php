<?php

use app\models\Employe;
use app\models\Metier;
use app\models\Service;
use app\Security;
use controllers\EmployeController;


$title = "Affectation";
require_once '../layout/header.php';

$id = -1;
$metiersEmploye = null;
$metiers = Metier::index();
$services = Service::index();


if ($_GET && Security::isNumber($_GET['id'])) {
    $id = Security::secure($_GET['id']);
    $metiersEmploye = Employe::getMetiers($id);
}

$resultat = EmployeController::read($id);
$employe = $resultat['data'];

$post_data = [];
$message = '';
$errors = [];

if ($_POST && isset($_POST['addAffectation'])) {
    $post_data = [
        'id_employe' => $employe->id,
        'id_metier' => Security::secure($_POST['id_metier']),
        'id_service' => Security::secure($_POST['id_service']),
        'temps' => Security::secure($_POST['temps'])
    ];

    $affectation = EmployeController::addMetier($post_data);
    $message = $affectation['message'];
    $errors = $affectation['errors'];

    $metiersEmploye = Employe::getMetiers($id);
}

if ($_POST && isset($_POST['deleteAffectation'])) {
    $post_data = [
        'id_employe' => $employe->id,
        'id_metier' => Security::secure($_POST['id_metier']),
        'id_service' => Security::secure($_POST['id_service'])
    ];

    EmployeController::deleteMetier($post_data);
    $metiersEmploye = Employe::getMetiers($id);
}

?>


<?php if ($resultat['error']) : ?>
    <div class="alert alert-danger border-0 border-start border-5 border-danger">
        <?= $resultat['error'] ?>
    </div>
<?php else : ?>
    <div class="bg-white mt-4 px-4 py-5 rounded row">     
        <h2 class="text-primary"><?= $employe->prenom . ' ' . $employe->nom ?></h2>
        <p class="text-secondary h6">Arrivé le <?= $employe->date_arrivee ?></p>
        
        <div class="my-4 px-0">
            <form method="POST"  action="<?=  Security::secure($_SERVER['PHP_SELF']) . '?id='. $id ?>" class="form bg-light  p-3 rounded shadow-sm ">
                <div class="row align-items-end">
                    <div class="col-md-3 form-group mb-3">
                        <label class="mb-3 text-success">Metier</label>
                        <select name="id_metier" class="form-control">
                            <?php foreach($metiers as $metier) : ?>
                                <option value="<?= $metier->id ?>"><?= $metier->nom ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php if (isset($errors['id_metier'])) : ?>
                            <p class="text-danger"><?= $errors['id_metier'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label class="mb-3 text-primary">Service</label>
                        <select name="id_service" class="form-control">
                            <?php foreach($services as $service) : ?>
                                <option value="<?= $service->id ?>"><?= $service->nom ?></option>
                            <?php endforeach ?>
                        </select>
                        <?php if (isset($errors['id_service'])) : ?>
                            <p class="text-danger"><?= $errors['id_service'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <label class="mb-3 text-secondary">Temps</label>
                        <select name="temps" class="form-control">
                            <option value="plein">plein</option>
                            <option value="mi-temps">mi-temps</option>
                        </select>
                        <?php if (isset($errors['temps'])) : ?>
                            <p class="text-danger"><?= $errors['temps'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="col-md-3 form-group mb-3">
                        <button class="btn btn-primary rounded-pill px-3" name="addAffectation"><i class="bi bi-folder-plus me-2"></i> Affecter ce metier</button>
                    </div>
                </div>
            </form>
            <?php if($message ) : ?>
                <div class="border-0 border-start border-success border-5  alert alert-success mt-4">
                    <?= $message ?>
                </div>
            <?php endif ?>

            <?php if(isset($errors['exerce'])) : ?>
                <div class="border-0 border-start border-danger border-5 alert alert-danger mt-4">
                    <?= $errors['exerce'] ?>
                </div>
            <?php endif ?>

        </div>
        <p class="h6 mb-4">Métier<?= count($metiersEmploye) > 1 ? 's' : '' ?> affecté<?= count($metiersEmploye) > 1 ? 's' : '' ?>  à l'employe : </p>

        <?php if(!$metiersEmploye) : ?>
            <div class="border-0 border-start border-info border-5 alert alert-info py-4">
                Cet employe n'a pas encore été affecté à un metier...
            </div>
        <?php else : ?>

            <?php foreach ($metiersEmploye as $metier) : ?>
                <div class="mx-1 row bg-white p-2 rounded border-start my-1 border-5">
                    <div class="col-sm-1">
                        <div class="h6 text-secondary my-2">ID</div>
                        <p># <?= $metier->id_metier ?></p>
                    </div>
                    <div class="col-sm-5">
                        <div class="h6 text-success my-2">Nom du metier</div>
                        <p><?= $metier->nom_metier ?></p>
                    </div>
                    <div class="col-sm-4">
                        <div class="h6 text-primary my-2">Nom du service</div>
                        <p><?= $metier->nom_service?></p>
                    </div>
                    <div class="col-sm-2 text-center">
                        <div class="h6 text-secondary my-2">Actions</div>
                        <div>
                            <form method="POST" action="<?=  Security::secure($_SERVER['PHP_SELF']) . '?id='. $id ?>">
                                <input type="text" name="id_employe" value="<?= $id ?>" hidden>
                                <input type="text"  name="id_metier" value="<?= $metier->id_metier?>" hidden>
                                <input type="text"  name="id_service" value="<?= $metier->id_service ?>" hidden>
                                <button class="btn btn-outline-danger btn-sm rounded-pill" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer" type="submit" name="deleteAffectation"><i class="bi-trash-fill"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>

        <?php endif ?>
    </div>

<?php endif ?>
<div class="my-4">
    <a href="../affectations/index.php" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retourner aux affectations</a>
</div>




<?php require_once '../layout/footer.php' ?>