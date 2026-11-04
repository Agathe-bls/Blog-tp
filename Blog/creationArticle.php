<?php require_once('header.php'); ?>


    <div>
        <h1>Création d'un nouvel article</h1>

        <form method="POST">
            <label>
                Titre :
                <input name="newTitre" type="text"/>
            </label>

            <label>
                Description :
                <input name="newDescription" type="text"/>
            </label>

            <label>
                Catégorie :
                <?php $categories = getAllCategories($connexion); ?>

                <select name="newCategorie">
                    <option value="">---Choisir une catégorie---</option>
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


<?php require_once('footer.php'); ?>