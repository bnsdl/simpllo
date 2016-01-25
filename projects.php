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
  <div style='width:300px;display:inline-block'>
    <p>Mes projets:</p>
    <?php
    try
    {
      $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
    } catch ( Exception $e ){
      die('Erreur : '.$e->getMessage() );
    }

    $requete = "SELECT * FROM pr WHERE `idUser` =".$idUser." AND `type` = ''";
    $resultats = $connexion->query($requete);
    while ($project = $resultats->fetch() ){
      echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
      echo "<div onclick='joinProject(".$project['id'].")'>".$project['name']."</div>";
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
  <div style='display:inline-block; vertical-align:top'>

    <div id="drops">
      <div id='dropper1' class="dropzone" style='background:rgb(240, 50, 50)'><h3>Prioritaires</h3>
        <?php
        $requete = "SELECT * FROM pr WHERE `idUser` =".$idUser." AND `type` = 'prio'";
        $resultats = $connexion->query($requete);
        while ($project = $resultats->fetch() ){
          echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
          echo "<div onclick='joinProject(".$project['id'].")'>".$project['name']."</div>";
          echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
          echo "</div>";
        }
        $resultats->closeCursor();
        ?>
      </div>
      <div id='dropper2' class="dropzone" style='background:rgb(47, 153, 198)'><h3>Standards</h3>
        <?php
        $requete = "SELECT * FROM pr WHERE `idUser` =".$idUser." AND `type` = 'standard'";
        $resultats = $connexion->query($requete);
        while ($project = $resultats->fetch() ){
          echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
          echo "<div onclick='joinProject(".$project['id'].")'>".$project['name']."</div>";
          echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
          echo "</div>";
        }
        $resultats->closeCursor();
        ?>
      </div>
      <div id='dropper3' class="dropzone" style='background:rgb(50, 240, 103)'><h3>Patchworks</h3>
        <?php
        $requete = "SELECT * FROM pr WHERE `idUser` =".$idUser." AND `type` = 'patchwork'";
        $resultats = $connexion->query($requete);
        while ($project = $resultats->fetch() ){
          echo "<div class='projets' id='".$project['id']."' style='cursor:pointer' draggable='true' ondragstart='event.dataTransfer.setData(\"".'text/plain'."\",null)'>";
          echo "<div onclick='joinProject(".$project['id'].", 1)'>".$project['name']."</div>";
          echo "<button class='btnDelProject' type='button' onclick='delProject(".$project['id'].")'>X</button>";
          echo "</div>";
          echo "</div>";
          echo "<div id='infoPatchwork'>Dans cette partie, vous pouvez classer vos projets afin de les passer en type 'patchwork'. Ce dernier vous permet de déplacer vos listes et de les épingler selon vos envies ! </div>";
        }
        $resultats->closeCursor();
        ?>
      </div>
    </div>
  </body>
  <style media="screen">

  .dropzone {
    width: 200px;
    min-height: 200px;
    border: 1px solid black;
    display: inline-block;
    vertical-align: top;
  }

  .projets {
    border:1px solid black;
    padding: 10px;
    width: 100px;
    margin: 20px;
  }

  #btns {
    display: none;
    margin-left: 20px;
  }

  .btnsPr {
    size: 1.2em;
  }

  #inputProjects {
    margin-left: 20px;
    font-size: 1.2em;
  }

  .btnDelProject {
    float: right;
    margin-top: -20px;
  }

  #drops {
    width:617px;
    margin: 20px auto;
  }

  h3 {
    text-align: center;
  }

  #infoPatchwork {
    position: relative;
    left: 650px;
    bottom: 200px;
    display: none;
    width: 200px;
    border: 1px solid black;
    padding: 10px;
    box-shadow: 0px 0px 2px 1px #656565;
    background: white;
  }

  #dropper3:hover + #infoPatchwork {
    display: inline-block;
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
  for (var i = 1; i <= dropzones.length; i++) {
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
    // console.log(id, idUser);
    var requete = new XMLHttpRequest();
    requete.open("get","delProject.php?idp="+id, true);
    requete.send();
    requete.onload = refreshView;
  }

  function refreshView() {
    window.location.reload();
  }

  function joinProject(id, pw) {
    if (pw) {
      console.log('pw');
      document.location.href="http://localhost/simpllo/patchwork.php?idp="+id;
    }
    else {
      console.log("else");
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
  </script>
  </html>
