<?php

$title = "503 Service Unavailable";
require_once '../layout/header_error.php';
header("HTTP/1.1 500 Internal Server Error");
?>

<div class="mt-4">
    <div class="text-center bg-white mt-4 p-4 border-0 border-top border-5 border-danger rounded mx-auto" style="max-width:600px">
        <h1 class=" display-1 text-danger my-4">503 Error</h1>
        <h4 class="mb-4">Failed to connect to database</h4>
        <p>Ooopss... Service Unavailable</p>
    </div>
</div>


<?php require_once '../layout/footer.php' ?>