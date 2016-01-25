<?php

$pwd = $_POST["pwd"];
$log = $_POST["login"];

try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

$requete = "SELECT * FROM users WHERE `pseudo`= '".$log."'";
$resultats = $connexion->query($requete);
$user = $resultats->fetch();


if (($log != null)&&($log == $user['pseudo']))  {
  if ($user['pwd'] == $pwd){

    session_start();
    $_SESSION['user'] = $user['id'];

    header("Location: projects.php");

  }
  else {
    header("Location: index.php?error=1");
  }
}
else {
  header("Location: index.php?error=1");
}

$resultats->closeCursor();
?>
