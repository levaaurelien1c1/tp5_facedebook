<?php
session_start();
include("../divers/connexion.php");
include("../divers/balises.php");

if(!isset($_SESSION['id'])) {
	// On n'est pas connecté, il faut retourner à la pgae de login
	header("Location:login.php");
}
else 
{
// D'abord il faut être sur que l'on est ni ami, ni en attente, ni banni
// La requête : SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR  (idUtilisateur1=? AND idUtilisateur2=?)
// Le premier paramètre $_SESSION['id']
// Le second parametre de la requete est le $_POST['id'] 
// Le troisième parametre de la requete est le $_POST['id'] 
// Le quatrième paramètre $_SESSION['id']
// Si il y a une réponse il n'y a rien à faire.
	if(isset($_POST["id"])) 
	{
		$sql = "SELECT * FROM lien WHERE (idUtilisateur1=? AND idUtilisateur2=?) OR  (idUtilisateur1=? AND idUtilisateur2=?)";
		$query = $pdo->prepare($sql);
		$query->execute(array($_SESSION["id"],$_POST["id"], $_POST["id"], $_SESSION["id"]));
		
		if(!$query->fetch()) 
		{
			// La requete de demande de creation amitie : INSERT INTO lien VALUES(?,?,"attente");
// Le premier parametre de la requête est le SESSION['id'] : celui qui a demandé l'amitié
// Le second parametre de la requete est le $_POST['id'] 

			$sql = 'INSERT INTO lien VALUES(?,?,"attente")';
			$query = $pdo->prepare($sql);
			$query->execute(array($_SESSION["id"],$_POST["id"]));
		}
	}
}





// A la fin on retourne à la page d'amitié : 
header("Location:../affichage/login.php");
?>