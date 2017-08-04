<!DOCTYPE html>
<html lang="en">
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="style.css">
	<meta charset="UTF-8">
	<title>GossipCode</title>
</head>
<body>
<div class="content">
<header>
	<h1>GOSSIP CODE </h1>

	<form method="post" class="form-inline" >
		<div class="form-group">
		<label>Qui es tu ? :</label>
		<input type="text" name="pseudo" id="pseudo" placeholder="Pas ton vrai nom banane" class="form-control">
		</div>
		<div class="form-group">
		<label>Ton info :</label>
		<input type="text" name="contenu" id="contenu" placeholder="éclaires nous" class="form-control">
		</div>
		<input type="submit" class="btn btn-default" name="Balances">
	</form>
</header>
	
<?php

// connection a la base de donnée : 
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host=localhost;dbname=Gossip;charset=utf8', 'root', 'root');
}	
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());

}
//INSERT
 
$req = $bdd->prepare('INSERT INTO Billets(pseudo, contenu) VALUES(?, ?)');
$req->execute(array($_POST['pseudo'], $_POST['contenu']));
$req->closeCursor();

// SELECT
$resultat=$bdd->query('SELECT * FROM Billets ORDER BY id DESC');

while($donnee = $resultat->fetch())
{
	//le ?gossipid=... c'est du GET , tres important 
	echo '<div class="billet"><h3>'.htmlspecialchars($donnee['pseudo']).' nous informe a '.htmlspecialchars($donnee['date_creation']).' que : '.'</h3> <p>'.htmlspecialchars($donnee['contenu']).'</p> <a href="commentaires.php?gossipid='.$donnee['id'].'">Commentaires</a> </div>';
}
$resultat->closeCursor();

	

?>
</div>
</body>
</html>