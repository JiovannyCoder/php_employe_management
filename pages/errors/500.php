<?php

$title = "500 Internal Server Error";
require_once '../layout/header.php';
header("HTTP/1.1 500 Internal Server Error");
?>
<div class="mt-4">
    <div class="text-center bg-white mt-4 p-4 border-0 border-top border-5 border-danger rounded mx-auto" style="max-width:600px">
        <h1 class=" display-1 text-danger my-4">500 Error</h1>
        <h4 class="mb-4">Internal Server Error</h4>
        <p>Ooopss... Something goes wrong</p>
        <div class="my-4 mx-auto" style="max-width:600px">
            <a href="/" class="btn btn-sm btn-outline-primary rounded-pill"><i class="bi-arrow-left"></i> Retourner à l'acceuil</a>
        </div>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>