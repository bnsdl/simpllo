<?php
session_start();
$date = $_GET["date"];
$idUser = $_SESSION["user"];
$idProject = $_SESSION["project"];
$date = date('Y-m-d', strtotime($date));

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "UPDATE `pr` SET `echeance` = '".$date."' WHERE id='".$idProject."'";
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
