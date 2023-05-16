<?php

$title = "404 Not found";
require_once '../layout/header.php';
header("HTTP/1.1 404 Page not found");
?>
<div class="mt-4">
    <div class="text-center bg-white mt-4 p-4 border-0 border-top border-5 border-danger rounded mx-auto" style="max-width:600px">
        <h1 class=" display-1 text-danger my-4">404 Error</h1>
        <h4 class="mb-4">Page not found</h4>
        <p>Ooopss... Something goes wrong</p>
        <div class="my-4 mx-auto" style="max-width:600px">
            <a href="/" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retourner à l'acceuil</a>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>