<?php require_once('header.php');
if(isset($_POST['pseudo'])){
    $pseudo = $_POST['pseudo'];
    $query3 = "select * from user where pseudo = ?";
	$result3 = $connexion->prepare($query3);
	$result3->execute([$pseudo]);
    if($result3){
	    $testPseudo = $result3->fetch(PDO::FETCH_ASSOC);
    if(!$testPseudo){
        $_SESSION['pseudo'] = $pseudo;
        $stmt = $connexion->prepare("SELECT MAX(id) FROM user");
        $stmt->execute();
        $nouvelId = $stmt->fetchColumn() + 1;

        $insertion = "insert into user ( email, mdp, pseudo)  values (:email, :mdp, :pseudo)";
        
        $stmt =$connexion->prepare($insertion);

        $stmt -> execute([
            ':email'=>$_SESSION['email'],
            ':mdp'=>$_SESSION['mdp'],
            ':pseudo'=>$pseudo

        ]);
        $_SESSION['estConnecte'] = 1;
        header("Location: index.php");
        exit();
    }
    else{
        $msgErreur = "pseudo déjà pris, veuillez en sélectionner un autre";
    }
    }
}

?>

<main>
    <div>
        <h1>Saisir pseudo</h1>
    </div>

    <form method="post" action="">
        <h2>Saisir pseudo</h2>
        
        <input type="text" name="pseudo" placeholder="Pseudo" required><br>
        <button type="submit">Se connecter</button>
    </form>
    <p><?= isset($msgErreur) ? htmlspecialchars($msgErreur) : '' ?></p>

</main>

<?require_once('footer.php') ?>