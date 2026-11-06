<?php 
require_once("header.php"); // contient la connexion et la fonction supprimerCommentaire()


// Vérifie qu'un id a été envoyé
if (isset($_POST['id_com'])) {

    $id = intval($_POST['id_com']);

    supprimerCommentaire($id, $connexion);


}
$_SESSION['messageSuppression'] = "Commentaire supprimé avec succès !"; 
// Retour à la page précédente
header("Location: index.php" );
exit();

?>