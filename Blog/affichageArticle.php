<?php
//Inclusion du header et de la BDD
require_once('header.php');
require_once('pdo.php');

//Vérification de la connexion
if (!isset($_SESSION['estConnecte']) || $_SESSION['estConnecte'] != 1) {
    header("Location: connexion.php");
    exit();
}

//Récupérer l'ID de l'article passé dans l'URL
$articleId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer l'article depuis la base de données via une requête 
$stmtArticle = $connexion->prepare("SELECT * FROM article WHERE id = ?");
$stmtArticle->execute([$articleId]);
$articleCourant = $stmtArticle->fetch(PDO::FETCH_ASSOC);

//Vérifier si l'article existe bien
if (!$articleCourant) {
    echo "<main><p>Oups ! Cet article n'existe pas.</p><p><a href='index.php'>Retour à l'accueil</a></p></main>";
    require_once('footer.php');
    exit;
}

//Gestion de l'ajout d'un commentaire via le formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texte_commentaire'])) {
    $texteCommentaire = trim($_POST['texte_commentaire']);
    
    if (!empty($texteCommentaire)) {
        //On récupère le pseudo stocké en session (ou 'Anonyme' par défaut)
        $pseudoCommentaire = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : 'Anonyme';

        //Insertion du commentaire dans la table `commentaire`
        $stmtInsertCom = $connexion->prepare("INSERT INTO commentaire (article_id, description, pseudo) VALUES (?, ?, ?)");
        $stmtInsertCom->execute([$articleId, $texteCommentaire, $pseudoCommentaire]);
        
        //Redirection pour actualiser la page
        header("Location: affichageArticle.php?id=" . $articleId);
        exit;
    }
}

//Récupérer les commentaires liés à cet article depuis la base de données
$stmtCom = $connexion->prepare("SELECT * FROM commentaire WHERE article_id = ? ORDER BY id DESC");
$stmtCom->execute([$articleId]);
$commentairesArticle = $stmtCom->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <p><a href="index.php">← Retour à l'accueil</a></p>

    <article>
        <h2><?= htmlspecialchars($articleCourant['titre']) ?></h2>
        <p>Écrit par <strong><?= htmlspecialchars($articleCourant['pseudo']) ?></strong></p>
        <p><?= htmlspecialchars($articleCourant['description']) ?></p>
    </article>

    <section class="section-commentaires">
        <h3>Commentaires</h3>

        <?php if (empty($commentairesArticle)): ?>
            <p>Aucun commentaire pour l'instant. Soyez le premier à réagir !</p>
        <?php else: ?>
            <?php foreach ($commentairesArticle as $com): ?>
                <div class="commentaire" style="background: #f9f9f9; padding: 10px; margin-bottom: 10px; border-radius: 4px;">
                    <p><strong><?= htmlspecialchars($com['pseudo']) ?></strong> a écrit :</p>
                    <p><?= htmlspecialchars($com['description']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Formulaire -->
        <h4>Ajouter un commentaire</h4>
        <form method="POST" action="affichageArticle.php?id=<?= $articleId ?>">
            <textarea name="texte_commentaire" rows="4" placeholder="Écrivez votre commentaire ici..." required style="width: 100%;"></textarea>
            <br><br>
            <button type="submit">Poster le commentaire</button>
        </form>
    </section>
</main>

<?php
// Inclusion du footer
require_once('footer.php');
?>