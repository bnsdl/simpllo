<?php
session_start();
$idUser = $_SESSION["user"];
$idProject = $_SESSION["project"];
$idTask = $_GET["idTask"];
$checked = $_GET["checked"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}
$requete = "UPDATE `tasks` SET `checked` = '".$checked."' WHERE `id` =".$idTask;
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
