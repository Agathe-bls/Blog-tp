<?php require_once('header.php'); ?>

<main>

    <div>
        <h1>Poste un nouvel article !</h1>

        <!-- Formulaire -->
        <form method="POST">
            <label>
                <h2>Titre :</h2>
                <input name="newTitre" type="text" placeholder = "donnez le titre de votre article"/>
            </label>

            <label>
                <h2>Description :</h2>
                <textarea name="newDescription" placeholder = "décrivez votre article" row="8" ></textarea>
            </label>

            <label>
                <h2>Catégorie :</h2>
                <?php $categories = getAllCategories($connexion); ?>

                <select name="newCategorie" required>
                    <option value="" selected hidden >Choisissez une catégorie pour votre article</option>
                    <?php
                    foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </form>
    </div>
</main>

<?php require_once('footer.php'); ?>