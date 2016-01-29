<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link type="text/css" rel="stylesheet" href="standard.css"/>
  <script src="standard.js"></script>
  <title>Inscription Simpllo</title>
</head>
<body>
  <?php
  echo "<div id='bienvenue'><p>Vous souhaitez créer un compte ? C'est par ici !</p></div>";
  ?>
  <div id="container">
    <p id="login">
      <label for="champLogin">*Identifiant</label>
      <input id="champLogin" class="inputForm"></input>
    </p>
    <p id="mail">
      <label for="champMail">*Mail</label>
      <input id="champMail" class="inputForm"></input>
    </p>
    <p id="prenom">
      <label for="champPr">Prenom</label>
      <input id="champPr" class="inputForm"></input>
    </p>
    <p id="name">
      <label for="champName">Nom</label>
      <input id="champName" class="inputForm"></input>
    </p>
    <p id="pwd">
      <label for="champPwd">*Mot de passe</label>
      <input type="password" id="champPwd" class="inputForm"></input>
    </p>
    <p id="pwd2">
      <label for="champPwd2">*Confirmer mot de passe</label>
      <input type="password" id="champPwd2" class="inputForm"></input>
    </p>
    <button id="bouton" type="button" onclick="inscription()">Inscription</button>
    <p id="champ">* champs obligatoires</p>
    <p id="errorPwd">erreur mdp incorrect</p>
    <p id="textError"></p>
    <p style="text-align:right"><a href="index.php">Déjà inscrit? Connectez vous par ici</a></p>
  </div>
</body>
<style media="screen">

#bouton {
  margin-left: 235px;
}

#champPwd2 {
  vertical-align: super;
}

#champ {
  display: inline-block;
}

#errorPwd {
  margin-left: 50px;
  color: red;
  display: none;
}

</style>
<script type="text/javascript">

var text = document.getElementById("textError");

function inscription(){
  text.textContent ="";
  var login = document.getElementById("champLogin").value;
  var mail = document.getElementById("champMail").value;
  var prenom = document.getElementById("champPr").value;
  var name = document.getElementById("champName").value;
  var pwd = document.getElementById("champPwd").value;
  var pwd2 = document.getElementById("champPwd2").value;
  var error = document.getElementById("errorPwd");
  if (pwd == pwd2){
    // console.log("chack");
    error.style.display ="none";
    requete.open('post', 'addUser.php', true);
    requete.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    requete.send("log=" + login + "&pwd=" + pwd+ "&mail="+mail+"&pr="+prenom+"&name="+name);
    requete.onload = modifText;
  }
  else {
    error.style.display ="inline-block";
  }
}

function modifText() {
  var data = JSON.parse(this.responseText);
  // console.log(data);
  if (data.reponse == "1"){
    text.style.color="rgb(31, 154, 20)";
    text.textContent = "Utilisateur créé, merci d'utiliser notre site, vous allez être redirigé dans quelques instants.";
    window.setTimeout(function(){document.location.href="http://localhost/simpllo/index.php";}, 3000);
  }
  else {
    text.textContent = data.reponse;
  }
}

</script>
</html>
