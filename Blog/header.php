<?php
    declare(strict_types=1);
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

?>
<?php require_once('pdo.php'); ?>
<?php require_once('fonctionsUtiles.php'); ?>

<html>
    <head>
        <title>Blog - TP Noté</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <div class="logo">
                <h1>The Blog</h1>
            </div>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="creationArticle.php">Poster</a></li>
                <li><a href="reset.php">Déconnexion</a></li>
            </ul>
        </header>