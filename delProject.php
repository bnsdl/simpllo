<?php
session_start();
$idProject = $_GET["idp"];
$idUser = $_SESSION["user"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "DELETE FROM `pr` WHERE `id` = ".$idProject;
$resultats = $connexion->query($requete);

$requete2 = "DELETE FROM `list` WHERE `idProjet` = ".$idProject;
$resultats2 = $connexion->query($requete2);
$resultats2->closeCursor();

$requete3 = "DELETE FROM `task` WHERE `idProjet` = ".$idProject;
$resultats3 = $connexion->query($requete3);
$resultats3->closeCursor();

$resultats->closeCursor();
?>
