<?php 
require_once('header.php');
require_once('pdo.php');
$estConnecte = $_SESSION['estConnecte'];    
if (isset($_POST['email']) && isset($_POST['mdp'])) {
    $estConnecte = 1;

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $query1 = "select * from user where email = '$email'";
    $result = mysqli_query($connexion, $query1);
    $user = mysqli_fetch_assoc($result);

    $query2 = "select * from user where email = '$email' && mdp = '$mdp'";
    $result2 = mysqli_query($connexion, $query2);
    $mdp = mysqli_fetch_assoc($result2);
    
    if($user){
        if($mdp){
            
            header(affichageArticle.php);
            exit();
        }
        else{
            $estConnecte = 0;
            $msgErreur = 'connexion impossible, veuillez changer le mot de passe ou l email';
        }
    }
    else{
        

        $chercheId = "select max(id) from user";
        $resultat = mysqli_query($connexion, $chercheId);
        $id = mysqli_fetch_assoc($resultat) + 1;

        $insertion = "insert into user (id, email, mdp, pseudo) 
                        values ('$id', '$email', '$mdp', )";
        header(affichageArticle.php);
    }
}
?>


    <div>
        <h1>Connexion</h1>
    </div>

    <form method="post" action="">
        <h2>Connexion</h2>
        
        <input type="text" name="email" placeholder="Mail utilisateur" required><br>
        <input type="text" name="mdp" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <?php if (!empty($msgErreur)) echo "<p>$msgErreur</p>"; ?>



<?php require_once('footer.php'); ?>