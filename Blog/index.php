<?php

//Inclusion du header
require_once('header.php');
require_once('pdo.php');
$estConnecte = $_SESSION['estConnecte'];
if($estConnecte == 0){
    header("Location: connexion.php");
    exit();
}

//Simulation temporaire des articles (avec les pseudos disponibles)
$articles = [
    ['id' => 1, 'titre' => 'Mon premier article', 'description' => 'Contenu du premier article...', 'pseudo' => 'John Lenon'],
    ['id' => 2, 'titre' => 'Découverte de PHP', 'description' => 'PHP c\'est super pour créer des sites web dynamiques.', 'pseudo' => 'Paul McCartney'],
    ['id' => 3, 'titre' => 'Les bases de SQL', 'description' => 'Apprendre à faire des requêtes SELECT.', 'pseudo' => 'John Lenon'],
];

//Récupérer une liste unique des pseudos pour la liste déroulante automatiquement
$pseudos = array_unique(array_column($articles, 'pseudo'));

//Gestion du filtre par pseudo
$filtrePseudo = isset($_GET['pseudo']) ? trim($_GET['pseudo']) : '';

$articlesFiltres = $articles;
if ($filtrePseudo !== '') {
    $articlesFiltres = array_filter($articles, function($article) use ($filtrePseudo) {
        return strcasecmp($article['pseudo'], $filtrePseudo) === 0;
    });
}
?>

<main>
    <h2>Accueil du Blog</h2>

    <!-- Formulaire -->
    <form method="GET" action="index.php">
        <label for="pseudo">Filtrer par auteur :</label>
        <select id="pseudo" name="pseudo">
            <option value="">Tous les auteurs</option>
            <?php foreach ($pseudos as $p): ?>
                <option value="<?= htmlspecialchars($p) ?>" <?= ($filtrePseudo === $p) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
        <a href="index.php">Réinitialiser</a>
    </form>

    <h3>Liste des articles</h3>

    <?php if (empty($articlesFiltres)): ?>
        <p>Aucun article trouvé pour cet auteur.</p>
    <?php else: ?>
        <div class="liste-articles">
            <?php foreach ($articlesFiltres as $article): ?>
                <div class="article-card">
                    <h4><?= htmlspecialchars($article['titre']) ?></h4>
                    <p><?= htmlspecialchars($article['description']) ?></p>
                    <small>Écrit par <strong><?= htmlspecialchars($article['pseudo']) ?></strong></small>
                    <a href="affichageArticle.php?id=<?= $article['id'] ?>">Lire la suite & commentaires</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php
// Inclusion du footer
include('footer.php');
?>