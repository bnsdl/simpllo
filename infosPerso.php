<?php
session_start();
if (isset($_SESSION['user']) === false ){
  header("Location: index.php");
}

$idUser = $_SESSION['user'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Informations personnelles</title>
</head>
<body>
  <?php

  include 'header.php';

  try
  {
    $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
  } catch ( Exception $e ){
    die('Erreur : '.$e->getMessage() );
  }

  $requete = "SELECT * FROM users WHERE `id`= '".$idUser."'";
  $resultats = $connexion->query($requete);
  $user = $resultats->fetch();


  ?>
  <div id="container">
    <div id="title">
      Modifier vos informations personnelles:
    </div>
    <p id="login">
      <label for="champLogin">Login</label>
      <?php echo "<input id='champLogin' class='inputForm' value='".$user['pseudo']."'></input>"?>
      <button type="button" onclick="modification(1)" class="btnInfos">modifier</button>
    </p>
    <p id="mail">
      <label for="champMail">Mail</label>
      <?php echo "<input id='champMail' class='inputForm' value='".$user['mail']."'></input>"?>
      <button type="button" onclick="modification(2)" class="btnInfos">modifier</button>
    </p>
    <p id="prenom">
      <label for="champPr">Prenom</label>
      <?php echo "<input id='champPr' class='inputForm' value='".$user['prenom']."'></input>"?>
      <button type="button" onclick="modification(3)" class="btnInfos">modifier</button>
    </p>
    <p id="name">
      <label for="champName">Nom</label>
      <?php echo "<input id='champName' class='inputForm' value='".$user['nom']."'></input>"?>
      <button type="button" onclick="modification(4)" class="btnInfos">modifier</button>
    </p>
    <p id="pwd">
      <label for="champPwd">Mot de passe actuel</label>
      <input type="password" id="champPwd" class="inputForm"></input>
    </p>
    <p id="pwd2">
      <label for="champPwd2">Nouveau mot de passe</label>
      <input type="password" id="champPwd2" class="inputForm"></input>
    </p>
    <p id="pwd3">
      <label for="champPwd3">Confirmer mot de passe</label>
      <input type="password" id="champPwd3" class="inputForm"></input>
      <button type="button" onclick="modification(5)" class="btnInfos">modifier</button>
    </p>
    <!-- <button id="bouton" type="button" onclick="inscription()">Modifier</button> -->
    <p id="textError"></p>
  </div>
  <?php
  $resultats->closeCursor();

  ?>

</body>
<style media="screen">


label {
  width: 140px;
}

#container {
  width: 500px;
  padding: 0px;
}

#title {
  padding: 20px;
  text-align: center;
  border-top-left-radius: 15px;
  border-top-right-radius: 15px;
  border-bottom: 1px solid black;
  font-size: 1.2em;
  background: #0981d9;
}

#champPwd2 {
  vertical-align: super;
}

#champ {
  display: inline-block;
}

#textError {
  height:30px;
  color: red;
}

.btnInfos {
  background: #f59740;
  border: 1px solid black;
  border-radius: 10px;
  cursor: cell;
  padding: 5px;
  color: rgb(57, 58, 68);
  font-size: 1.1em;
  margin-left: 20px;
}

</style>
<script type="text/javascript">

var text = document.getElementById("textError");

function modification(numChamp){
  text.textContent ="";
  var login = document.getElementById("champLogin").value;
  var mail = document.getElementById("champMail").value;
  var prenom = document.getElementById("champPr").value;
  var name = document.getElementById("champName").value;
  var ancientPwd = document.getElementById("champPwd").value;
  var newPwd = document.getElementById("champPwd2").value;
  var newPwd2 = document.getElementById("champPwd3").value;
  var requete = new XMLHttpRequest();
  requete.open('post', 'modifInfos.php', true);
  requete.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  if (numChamp == 1) {
    console.log(1);
    requete.send("log=" + login + "&ancientPwd=" + ancientPwd);
    requete.onload = modifText;
  }
  else if (numChamp == 2) {
    requete.send("ancientPwd=" + ancientPwd+ "&mail="+mail);
    requete.onload = modifText;
  }
  else if (numChamp == 3) {
    requete.send("ancientPwd=" + ancientPwd+ "&pr="+prenom);
    requete.onload = modifText;
  }
  else if (numChamp == 4) {
    requete.send("ancientPwd=" + ancientPwd+ "&name="+name);
    requete.onload = modifText;
  }
  else if ((numChamp == 5) && (newPwd != null) &&(newPwd == newPwd2)) {
    requete.send("ancientPwd=" + ancientPwd+ "&newPwd=" + newPwd);
    requete.onload = modifText;
  }
  else {
    text.textContent = "Erreur mots de passe";
  }
}

function modifText() {
  var data = JSON.parse(this.responseText);
  text.textContent = data.reponse;
}


</script>
</html>
