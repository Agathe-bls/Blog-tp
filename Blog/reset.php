<?php
session_start();

$_SESSION['estConnecte'] = 0;


header("Location: connexion.php");
exit();