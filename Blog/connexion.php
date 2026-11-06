<?php require_once('header.php'); ?>

<?php
/*Initialisation des messages d'erreurs (variables) */
    $msgErreur = "";

/*traitement des erreurs */
    if (isset($_POST['email']) && isset($_POST['mdp'])) {

        $email = $_POST['email'];
        $mdp = $_POST['mdp'];
        /*
        if($email == "admin@localhost.fr" && $mdp == "admin69IUT"){
            $_SESSION['estAdmin'] = 1;
            header("Location: index.php");
            exit();
        }*/

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
            header("Location: index.php");
            exit();
        }
    }
?>

        <main>
            <div>
                <h1>Connexion</h1>
                
                <?php showMsgErreur($msgErreur); ?>

                <form method="post" action="">
                    <input type="text" name="email" placeholder="Mail utilisateur" required><br>
                    <input type="password" name="mdp" placeholder="Mot de passe" required><br>
                    <button type="submit">Se connecter</button>
                </form>
            </div>

        </main>

<?php require_once('footer.php'); ?>