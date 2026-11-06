<?php require_once('header.php'); ?>

<?php
/*traitement des erreurs */
// Si pas admin on redirige a verifier si ca marche
    if (!isset($_SESSION['estAdmin']) || $_SESSION['estAdmin'] != 1) {
        $_SESSION['messageNonAdmin'] = "Vous n'êtes pas administrateur vous n'avez pas accès à cette page !";
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

//Modifier une catégorie
    if (isset($_POST['modifier_id'], $_POST['nouveau_nom'])) {
        $id  = intval($_POST['modifier_id']);
        $nom = trim($_POST['nouveau_nom']);

        if (!empty($nom)) {
            $stmt = $connexion->prepare("UPDATE categorie SET nom = ? WHERE id = ?");
            $stmt->execute([$nom, $id]);
            $msg = "Catégorie modifiée avec succès !";
        }
    }

//Supprimer une catégorie
    if (isset($_POST['supprimer_id'])) {
        $id = intval($_POST['supprimer_id']);

        $verif = $connexion->prepare("SELECT COUNT(*) FROM article WHERE categorie_id = ?");
        $verif->execute([$id]);
        $nbArticles = $verif->fetchColumn();

        if ($nbArticles > 0) {
            $msgErreur = "Impossible de supprimer : $nbArticles article(s) utilisent cette catégorie.";
        } else {
            $stmt = $connexion->prepare("DELETE FROM categorie WHERE id = ?");
            $stmt->execute([$id]);
            $msg = "Catégorie supprimée avec succès !";
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
                    <?php showMsgErreur($msg, color : "#126907"); ?>
                <?php endif; ?>

                <?php if (!empty($msgErreur)): ?>
                    <?php showMsgErreur($msgErreur); ?>
                <?php endif; ?>

                <!-- Formulaire d'ajout -->
                <form method="POST" action="" style="margin-bottom: 20px;">
                    <input type="text" name="nom_categorie" placeholder="Nom de la nouvelle catégorie">
                    <button type="submit">Ajouter</button>
                </form>

                <h2>Liste des catégories existantes</h2>

                <?php foreach ($categories as $cat): ?>
                    <div class="categorie-ligne">
                        <form method="POST" action="">
                            <input type="hidden" name="modifier_id" value="<?= $cat['id'] ?>">
                            <input type="text" name="nouveau_nom" value="<?= htmlspecialchars($cat['nom']) ?>">
                            <button type="submit">Modifier</button>
                        </form>

                        <form method="POST" action="">
                            <input type="hidden" name="supprimer_id" value="<?= $cat['id'] ?>">
                            <button type="submit" name="btReset">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>


<?php // Inclusion du footer
require_once('footer.php');
?>