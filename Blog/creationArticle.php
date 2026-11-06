<?php require_once('header.php'); ?>

<?php
//Vérification de la connexion
    verifConnexionUtilisateur($connexion);
?>

<?php
/*Initialisation des messages d'erreurs (variables) */
        $msgErreurTitre = null;
        $msgErreurDesc = null;
        $msgErreurCat = null;

/*traitement des erreurs */
/*Bouton reset*/
    if (($_POST['btReset'] ?? '') === 'reset') {
        unset($_SESSION['newTitre'], $_SESSION['newDescription'], $_SESSION['newCategorie']);
        header('Location: creationArticle.php');
        exit;
    }

/*Formulaire*/
    if(!empty($_POST)){
    //Titre
        if(isset($_POST['newTitre']) && !empty($_POST['newTitre'])){
            if(mb_strlen($_POST['newTitre']) < 5){
                $msgErreurTitre = 'Le titre de votre article doit faire au moins 5 caractères !';
            } elseif(titreExist($connexion, $_POST['newTitre'])){
                $msgErreurTitre = 'Ce titre existe déjà pour un autre article !';
            } else {
                $_SESSION['newTitre'] = htmlspecialchars($_POST['newTitre']);
            }
        } else {
            $msgErreurTitre = 'Votre article doit comporter un titre !';
        }
    //Description
        if(isset($_POST['newDescription']) && !empty($_POST['newDescription'])){
            if(mb_strlen($_POST['newDescription']) < 20){
                $msgErreurDesc = 'La description de votre article doit faire au moins 20 caractères !';
            } else {
                $_SESSION['newDescription'] = htmlspecialchars($_POST['newDescription']);
            }
        } else {
            $msgErreurDesc = 'Votre article doit comporter une description !';
        }

    //Catégorie
        if(isset($_POST['newCategorie']) && !empty($_POST['newCategorie'])){
            if(categorieExist($connexion, intval($_POST['newCategorie']))){
                $_SESSION['newCategorie'] = htmlspecialchars(intval($_POST['newCategorie']));
            } else {
                $msgErreurCat = "Seuls les choix de catégories proposés sont possibles !";
            }
        } else {
            $msgErreurCat = "Votre article doit comporter une catégorie !";
        }

    //Enregistrement en bdd reset des variables et redirection
        if(empty($msgErreurTitre) && empty($msgErreurDesc) && empty($msgErreurCat)){
            saveArticle($connexion, $_SESSION['newTitre'] , $_SESSION['newDescription'] , $_SESSION['newCategorie'] , $_SESSION['pseudo']);
            unset($_SESSION['newTitre'], $_SESSION['newDescription'], $_SESSION['newCategorie']);
            header('Location: index.php');
        }
    }
?>

        <main>

            <div>
                <h1>Poste un nouvel article !</h1>
                <!-- Formulaire -->
                <form method="POST" novalidate>

                    <h2>Titre :</h2>
                    <label>
                        <?php showMsgErreur($msgErreurTitre); ?>
                        <input name="newTitre" type="text" placeholder = "Donnez le titre de votre article"
                        value="<?= $_POST['newTitre'] ?? ($_SESSION['newTitre'] ?? '') ?>"/>
                    </label>
                    
                    <h2>Description :</h2>
                    <label>
                        <?php showMsgErreur($msgErreurDesc); ?>
                        <textarea name="newDescription" placeholder = "Décrivez votre article" rows="5"><?= $_POST['newDescription'] ?? ($_SESSION['newDescription'] ?? '') ?></textarea>
                    </label>

                    <h2>Catégorie :</h2>
                    <label>
                        <?php showMsgErreur($msgErreurCat); ?>
                        <?php $categories = getAllCategories($connexion); ?>

                        <select name="newCategorie" required>
                            <option value="" selected hidden>Choisissez une catégorie pour votre article</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                <?= (($_SESSION['newCategorie'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                    <?= $cat['nom']?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <br>
                    <button type="submit" name="btPoster">Poster mon nouvel article</button>
                    <button type="submit" name="btReset">Annuler la création du nouveau post</button>
                </form>
            </div>
        </main>

<?php require_once('footer.php'); ?>