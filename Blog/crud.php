<?php
session_start();
require_once('pdo.php');



//Ajout d'une catégorie
$msg = "";
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

<html>
    <head>
        <title>Gestion des Catégories</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <main>
            <h2>Gestion des Catégories</h2>

            <?php if (!empty($msg)): ?>
                <p style="color: green;"><?= $msg ?></p>
            <?php endif; ?>

            <!-- Formulaire -->
            <form method="POST" action="crud.php" style="margin-bottom: 20px;">
                <input type="text" name="nom_categorie" placeholder="Nom de la nouvelle catégorie">
                <button type="submit">Ajouter</button>
            </form>

            <!-- Liste simple pour vérifier que ça s'enregistre bien (a enlever plus tard)-->
            <ul>
                <?php foreach ($categories as $cat): ?>
                    <li>ID <?= $cat['id'] ?> : <strong><?= htmlspecialchars($cat['nom']) ?></strong></li>
                <?php endforeach; ?>
            </ul>

            <p><a href="index.php">Retour à l'accueil</a></p>
        </main>
    </body>
</html>

<?php
// Inclusion du footer
require_once('footer.php');
?>