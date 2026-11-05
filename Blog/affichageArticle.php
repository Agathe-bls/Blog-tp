<?php
//Inclusion du header
require_once('header.php');



//Récupérer l'ID de l'article passé dans l'URL
$articleId = isset($_GET['id']) ? intval($_GET['id']) : 0;

//Simulation des articles (pour l'instant)
$articles = [
    1 => ['id' => 1, 'titre' => 'Mon premier article', 'description' => 'Contenu complet et détaillé du premier article...', 'pseudo' => 'John Lenon'],
    2 => ['id' => 2, 'titre' => 'Découverte de PHP', 'description' => 'Contenu complet sur PHP c\'est super pour créer des sites web dynamiques.', 'pseudo' => 'Paul McCartney'],
    3 => ['id' => 3, 'titre' => 'Les bases de SQL', 'description' => 'Contenu complet pour apprendre à faire des requêtes SELECT.', 'pseudo' => 'John Lenon'],
];

//Vérifier si l'article existe bien
if (!isset($articles[$articleId])) {
    echo "<main><p>Oups ! Cet article n'existe pas.</p><p><a href='index.php'>Retour à l'accueil</a></p></main>";
    include('footer.php');
    exit;
}

$articleCourant = $articles[$articleId];

// Simulation des commentaires (stockés en session pour l'exemple)
if (!isset($_SESSION['commentaires'])) {
    $_SESSION['commentaires'] = [
        ['article_id' => 1, 'description' => 'Super article, merci pour les explications !', 'pseudo' => 'George Harrison'],
        ['article_id' => 1, 'description' => 'Très clair, j\'ai tout compris.', 'pseudo' => 'Ringo Starr'],
    ];
}

// 3. Gestion de l'ajout d'un commentaire via le formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['texte_commentaire'])) {
    $texteCommentaire = trim($_POST['texte_commentaire']);
    
    if (!empty($texteCommentaire)) {
        // On ajoute le nouveau commentaire au tableau de session
        $_SESSION['commentaires'][] = [
            'article_id' => $articleId,
            'description' => $texteCommentaire,
            'pseudo' => 'UtilisateurTest' // Remplacé plus tard par le vrai pseudo de session
        ];
        
        // Redirection pour actualiser la page proprement
        header("Location: affichageArticle.php?id=" . $articleId);
        exit;
    }
}

// Filtrer uniquement les commentaires liés à cet article
$commentairesArticle = array_filter($_SESSION['commentaires'], function($c) use ($articleId) {
    return $c['article_id'] === $articleId;
});
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
            <button type="submit">Poster le commentaire</button>
        </form>
    </section>
</main>

<?php
//Inclusion du footer
include('footer.php');
?>