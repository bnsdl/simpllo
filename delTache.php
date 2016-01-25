<?php
session_start();
$idTask = $_GET["idTask"];
$idUser = $_SESSION["user"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "DELETE FROM `task` WHERE id=".$idTask;
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
