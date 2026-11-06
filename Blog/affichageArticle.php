<?php
//Inclusion du header et de la BDD 
    require_once('header.php');
?>

<?php
//Vérification de la connexion
    if (!isset($_SESSION['estConnecte']) || $_SESSION['estConnecte'] != 1) {
        header("Location: connexion.php");
        exit();
    }
?>

<?php
/*Initialisation des messages d'erreurs (variables) */
    

/*traitement des erreurs */

//Récupérer l'ID de l'article passé dans l'URL
    $articleId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Récupérer l'article depuis la base de données via une requête 
    $stmtArticle = $connexion->prepare("SELECT * FROM article WHERE id = ?");
    $stmtArticle->execute([$articleId]);
    $articleCourant = $stmtArticle->fetch(PDO::FETCH_ASSOC);

//Vérifier si l'article existe bien
    if (!$articleCourant) {
    ?>
        <main>
            <a href="index.php">← Retour à l'accueil</a> <br> <br>
            <?php showMsgErreur("Oups ! Cet article n'existe pas."); ?>
        </main>
    <?php
        require_once('footer.php');
        exit();
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
            <a href="index.php">← Retour à l'accueil</a>

            <article>
                <h1><?= htmlspecialchars($articleCourant['titre']) ?></h1>
                <p>Écrit par <strong><?= htmlspecialchars($articleCourant['pseudo']) ?></strong></p>
                <p><?= htmlspecialchars($articleCourant['description']) ?></p>
                <?php if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] == $articleCourant['pseudo']){ ?>
                    <form method="post" action="supprimerArticle.php">
                        <input type="hidden" name="id_article" value="<?= $articleCourant['id'] ?>">
                            <button type="submit">
                                Supprimer mon article
                            </button>
                    </form>
                <?php } ?>
            </article>

            <div class="section-commentaires">
                <h2>Commentaires</h2>

                <?php if (empty($commentairesArticle)): ?>
                    <?php showMsgErreur("Aucun commentaire pour l'instant. Soyez le premier à réagir !", color : '#126907'); ?>
                <?php else: ?>
                    <?php foreach ($commentairesArticle as $com): ?>
                        <div class="commentaire">
                            <p><strong><?= htmlspecialchars($com['pseudo']) ?></strong> a écrit :</p>
                            <p><?= htmlspecialchars($com['description']) ?></p>

                            <?php if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] == $com['pseudo']){ ?>

                                <form method="post" action="supprimerCommentaire.php">
                                    <input type="hidden" name="id_com" value="<?= $com['id'] ?>">
                                        <button type="submit">
                                            Supprimer mon commentaire
                                        </button>
                                </form>
                            <?php } ?>

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Formulaire -->
                <h3>Ajouter un commentaire</h3>
                <form method="POST" action="affichageArticle.php?id=<?= $articleId ?>">
                    <textarea name="texte_commentaire" rows="4" placeholder="Écrivez votre commentaire ici..." required></textarea>
                    <button type="submit">Poster le commentaire</button>
                </form>
            </div>
        </main>

<?php
// Inclusion du footer
require_once('footer.php');
?>