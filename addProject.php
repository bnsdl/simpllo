<?php
session_start();
$projectName = $_GET["name"];
$idUser = $_SESSION["user"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "INSERT INTO `projects` (`id`,`name`, `idUser`) VALUES (NULL,'$projectName', '$idUser')";
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
