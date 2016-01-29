<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <title></title>
  <script src="standard.js"></script>
  <link type="text/css" rel="stylesheet" href="standard.css"/>
</head>

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

      if ($_SERVER['PHP_SELF'] === '/projects.php'){
        // session_start();

        $requete = "SELECT * FROM `users` WHERE `id` = '".$_SESSION['user']."'";
        $resultats = $connexion->query($requete);
        $user = $resultats->fetch();
        echo "<li id='hi'>Bienvenue ".$user['prenom']." !</li>";
      }

      // afficher un input d'échéance dans les projets sur les pages tables.php si echeance n'est pas encore définie

      if ($_SERVER['PHP_SELF'] === '/tables.php'){

        $requete = "SELECT * FROM `projects` WHERE `id` = '".$_GET['idp']."'";
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
          echo "<li><label id='echeance' for='name'>Date d'échéance du projet:</label><input type='date' id='date' name='date' onkeyup='onKeyPressedDate(event)'></li>";
        }
      }

      ?>
      <li class='right' onclick="showNotif()" style='cursor:pointer' >
        <div id="notif_icone">
          <?php

          //requête pour affichage des notifications si notifications

          $requete = "SELECT COUNT(*) FROM `notifications` WHERE `idUser` = '".$_SESSION['user']."'";
          $resultats = $connexion->query($requete);
          $notif = $resultats->fetch();
          // echo $notif[0];
          // $notif_count = floor(implode($notif)/10);

          if ($notif[0] > 0) {
            echo "<div id='notif_nb'>".$notif[0]."</div>";
          }

          $resultats->closeCursor();
          ?>

        </div>
      </li>
      <div id="notif" >
        <ul class='notif'>
          <?php

          //requête pour affichage du contenu des notifications

          $requete = "SELECT * FROM `notifications` WHERE `idUser` = '".$_SESSION['user']."'";
          $resultats = $connexion->query($requete);
          while ($notif = $resultats->fetch()){
            echo "<li class='notif'>".$notif['content']."<input id='ch".$notif['id']."'type='checkbox'</li><br>";
          }
          $resultats->closeCursor();

          ?>
        </ul>
      </div>
      <li class='right menu' onclick="showMenu()" style='cursor:pointer'>Mon compte</li>
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

<script type="text/javascript">

var menu = document.getElementById("menu");
var notif = document.getElementById("notif");

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

function showNotif(){
  var notif_nb = document.getElementById('notif_nb');
  if (notif_nb != null){
    notif.style.display = "block";
  }
  // console.log(notif_nb);
}

function hideMenu(){
  // console.log("event ", event.target.className);
  if ((event.target.className == "menu")||(event.target.className == "right menu")){
    notif.style.display ="none";
  }
  else if ((event.target.id == "notif_icone")||(event.target.id == "notif")||(event.target.type== "checkbox")){
    menu.style.display="none";
  }
  else {
    menu.style.display="none";
    notif.style.display = "none";
  }
  if (event.target.checked === true) {
    var targetId = event.target.id;
    targetId = targetId.substr(2);
    // console.log(targetId);
    requete.open("get", "delNotif.php?id="+targetId), true;
    requete.send();
  }
}

//-----onKeyPressed date d'échéance------

function onKeyPressedDate(e){
  // console.log(e.keyCode);
  var date = document.getElementById("date");
  if (e.keyCode === 13){
    // console.log(date.value);
    requete.open("get", "addDate.php?date="+date.value,true);
    requete.send();
    requete.onload = refreshView;
  }
}


</script>
</html>
