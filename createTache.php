<?php
session_start();
$idli = $_GET["idli"];
$idUser = $_SESSION["user"];
$idProject = $_SESSION["project"];
$tacheName = $_GET["content"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "INSERT INTO `tasks` (`id`,`content`,`idList`, `idProjet`, `idUser`) VALUES (NULL,'$tacheName', '$idli', '$idProject', '$idUser')";
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
