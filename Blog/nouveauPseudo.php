<?php require_once('header.php');?>

<?php
/*Initialisation des messages d'erreurs (variables) */
    $msgErreur = "";

/*traitement des erreurs */
    if(isset($_POST['pseudo'])){
        $pseudo = $_POST['pseudo'];
        $query3 = "select * from user where pseudo = ?";
        $result3 = $connexion->prepare($query3);
        $result3->execute([$pseudo]);

        if($result3){
            $testPseudo = $result3->fetch(PDO::FETCH_ASSOC);
            if(!$testPseudo){
                $_SESSION['pseudo'] = $pseudo;

                $insertion = "insert into user (email, mdp, pseudo)  values (:email, :mdp, :pseudo)";
                
                $stmt =$connexion->prepare($insertion);

                $stmt -> execute([
                    ':email'=>$_SESSION['email'],
                    ':mdp'=>$_SESSION['mdp'],
                    ':pseudo'=>$pseudo
                ]);

                $_SESSION['estConnecte'] = 1;
                header("Location: index.php");
                exit();
            } else{
                $msgErreur = "Le pseudo est déjà pris, veuillez en sélectionner un autre";
            }
        }
    }
?>

        <main>
            <div>
                <h1>Saisir pseudo</h1>
            
                <form method="post" action="">
                    <h2>Saisir pseudo</h2>
                    
                    <?php showMsgErreur($msgErreur); ?>
                    <input type="text" name="pseudo" placeholder="Pseudo" required><br>
                    <button type="submit">Se connecter</button>
                </form>
            </div>
        </main>

<?php require_once('footer.php') ?>