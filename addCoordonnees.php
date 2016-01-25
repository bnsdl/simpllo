<?php
session_start();
$idUser = $_SESSION["user"];
$idList = $_GET["idli"];
$x = $_GET['x'];
$y = $_GET['y'];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}
$requete = "UPDATE `list` SET `x` = '".$x."', `y` = '".$y."', `position` = 'absolute' WHERE `id` =".$idList;
$resultats = $connexion->query($requete);

$resultats->closeCursor();
?>
