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

	function supprimerCommentaire($id, $conn){
		$sql = "delete from commentaire where id = ?";
		$st = $conn->prepare($sql);
		$st->execute([$id]);
	}

	function supprArticle($id, $conn){
		$sql = "delete from article where id = ?";	
		$st = $conn->prepare($sql);
		$st->execute([$id]);
	}

	//Fonction qui vérifie que l'utilisateur actuel est toujours en bdd et qu'il est bien connecté 
	function verifConnexionUtilisateur($connexion) {
		if (!isset($_SESSION['estConnecte']) || $_SESSION['estConnecte'] != 1) {
			$_SESSION['msgErreurConnexion'] = "Vous n'êtes plus connecté(e), veuillez vous reconnecter !";
			header("Location: connexion.php");
			exit();
		}

		if (empty($_SESSION['pseudo'])) {
			$_SESSION=[];
			$_SESSION['msgErreurConnexion'] = "Vous n'êtes plus connecté(e), votre pseudo est manquant, veuillez vous reconnecter !";
			header("Location: connexion.php");
			exit();
		}

		$stmt = $connexion->prepare("SELECT id FROM user WHERE pseudo = ?");
		$stmt->execute([$_SESSION['pseudo']]);
		if (!$stmt->fetch()) {
			$_SESSION=[];
			$_SESSION['msgErreurConnexion'] = "Vous n'êtes plus connecté(e), votre compte n'existe plus, veuillez vous reconnecter !";
			header("Location: connexion.php");
			exit();
		}
	}
?>