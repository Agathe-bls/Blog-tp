<?php 
require_once('header.php');
require_once('pdo.php');
if (isset($_POST['email']) && isset($_POST['mdp'])) {
    
    $msgErreur = "test";

    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $result1 = $connexion->prepare("select * from user where email = ? AND mdp = ?");
    $result1->execute([$email, $mdp]);
    $user = $result1->fetch(PDO::FETCH_ASSOC);
    
    if($user){
        $_SESSION['estConnecte'] = 1;
        header("Location: index.php");
        $msgErreur = "connexion réussi";
        exit();
    }

    $testEmail = checkMailUser($email);

    if(!$testEmail)
        $stmt = $connexion->prepare("SELECT MAX(id) FROM user");
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
            ':pseudo'=>$nouvelId+1

        ]);
        header("Location: index.php");
        exit();
    }

?>


    <div>
        <h1>Connexion <?php if (!empty($msgErreur)) echo "<p>$msgErreur</p>"; ?></h1>
    </div>

    <form method="post" action="">
        <h2>Connexion <?php echo var_dump($_SESSION['estConnecte']); ?></h2>
        
        <input type="text" name="email" placeholder="Mail utilisateur" required><br>
        <input type="text" name="mdp" placeholder="Mot de passe" required><br>
        <button type="submit">Se connecter</button>
    </form>
    



<?php require_once('footer.php'); ?>