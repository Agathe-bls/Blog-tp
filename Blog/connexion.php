<?php require_once('header.php'); ?>

<?php
/*Initialisation des messages d'erreurs (variables) */
    $msgErreur = "";
    $msgErreurMDP = "";

/*traitement des erreurs */
    if (isset($_POST['email']) && isset($_POST['mdp'])) {
        if (mb_strlen($_POST['mdp']) < 8){
            $msgErreurMDP = 'Votre mot de passe est invalide, il doit comporter plus de 8 caractères !';
        } else {    
            $email = $_POST['email'];
            $mdp = $_POST['mdp'];

            $query2 = "select * from user where email = ?";
            $result2 = $connexion->prepare($query2);
            $result2->execute([$email]);
            $testEmail = $result2->fetch(PDO::FETCH_ASSOC);

            if(!$testEmail){
                $_SESSION['email'] = $email;
                $_SESSION['mdp'] = $mdp;
                header("Location: nouveauPseudo.php");
                exit();
            }

            $result1 = $connexion->prepare("select * from user where email = ? AND mdp = ?");
            $result1->execute([$email, $mdp]);
            $user = $result1->fetch(PDO::FETCH_ASSOC);
            
            if($user){
                $_SESSION['estConnecte'] = 1;
                $_SESSION['pseudo'] = $user['pseudo'];

                if ($user['email'] == "admin@localhost.fr" && $user['mdp'] == "admin69IUT") {
                    $_SESSION['estAdmin'] = 1;
                } else {
                    $_SESSION['estAdmin'] = 0;
                }
                
                header("Location: index.php");
                exit();
            } else {
                $msgErreur = "Mot de passe et email invalides !";
            }
        }

    }
?>

        <main>
            <div>
                <h1>Connexion</h1>
                
                <?php
                showMsgErreur($msgErreur);
                showMsgErreur($msgErreurMDP);
                if(isset($_SESSION['msgErreurConnexion'])){
                    showMsgErreur($_SESSION['msgErreurConnexion']);
                    unset($_SESSION['msgErreurConnexion']);
                }
                ?>
                <form method="post" action="">
                    <input type="text" name="email" placeholder="Mail utilisateur" required
                    value="<?= $_POST['email'] ?? ($_SESSION['email'] ?? '') ?>"><br>
                    <input type="password" name="mdp" placeholder="Mot de passe" required><br>
                    <button type="submit">Se connecter</button>
                </form>
            </div>

        </main>

<?php require_once('footer.php'); ?>