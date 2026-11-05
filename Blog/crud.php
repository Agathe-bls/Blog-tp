<?php require_once('header.php'); ?>

<?php
/*Initialisation des messages d'erreurs (variables) */
    $msg = "";

/*traitement des erreurs */
// Si pas admin on redirige a verifier si ca marche
    if (!isset($_SESSION['estAdmin']) || $_SESSION['estAdmin'] != 1) {
        header("Location: index.php");
        exit();
    }

//Ajout d'une catégorie
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom_categorie'])) {
        $nom = trim($_POST['nom_categorie']);
        if (!empty($nom)) {
            $stmt = $connexion->prepare("INSERT INTO categorie (nom) VALUES (?)");
            $stmt->execute([$nom]);
            $msg = "Catégorie ajoutée avec succès !";
        }
    }

//Récupérer toutes les catégories
    $stmt = $connexion->query("SELECT * FROM categorie ORDER BY id DESC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

        <main>
            <div>
                <h1>Gestion des Catégories</h1>

                <?php if (!empty($msg)): ?>
                    <?php showMsgErreur($msg, color : 'green'); ?>
                    <!-- <p style="color: green;"><?= $msg ?></p> -->
                <?php endif; ?>

                <!-- Formulaire -->
                <form method="POST" action="crud.php" style="margin-bottom: 20px;">
                    <input type="text" name="nom_categorie" placeholder="Nom de la nouvelle catégorie" >
                    <button type="submit">Ajouter</button>
                </form>

                <!-- Liste simple pour vérifier que ça s'enregistre bien (a enlever plus tard)-->
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li>ID <?= $cat['id'] ?> : <strong><?= htmlspecialchars($cat['nom']) ?></strong></li>
                    <?php endforeach; ?>
                </ul>

                <p><a href="index.php">Retour à l'accueil</a></p>
            </div>
        </main>

<?php// Inclusion du footer
require_once('footer.php');
?>