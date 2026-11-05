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
<<<<<<< HEAD

=======
>>>>>>> 203226a2978d471dd7a8ba941d40811c2a8b16fd
?>