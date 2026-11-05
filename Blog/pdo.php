<?php
$connexion = null;
	//connexion bdd
	try {
		$connexion = new PDO('mysql:host=localhost;dbname=blog', 'root', '');
	}catch(Exception $e){
		die("Erreur co bdd" . $e->getMessage());
	}

	function getAllCategories($conn){
		$stmt = $conn->query("SELECT id, nom FROM categorie ORDER BY nom");
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	function checkUser($email, $mdp, $connexion){
		$query1 = ;
    	$result1 = $connexion->prepare($query1);
    	$result1->execute([$email, $mdp]);
    	return $result1->fetch(PDO::FETCH_ASSOC);
	}

	function checkMailUser($email){
		$query2 = "select * from user where email = ?";
		$result2 = $connexion->prepare($query2);
		$result2->execute([$email]);
		return $result2->fetch(PDO::FETCH_ASSOC);
	}
?>