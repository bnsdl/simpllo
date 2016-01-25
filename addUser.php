<?php

$login = $_POST["log"];
$pwd = $_POST["pwd"];
$prenom = $_POST["pr"];
$name = $_POST["name"];
$mail = $_POST["mail"];
$date = new DateTime();
$sqldate = $date->format('Y-m-d');

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

//------ REQUETE CHECK SI PSEUDO DEJA EXISTANT ET SI CHAMPS REMPLIS-----

$requete6 = "SELECT * FROM `users` WHERE `pseudo`='".$login."'";
$resultats6 = $connexion->query($requete6);
$check = $resultats6->fetch();

if (($check['pseudo'] == $login) && ($login != null)){
  $rep = '{"reponse" : "Pseudo déjà existant"}';
}
else if (($mail==null)||($pwd==null)||($login==null)){
  $rep = '{"reponse" : "Champ(s) obligatoire(s) manquant(s)"}';
}
else {
  $rep = '{"reponse" : "1"}';

  //-----REQUETE POUR CREATION USER-----

  $requete = "INSERT INTO `users`(`id`, `pseudo`, `mail`, `prenom`, `nom`, `pwd`, `inscription`) VALUES (NULL,'".$login."','".$mail."','".$prenom."','".$name."','".$pwd."','".$sqldate."')";
  $resultats = $connexion->query($requete);

  $resultats->closeCursor();
}
echo $rep;

$resultats6->closeCursor();

?>
