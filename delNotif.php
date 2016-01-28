<?php
session_start();
$idUser = $_SESSION["user"];
$idNotif = $_GET["id"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}
$requete = "DELETE FROM `notifications` WHERE `id` =".$idNotif;
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
