<?php 
require_once("header.php"); // contient la connexion et la fonction supprimerCommentaire()


// Vérifie qu'un id a été envoyé
if (isset($_POST['id_article'])) {

    $idArticle = intval($_POST['id_article']);

    $stmtCom = $connexion->prepare("SELECT * FROM commentaire WHERE article_id = ? ORDER BY id DESC");
    $stmtCom->execute([$idArticle]);
    $commentairesArticle = $stmtCom->fetchAll(PDO::FETCH_ASSOC);

    foreach($commentairesArticle as $comm){
        $id = $comm['id'];
        supprimerCommentaire($id, $connexion);
    }

    supprArticle($idArticle, $connexion);
    


}
// Retour à la page précédente

$_SESSION['messageSuppression'] = "article suppimé avec succès";
header("Location: index.php" );
exit();

?>