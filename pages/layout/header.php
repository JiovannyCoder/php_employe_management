<?php require '../../vendor/autoload.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Gestion du personnel'  ?></title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/bootstrap/icon/font/bootstrap-icons.css">

    <script defer src="../../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <script defer src="../../assets/js/app.js"></script>
</head>
<body>
    <?php require_once 'navbar.php' ?>
    <div class="container my-5" <?= isset($title) ? 'id="'.$title.'"' : ''  ?>>
