<?php 
require_once('header.php');


if (isset($_POST['email']) && isset($_POST['mdp'])) {

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
        header("Location: index.php");
        exit();
    }
   
}

?>


    <div>
        <h1>Connexion <?php if (!empty($msgErreur)) echo "<p>$msgErreur</p>"; ?></h1>
    </div>

    <form method="post" action="">
        <h2>Connexion</h2>
        
        <input type="text" name="email" placeholder="Mail utilisateur" required><br>
        <input type="text" name="mdp" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>







<?php require_once('footer.php'); ?>