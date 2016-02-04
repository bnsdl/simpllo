<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script src="standard.js"></script>

  <style media="screen">

  #containerFb {
    display: block;
    width: 320px;
    margin: 50px auto;
    padding: 2em;
    border-radius: 1em;
    border: 1px solid black;
  }

  #bienvenue {
    padding: 100px 0;
    font-size: 2em;
    text-align: center;
    width: 100%;
    background: #0981d9;
  }

  #bienvenue p {
    width: 750px;
    margin: 0 auto;
  }

  #feedback {
    width: 100%;
    margin: 10px 0;
    font-size: 1.2em;
    resize: none;
  }

  #bouton{
    margin-left: 250px;
  }

  #label {
    width: 200px;
    font-size: 1.2em;
    text-align: inherit;
    border-bottom: 1px solid black;
  }

  #message {
    width: 300px;
    margin-left: 30px;
    position: relative;
    bottom: 250px;
  }

  #text {
    font-weight: bold;
  }

  #image {
    background: url('check.png');
    background-size: contain;
    width: 50px;
    height: 50px;
    display: none;
    margin: 20px auto;
  }


  </style>
  <title>Feedback Simpllo</title>
</head>
<body>
  <?php
  include 'header.php';
  $idUser = $_SESSION['user'];
  echo "<div id='bienvenue'><p>Une idée, un retour ou n'importe quoi à soumettre ? C'est par ici !</p></div>"
  ?>
  <form id="containerFb">
    <p >
      <label id="label" for="feedback"><b>Votre commentaire:</b></label>
      <textarea id="feedback" rows="5" maxlength="255" name='content'></textarea>
    </p>
    <button id="bouton" type="button" onclick="send()">Envoi</button>
  </form>
  <div id="message">
    <div id="text"></div>
    <div id="image"></div>
  </div>
</body>

<script type="text/javascript">

var text = document.getElementById("text");
var image = document.getElementById("image");

function send(){
  var fb = document.getElementById('feedback');
  requete.open("get", "sendFb.php?content="+fb.value,true);
  requete.send();
  requete.onload = modifText;
  fb.value = "";
}

function modifText() {
  var data = JSON.parse(this.responseText);
  if (data.reponse === "1" ){
    text.style.color = "#3ca231";
    text.textContent = "Votre réponse a bien été prise en compte, merci de m'aider à développer cette application !";
    image.style.display = "block";
  }
  else {
    text.style.color = "red";
    text.textContent = "Vous n'avez rien envoyé...";
  }
}

</script>

</html>
