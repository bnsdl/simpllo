<?php
session_start();
$tableName = $_GET["tableName"];
$idUser = $_SESSION["user"];
$idProject = $_SESSION["project"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "INSERT INTO `list` (`id`, `name`, `idProjet`, `idUser`) VALUES (NULL, '$tableName', '$idProject', '$idUser')";
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
