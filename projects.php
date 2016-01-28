<?php
session_start();
if (isset($_SESSION['user']) === false ){
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Vos projets</title>
</head>
<body>
  <?php

  include 'header.php';
  $idUser = $_SESSION['user'];

  ?>
  <div id="news">
    <h3>News:</h3>
    <p style='text-align: justify; margin-top:20px'>
      Bienvenue sur mon gestionnaire de tâches Simpllo et merci de l'utiliser ! Le site est actuellement en pleine phase de développement et tout retour me sera utile afin de l'améliorer, alors n'hésitez pas à visiter la rubrique "Feedback" dans l'onglet "Mon compte" si vous rencontrez un problème ou qu'il vous semble qu'une fonctionnalité centrale est manquante.
    </p><br>
    <p style='text-align:center'>Au fur et à mesure que le site évoluera, je tiendrais cette rubrique à jour afin de vous tenir au courant de l'avancée du projet ! Have fun :)
    </p>
  </div>
  <div id='infos'>
  </div>
  <div class="container_flex">

    <div class='dropzone' style="background:#f2a339">
      <h3>Mes projets</h3>
      <?php
      try
      {
        $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
      } catch ( Exception $e ){
        die('Erreur : '.$e->getMessage() );
      }

      //on check les dates d'échéances, si < 7jours, passage en type prio

      $requete = "SELECT * FROM pr WHERE `idUser` =".$idUser;
      $resultats = $connexion->query($requete);

      while ($project = $resultats->fetch()){
        if (($project['echeance'] !== '0000-00-00') && ($project['type'] !== 'prio')){
          $date = new Datetime();
          $date = $date->format('Y-m-d');
          $echeance = date('Y-m-d', strtotime($project['echeance']));
          $restant = (strtotime($echeance) - strtotime($date))/(24*3600);
            if ($restant < 7) {
              $req = "UPDATE `pr` SET `type` = 'prio' WHERE `id` =".$project['id'];
              $res = $connexion->query($req);
              $req = "INSERT INTO `notifications` (`id`, `content`, `idUser`) VALUES (NULL, 'projet ".$project['name']." déplacé en prioritaire', '".$idUser."')";
              $res = $connexion->query($req);
              $res->closeCursor();
            }
        }
      }
      $resultats->closeCursor();



      //gère le contenu de création des projets

      $requete2 = $requete." AND `type` = ''";
      $resultats = $connexion->query($requete2);
      while ($project = $resultats->fetch() ){
        echo "<div class='projets' id='".$project['id']."' onclick='joinProject(".$project['id'].")' style='cursor:pointer' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
        echo "<p class='project_name'>".$project['name']."</p>";
        echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
        echo "</div>";
      }
      $resultats->closeCursor();

      ?>
      <input  onclick="showBtn()" id="inputProjects" onkeyup='onKeyPressedPr(event)' placeholder="Nouveau projet"></input>
      <div id="btns">
        <button type="button" class="btnPr" onclick="addProject()">Enregistrer</button>
        <button type="button" id="btnDelete" class="btnPr" onclick="hideBtn()">X</button>
      </div>
    </div>


    <div id='dropper1' class="dropzone" onmouseover="showInfos(1)" onmouseout="showInfos(4)" style='background:rgb(240, 50, 50)'><h3>Prioritaires</h3>
      <?php

      //gère le contenu du panier 'prio'

      $requete2 = $requete." AND `type` = 'prio'";
      $resultats = $connexion->query($requete2);
      while ($project = $resultats->fetch() ){
        echo "<div class='projets' id='".$project['id']."' style='cursor:pointer'  onclick='joinProject(".$project['id'].")' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
        echo "<p class='project_name'>".$project['name']."</p>";
        echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
        echo "</div>";
      }
      $resultats->closeCursor();
      ?>
    </div>
    <div id='dropper2' class="dropzone" style='background:rgb(47, 153, 198)'><h3>Standards</h3>
      <?php

      //gère le contenu du panier 'standard'

      $requete2 = $requete." AND `type` = 'standard'";
      $resultats = $connexion->query($requete2);
      while ($project = $resultats->fetch() ){
        echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' onclick='joinProject(".$project['id'].")' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
        echo "<p class='project_name' >".$project['name']."</p>";
        echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
        echo "</div>";
      }
      $resultats->closeCursor();
      ?>
    </div>
    <div id='dropper3' onmouseover="showInfos(3)" onmouseout="showInfos(4)" class="dropzone" style='background:rgb(50, 240, 103)'><h3>Patchworks</h3>
      <?php

      //gère le contenu du panier 'patchwork'

      $requete2 = $requete." AND `type` = 'patchwork'";
      $resultats = $connexion->query($requete2);
      while ($project = $resultats->fetch() ){
        echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' onclick='joinProject(".$project['id'].", 1)' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
        echo "<p class='project_name' >".$project['name']."</p>";
        echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
        echo "</div>";
      }
      $resultats->closeCursor();
      echo "</div>";



      ?>
      <!-- </div> -->

    </div>



  </body>
  <style media="screen">

  .container_flex {
    min-height:200px;
    display:flex;
    justify-content:space-around;
    align-items: flex-start;
  }

  .dropzone {
    padding-top: 10px;
    min-height: 200px;
    border: 1px solid black;
    vertical-align: top;
    width:20%;
  }

  .projets {
    position: relative;
    border:1px solid black;
    border-radius: 5px;
    padding: 10px;
    width: 70%;
    /*height: 50px;*/
    margin: 20px auto;
    background: white;
  }

  .project_name {
    /*width: 50px;*/
    display: inline-block;
  }

  #btns {
    display: none;
    margin-left: 20px;
  }

  .btnsPr {
    size: 1.2em;
  }

  #inputProjects {
    width: 80%;
    margin: 10px 8%;
    font-size: 1.2em;
    border: 1px solid black;
    padding: 5px;
  }

  .btnDelProject {
    position: absolute;
    top: 3px;
    right: 5px;
    cursor: pointer;
    display: inline-block;
    background: #f59740;
    border: 1px solid black;
    border-radius: 10px;
    padding: 5px;
    color: rgb(57, 58, 68);
    font-size: 1.1em;
    vertical-align: super;
  }

  h3 {
    text-align: center;
  }

  #infos {
    width: 90%;
    min-height: 40px;
    border: 1px solid black;
    padding: 10px;
    margin:0px auto 20px;
    box-shadow: 0px 0px 2px 1px #656565;
    background: white;
    text-align: center;
    visibility: hidden;
  }

  #news {
    width: 80%;
    border: 1px solid black;
    border-radius: 5px;
    box-shadow: 5px 5px 5px 0px #656565;
    margin:20px auto;
    padding: 10px 30px 20px;
    background: #cbcbcb;
  }

  </style>
  <script>


  var dragged;

  /* events fired on the draggable target */
  document.addEventListener("drag", function( event ) {
  }, false);

  document.addEventListener("dragstart", function( event ) {
    // store a ref. on the dragged elem
    dragged = event.target;
    // make it half transparent
    event.target.style.opacity = .5;
  }, false);

  document.addEventListener("dragend", function( event ) {
    // reset the transparency
    event.target.style.opacity = "";
  }, false);

  /* events fired on the drop targets */
  document.addEventListener("dragover", function( event ) {
    // prevent default to allow drop
    event.preventDefault();
  }, false);

  var dropzones = document.getElementsByClassName("dropzone");
  for (var i = 1; i <= dropzones.length-1; i++) {
    document.getElementById("dropper"+i).addEventListener('drop', function(e) {
      e.preventDefault();
      if ( event.target.className == "dropzone" ) {
        // event.target.style.background = "";
        dragged.parentNode.removeChild( dragged );
        event.target.appendChild( dragged );
        modifType(event.target.id);
        console.log('Vous avez bien déposé votre élément !');
      }
    }, false);
  }

  function showBtn(){
    document.getElementById("btns").style.display = "block";
  }

  function hideBtn() {
    btns.style.display = "none";
  }

  function onKeyPressedPr(e){
    // console.log(e.keyCode);
    if (e.keyCode === 13){
      // console.log(idModif);
      addProject();
    }
  }

  function addProject(){
    var projectName = document.getElementById("inputProjects").value;
    // console.log(idUser);
    var requete = new XMLHttpRequest();
    requete.open("get","addProject.php?name="+projectName, true);
    requete.send();
    requete.onload = refreshView;
  }

  function delProject(id){
    event.stopPropagation();
    // console.log("id: "+id);
    // console.log("event: "+event.target);
    // console.log("2: "+event.currentTarget);
    var requete = new XMLHttpRequest();
    requete.open("get","delProject.php?idp="+id, true);
    requete.send();
    requete.onload = refreshView;
  }

  function refreshView() {
    window.location.reload();
  }

  function joinProject(id, pw) {
    console.log("event: "+event.target);
    if (pw) {
      // console.log('pw');
      document.location.href="http://localhost/simpllo/patchwork.php?idp="+id;
    }
    else {
      // console.log("else");
      document.location.href="http://localhost/simpllo/tables.php?idp="+id;
    }
  }

  function modifType(id) {
    var num = id.charAt(id.length-1);
    // console.log(num);
    // console.log(id);
    if (num == 1){
      //prioritaire
      var requete = new XMLHttpRequest();
      var idp = event.target.lastChild.id;
      requete.open("get","addProjectType.php?type=prio&idp="+idp, true);
      requete.send();
      requete.onload = refreshView;
    }
    else if (num == 2) {
      //standard
      var requete = new XMLHttpRequest();
      var idp = event.target.lastChild.id;
      requete.open("get","addProjectType.php?type=standard&idp="+idp, true);
      requete.send();
      requete.onload = refreshView;
    }
    else if (num == 3) {
      //patchwork
      var requete = new XMLHttpRequest();
      var idp = event.target.lastChild.id;
      requete.open("get","addProjectType.php?type=patchwork&idp="+idp, true);
      requete.send();
      requete.onload = refreshView;
    }
  }

  function showInfos(num){
    var infos = document.getElementById("infos");
    infos.style.visibility = "inherit";
    if (num === 1) {
      infos.style.background = "#df6e6e";
      infos.textContent = "Cette partie regroupe vos projets prioritaires. Si vous avez renseigné une date d'échéance et que celle ci approche, votre projet sera automatiquement déposé ici.";
    }
    if (num === 3) {
      infos.style.background = "#a4ed9b";
      infos.textContent = "Dans cette partie, vous pouvez classer vos projets afin de les passer en type 'patchwork'. Ce dernier vous permet de déplacer et épingler vos listes selon vos envies !";
    }
    if (num === 4) {
      infos.style.visibility = "hidden";
    }

  }
  </script>
  </html>
