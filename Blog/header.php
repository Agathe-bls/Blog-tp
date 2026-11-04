<?php
    declare(strict_types=1);
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $_SESSION['estConnecte'] = 0;
?>

<html>
    <meta>
        <title>Blog</title>
    </meta>

    <head>
        <meta charset="UTF-8">
        <title>Mon Blog - TP Noté</title>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <header>
            <div class="logo">
                <h2>The Blog</h2>
            </div>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="creationArticle.php">Poster</a></li>
            </ul>
        </header>