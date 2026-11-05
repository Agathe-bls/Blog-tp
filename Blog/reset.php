<?php
session_start();

$_SESSION['estConnecte'] = 0;
$_SESSION['email'] = null;
$_SESSION['mdp'] = null;

header("Location: connexion.php");
exit();