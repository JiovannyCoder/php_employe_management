<?php

use app\Security;
use app\db\Pagination;
use controllers\ServiceController;

$title = "Services";
require_once '../layout/header.php';

$resultat = ServiceController::index();
$services = $resultat['data'];

$errors = [];
$message = '';
$post_data = [];

if ($_POST && Security::isVerified(['create', 'nom'], Security::POST_TYPE)) {
    $post_data = [
        'nom' => Security::secure($_POST['nom']),
    ];

    $update = ServiceController::create($post_data);
    $errors = $update['errors'];
    $message = $update['message'];

    if(!$errors) {
        $resultat = ServiceController::index();
        $services = $resultat['data'];
    }
}

//pagination
$elements_par_page = $resultat['elements_par_page'];
$page_courante = $resultat['page_courante'];
$nombre_pages = $resultat['nombre_pages'];

$pagination = new Pagination($elements_par_page, $page_courante, $nombre_pages);

?>
<div class="row">
    <div class="col-md-8">
        <div class="mt-4">
            <h4 class="text-secondary my-4">Informations des Services</h4>
            <?php foreach ($services as $service) : ?>
                <div class="mx-1 row bg-white p-2 rounded border-start my-2 border-5 border-warning">
                    <div class="col-md-1">
                        <div class="h6 text-secondary my-2">ID</div>
                        <p># <?= $service->id ?></p>
                    </div>
                    <div class="col-md-6">
                        <div class="h6 text-secondary my-2">Nom du service</div>
                        <p><?= $service->nom ?></p>
                    </div>
                    <div class="col-md-3">
                        <div class="h6 text-secondary my-2">Details du service</div>
                        <p><a class="btn btn-outline-info btn-sm rounded-pill my-1" href="../services/read.php?id=<?= $service->id ?>">Employés affectés</a></p>
                    </div>
                    <div class="col-md-2 text-center">
                        <div class="h6 text-secondary my-2">Actions</div>
                        <div>
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Modifier" class="btn btn-outline-warning btn-sm rounded-pill my-1" href="../services/update.php?id=<?= $service->id ?>"><i class="bi-pencil-fill"></i></a>
                            <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Supprimer" class="btn btn-outline-danger btn-sm rounded-pill my-1" href="../services/delete.php?id=<?= $service->id ?>"><i class="bi-trash-fill"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
        <div class="mt-4">
            <?= $pagination->afficherPagination() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mt-4">
            <h4 class="text-secondary my-4">Nouveau service</h4>
            <form action="<?= Security::secure($_SERVER['PHP_SELF']) ?>" class="form" method="POST">
                <div class="form-group mb-3">
                    <input type="text" name="nom" id="nom" value="<?= isset($post_data['nom']) ? $post_data['nom'] : '' ?>" class="form-control" placeholder="Nom du service">
                    <?php if (isset($errors['nom'])) : ?>
                        <p class="text-danger"><?= $errors['nom'] ?></p>
                    <?php endif ?>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" name="create" value="create" class="btn my-2 w-100 btn-warning rounded-pill text-white"><i class="bi-folder-plus me-1"></i> Ajouter un service</button>
                </div>
                <?php if ($message) : ?>
                    <div class="alert alert-success rounded border-0 border-5 border-start my-2 border-success">
                        <?= $message ?>
                    </div>
                <?php endif ?>
            </form>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>