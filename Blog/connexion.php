<?php 
require_once('header.php');
require_once('pdo.php');
$estConnecte = $_SESSION['estConnecte'];    
if (isset($_POST['email']) && isset($_POST['mdp'])) {
    var_dump($nouvelId);
    $msgErreur = "test";
    $estConnecte = 1;

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];


    $query1 = "select * from user where email = ? AND mdp = ?";
    $result1 = $connexion->prepare($query1);
    $result1->execute([$email, $mdp]);
    $user = $result1->fetch(PDO::FETCH_ASSOC);
    
    if($user){
        $estConnecte = 1;
        header("Location: index.php");
        $msgErreur = "connexion réussi";
        exit();
    }
    

    else{
        $msgErreur = "connexion impossible";
    }
    $msgErreur = "connexion non reussi";

    $query2 = "select * from user where email = ?";
    $result2 = $connexion->prepare($query2);
    $result2->execute([$email]);
    $testEmail = $result2->fetch(PDO::FETCH_ASSOC);

    if($testEmail)
        $stmt = $connexion->prepare("SELECT MAX(id) FROM ma_table");
        if(!$stmt){
            $nouvelId=$connexion->lastInsertId()+1;
            $msgErreur = "table vide";
        }
        else{
            $stmt->execute();
            $nouvelId = $stmt->fetchColumn() + 1;
        }

        $insertion = "insert into user (id, email, mdp, pseudo)  values (:id, :email, :mdp, :pseudo)";
        
        $stmt =$connexion->prepare($insertion);
        
        echo "<p>$nouvelId</p>";

        $stmt -> execute([
            ':id'=>$nouvelId,
            ':email'=>$email,
            ':mdp'=>$mdp,
            ':pseudo'=>"aaa"

        ]);

        header("Location: affichageArticle.php");
        exit();
    }

?>


    <div>
        <h1>Connexion<?php if (!empty($msgErreur)) echo "<p>$msgErreur</p>"; ?></h1>
    </div>

    <form method="post" action="">
        <h2>Connexion</h2>
        
        <input type="text" name="email" placeholder="Mail utilisateur" required><br>
        <input type="text" name="mdp" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    



<?php require_once('footer.php'); ?>