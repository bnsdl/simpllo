
<html>

<body onclick="hideMenu()">


  <header id="header">
    <ul>
      <?php

      // vérifie que la session est active sinon renvoie à l'index

      echo "<li style='cursor:pointer; padding:7px' id='home'>";

      if (isset($_SESSION['user'])){
        echo "<a onclick='redirect(".$_SESSION['user'].")'>";
      }
      else {
        echo "<a onclick='redirect()'>";
      }

      echo "Simpllo</a></li>";

      //afficher le nom de l'utilisateur dans le header sur la page projects.php
      
      try
      {
        $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
      } catch ( Exception $e ){
        die('Erreur : '.$e->getMessage() );
      }

      if ($_SERVER['PHP_SELF'] === '/simpllo/projects.php'){
        // session_start();

        $requete = "SELECT * FROM users WHERE `id` = '".$_SESSION['user']."'";
        $resultats = $connexion->query($requete);
        $user = $resultats->fetch();
        echo "<li id='hi'>Bienvenue ".$user['prenom']." !</li>";
      }

      // afficher un input d'échéance dans les projets sur les pages tables.php si echeance n'est pas encore définie

      if ($_SERVER['PHP_SELF'] === '/simpllo/tables.php'){

        $requete = "SELECT * FROM pr WHERE `id` = '".$_GET['idp']."'";
        $resultats = $connexion->query($requete);
        $project = $resultats->fetch();

        if ($project['echeance'] !== '0000-00-00'){

          $date = new Datetime();
          $date = $date->format('Y-m-d');
          $echeance = date('Y-m-d', strtotime($project['echeance']));
          $restant = (strtotime($echeance) - strtotime($date))/(24*3600);
          echo "<li style='font-size:18px'> Il vous reste <b>".$restant." jours </b>pour terminer ce projet !</li>";

        }
        else {
          echo "<li><label id='echeance' for='name'>Date d'échéance du projet:</label><input id='date' type='date' name='date' onkeyup='onKeyPressedDate(event)'></li>";
        }
      }
      ?>
      <li class='right'>Notif</li>
      <li class='right menu' onclick="showMenu()"  style='cursor:pointer'>Mon compte</li>
      <div id="menu" class="menu">
        <ul>
          <li><p><a href="infosPerso.php">Informations</a></p></li>
          <li><p>Paramètres</p></li>
          <li><p><a href="feedback.php">Feedback</a></p></li>
          <li><p><a href="logout.php">Se déconnecter</a></p></li>
        </ul>
      </div>
    </ul>
  </header>


</body>
<style media="screen">

* {
  margin: 0;
  padding: 0;
  font-family: helvetica;
}

#home {
  font-size: 1.5em;
}

#hi {
  margin-left: 30%;
  font-size: 1.5em;
}

header{
  border: 1px solid black;
  padding: 20px 10px;
  background: rgb(125, 214, 244);
}

ul {
  list-style-type: none;
}

li{
  display: inline;
  margin-right: 20px;
}

li b {
  color: red;
}

.right {
  float: right;
  font-size: 1.1em;
}


#menu {
  display: none;
  text-align: center;
  border: 1px solid black;
  border-radius: 3px;
  width: 120px;
  position: absolute;
  top: 80px;
  right: 60px;
  box-shadow: 0px 0px 5px 2px #656565;
  padding: 20px 10px 10px 10px;
  background: white;
}

#container {
  display: block;
  width: 320px;
  margin: 50px auto;
  padding: 1em;
  border-radius: 1em;
  border: 1px solid black;
}

#container p {
  margin-top: 1em;
}

label {
  display: inline-block;
  width: 90px;
  text-align: right;
}

#echeance {
  width: inherit;
  display: inherit;
  text-align: inherit;
  vertical-align: middle;
  margin-right: 10px;
}

#date {
  vertical-align: middle;
  font-size: 1.1em;
  border: 1px solid black;
}

.inputForm {
  width: 200px;
  height: 30px;
  font-size: 1.2em;
  box-sizing: border-box;
  border: 1px solid #999;
}

#bouton {
  margin-top: 10px;
  margin-left: 225px;
  padding: 4px 10px;
  font-size: 1.2em;
  border: 1px solid black;
  border-radius: 5px;
  background: #2fab09;
  cursor: pointer;
}

#bouton:hover {
  background: #4bc326;
}


</style>
<script type="text/javascript">

var menu = document.getElementById("menu");

function redirect(id){
  if (id != undefined){
    document.location.href="projects.php";
  }
  else {
    document.location.href="index.php";
  }
}

function showMenu(){
  menu.style.display = "block";
}


function hideMenu(){
  // console.log("event ", event.target.className);
  if ((event.target.className == "menu")||(event.target.className == "right menu")){
  }
  else {
    menu.style.display="none";
  }
}


</script>
</html>
