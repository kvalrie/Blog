<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Commentaires</title>
</head>
<body>
<a href="index.php">retour vers Gossip</a>

<?php
//connection a ma base de donnée Gossip
try
{
	
	$bdd = new PDO('mysql:host=localhost;dbname=Gossip;charset=utf8', 'root', 'root');
}	
catch(Exception $e)
{
	die('Erreur : '.$e->getMessage());

}
//QUERY POUR LE GOSSIP
//utiliser un where 
$gossipid = $_GET['gossipid'];
 
$resultat_billet=$bdd->query('SELECT * FROM Billets WHERE id="'.$gossipid.'"');

if ($donnee_billet = $resultat_billet->fetch()) {

	echo "un tour";
	echo '<div class="billet"><h3>'.htmlspecialchars($donnee_billet['pseudo']).' nous informe a '.htmlspecialchars($donnee_billet['date_creation']).' que : '.'</h3> <p>'.htmlspecialchars($donnee_billet['contenu']).'</p></div>';
}

$resultat_billet->closeCursor();
?>

<form method="post" class="form-inline">
<div class="form-group">
	<label>Ton pseudo:</label>
	<input type="text" name="auteur" id="auteur" class="form-">
</div>
<div class="form-group">
	<textarea placeholder="ton commentaire ici AUB" name="commentaire"></textarea>
	<input type="submit" name="réagis" value="réagis">
</div>

</form>
<?php
//INSERT COMMENTAIRE
if (isset($_POST)) {

$req = $bdd->prepare('INSERT INTO Commentaires(auteur, id_billet, commentaire) VALUES(?, ?, ?)');
$req->execute(array($_POST['auteur'], $gossipid, $_POST['commentaire']));
$req->closeCursor();

}
//SELECT COMMENTAIRE

$resultat_commentaire=$bdd->query('SELECT * FROM Commentaires WHERE id_billet="'.$gossipid.'" ORDER BY id DESC');

while($donnee_commentaire = $resultat_commentaire->fetch())
{	
	echo '<div class="commentaire">'.'<h3>'.htmlspecialchars($donnee_commentaire['auteur']).' à '.htmlspecialchars($donnee_commentaire['date_commentaire']).'</h3>'.'<p>'.htmlspecialchars($donnee_commentaire['commentaire']).'</p>'.'</div>';

}
$resultat_commentaire->closeCursor();





?>
</body>
</html>