<?php
session_start();
$idUser = $_SESSION['user'];
$content = $_GET["content"];

if ((isset($content))&&($content !== "")){

  try
  {
    $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
  } catch ( Exception $e ){
    die('Erreur : '.$e->getMessage() );
  }

    $requete = "INSERT INTO `feedback` (`id`, `idUser`, `content`) VALUES (NULL,'".$idUser."',\"'".$content."'\")";
    $resultats = $connexion->query($requete);

    $resultats->closeCursor();

    $rep = '{"reponse" : "1"}';

}
else {
  $rep = '{"reponse" : "0"}';
}


echo $rep;


?>
