<?php
session_start();
$idUser = $_SESSION["user"];
$idProject = $_GET["idp"];
$type = $_GET['type'];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}
$requete = "UPDATE `projects` SET `type` = '".$type."' WHERE `id` =".$idProject;
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
