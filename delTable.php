<?php
session_start();
$idList = $_GET["idli"];
$idUser = $_SESSION["user"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "DELETE FROM `list` WHERE `id`=".$idList;
$resultats = $connexion->query($requete);

$requete2 = "DELETE FROM `task` WHERE `idList` = ".$idList;
$resultats2 = $connexion->query($requete2);
$resultats2->closeCursor();

$resultats->closeCursor();
?>
