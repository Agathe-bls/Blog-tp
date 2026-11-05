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

	function categorieExist($conn, $idCategorie){
		$stmt = $conn->prepare('SELECT id FROM Categorie WHERE id=?');
		$stmt->execute([$idCategorie]);
		return $stmt->fetch() !== false;
	}

	function titreExist($conn, $titre){
		$stmt = $conn->prepare('SELECT titre FROM Article WHERE titre=?');
		$stmt->execute([$titre]);
		return $stmt->fetch() !== false;
	}

	function saveArticle($conn, $newTitre, $newDescription, $newCategorie, $pseudoCreateur){
		$sql = "INSERT INTO article (titre, description, categorie_id, pseudo) VALUES (?, ?, ?, ?)";
		$st = $conn->prepare($sql);
		$st->bindParam(1, $newTitre);
		$st->bindParam(2, $newDescription);
		$st->bindParam(3, $newCategorie);
		$st->bindParam(4, $pseudoCreateur);
		$st->execute();
	}
?>