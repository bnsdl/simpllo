<?php
session_start();


$aPwd = $_POST["ancientPwd"];

$idUser = $_SESSION['user'];

//---POUR LE MOMENT IL N'EST POSSIBLE QUE DE MODIFIER UNE INFO A LA FOIS---
try
{
  $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
} catch ( Exception $e ){
  die('Erreur : '.$e->getMessage() );
}

//------ REQUETE CHECK SI LOGIN ET ANCIEN PWD CORRESPONDENT-------

$requete = "SELECT * FROM `users` WHERE `id`='".$idUser."'";
$resultats = $connexion->query($requete);
$check = $resultats->fetch();

if ($check['pwd'] != crypt("$aPwd", "$2a$")) {
  $rep = '{"reponse" : "Mot de passe actuel incorrect"}';
}

else {

  if ((isset($_POST['newPwd']))&&($_POST['newPwd'] != "")) {
    $newPwd = crypt($_POST["newPwd"], "$2a$");

    //------ REQUETE MODIFICATION PWD-------

    $requete2 = "UPDATE `users` SET `pwd` = '$newPwd' WHERE `id` ='".$idUser."'";
    $resultats2 = $connexion->query($requete2);
    $rep = '{"reponse" : "Mot de passe modifié"}';
    $resultats2->closeCursor();
  }
  else if ((isset($_POST['mail']))&&($_POST['mail'] != $check['mail'])){

    $mail = $_POST["mail"];
    //------ REQUETE MODIFICATION MAIL-------

    $requete2 = "UPDATE `users` SET `mail` = '$mail' WHERE `id` ='".$idUser."'";
    $resultats2 = $connexion->query($requete2);
    $rep = '{"reponse" : "Adresse mail modifiée"}';
    $resultats2->closeCursor();

  }
  else if ((isset($_POST['name']))&&($_POST['name'] != $check['nom'])){

    $name = $_POST["name"];
    //------ REQUETE MODIFICATION NOM-------

    $requete2 = "UPDATE `users` SET `nom` = '$name' WHERE `id` ='".$idUser."'";
    $resultats2 = $connexion->query($requete2);
    $rep = '{"reponse" : "Nom modifié"}';
    $resultats2->closeCursor();

  }

  else if ((isset($_POST['pr'])) && ($_POST['pr'] != $check['prenom'])) {

    $prenom = $_POST['pr'];
    //------ REQUETE MODIFICATION PRENOM-------

    $requete2 = "UPDATE `users` SET `prenom` = '".$prenom."' WHERE `id` ='".$idUser."'";
    $resultats2 = $connexion->query($requete2);
    $rep = '{"reponse" : "Prénom modifié"}';
    $resultats2->closeCursor();

  }
  else if ((isset($_POST['log']))&&($_POST['log'] != $check['pseudo'])){
    $login = $_POST['log'];
    //------ REQUETE VERIFICATION PSEUDO DISPO-------

    $requete3 = "SELECT * from `users` WHERE `pseudo` = '".$login."'";
    $resultats3 = $connexion->query($requete3);
    $pseudo = $resultats3->fetch();

    if ($pseudo['pseudo'] == ""){

      //-------- REQUETE MODIFICATION PSEUDO------

      $requete2 = "UPDATE `users` SET `pseudo` = '$login' WHERE `id` ='".$idUser."'";
      $resultats2 = $connexion->query($requete2);
      $rep = '{"reponse" : "Pseudo modifié"}';
      $resultats2->closeCursor();
    }
    else {
      $rep = '{"reponse" : "Ce pseudo n est pas dispo"}';
    }
    $resultats3->closeCursor();
  }
  else {
    $rep = '{"reponse" : "Vous n avez rien changé"}';
  }
}
echo $rep;


$resultats->closeCursor();
