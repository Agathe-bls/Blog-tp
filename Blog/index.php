<?php
// Inclusion du header et de la connexion PDO
require_once('header.php');
require_once('pdo.php');

// Vérification de la connexion
if (!isset($_SESSION['estConnecte']) || $_SESSION['estConnecte'] != 1) {
    header("Location: connexion.php");
    exit();
}

// 1. Récupérer dynamiquement la liste unique des auteurs depuis la base de données pour le filtre
$stmtPseudos = $connexion->query("SELECT DISTINCT pseudo FROM article ORDER BY pseudo");
$pseudos = $stmtPseudos->fetchAll(PDO::FETCH_COLUMN);

// 2. Gestion du filtre par pseudo avec une requête SQL sécurisée
$filtrePseudo = isset($_GET['pseudo']) ? trim($_GET['pseudo']) : '';

if ($filtrePseudo !== '') {
    $stmtArticles = $connexion->prepare("SELECT * FROM article WHERE pseudo = ? ORDER BY id DESC");
    $stmtArticles->execute([$filtrePseudo]);
} else {
    $stmtArticles = $connexion->query("SELECT * FROM article ORDER BY id DESC");
}
$articlesFiltres = $stmtArticles->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
    <h2>Accueil du Blog</h2>

    <!-- Formulaire de filtre -->
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
                    <br>
                    <a href="affichageArticle.php?id=<?= $article['id'] ?>">Lire la suite & commentaires</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php
// Inclusion du footer
require_once('footer.php');
?>