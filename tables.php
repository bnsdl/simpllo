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
  <link type="text/css" rel="stylesheet" href="standard.css"/>
<title>Simpllo</title>
</head>
<body>
  <?php

  include 'header.php';
  $idUser = $_SESSION['user'];
  $idProject = $_GET['idp'];
  $_SESSION['project'] = $idProject;

  try
  {
    $connexion = new PDO('mysql:host=localhost; dbname=simpllo;charset=utf8', 'root', 'root');
  } catch ( Exception $e ){
    die('Erreur : '.$e->getMessage() );
  }

  $requete = "SELECT * FROM lists WHERE `idProjet` =".$idProject." AND `idUser`=".$idUser;
  $resultats = $connexion->query($requete);
  while ($tableName = $resultats->fetch() ){

    //--------ECRIRE NOM DE LISTE -------

    echo "<div class='card'>";
    echo "<h2>".$tableName['name']."</h2>";
    echo "<button class='btnDelTable' type='button' id=".$tableName['id']." onclick='delTable(id)'>X</button>";

    $requete2 = "SELECT * FROM tasks WHERE `idList` = ".$tableName['id'];
    $resultats2 = $connexion->query($requete2);
    while ($tacheName = $resultats2->fetch() ){

      //----- ECRIRE LES TACHES------

      echo "<div id='".$tacheName['id']." ".$tableName['id']."' onmouseover='showBtnTache(id)' onmouseout='hideBtnTache(id)' >";
      if ($tacheName['checked'] == 1){
        echo "- <input type='checkbox' id='check".$tacheName['id']."' checked onclick='checking(".$tacheName['id'].")'> ";
      }
      else {
        echo "- <input type='checkbox' id='check".$tacheName['id']."' onclick='checking(".$tacheName['id'].")'> ";
      }
      echo $tacheName['content'];
      echo "<button type='button' class='btnDelTache' id='btn".$tacheName['id']." ".$tableName['id']."' onclick='delTache(id)'>-</button>";
      echo "</div>";
    }
    $resultats2->closeCursor();

    //-----INPUT POUR TACHES------

    echo "<input  onkeyup='onKeyPressedTask(event, id)' class='inputTaches' id='input".$tableName['id']."' placeholder='ajout tâche'></input>";
    // echo "<div class='btns' id='btnsinput".$tableName['id']."'>";
    // echo "<button id='".$tableName['id']."' type='button' onclick='updateTache(id)' >Créer</button>";
    // echo "</div>";
    echo "</div>";
  }
  $resultats->closeCursor();

  ?>

  <!-- INPUT POUR LES LISTES -->

  <div id="list">
    <input  onkeyup='onKeyPressedList(event)' id="inputOrigin" placeholder="ajout liste"></input>
    <!-- <div id="btns">
      <button id="btnSaveList" type="button" onclick="updateTable()">Enregistrer</button>
      <button type="button" id="btnDelete" onclick="abort()">X</button>
    </div> -->
  </div>

</body>
<script type="text/javascript">

// var requete = new XMLHttpRequest();
var btns = document.getElementById("btns");

function showBtnTache(id){
  var btn = document.getElementById("btn"+id);
  btn.style.display = "inline-block";
  // console.log("id", id);
}

function hideBtnTache(id){
  var btn = document.getElementById("btn"+id);
  btn.style.display = "none";
}

function showBtn(e, event) {
  if (e) {
    // console.log("id", e);
    var inputClass = document.getElementsByClassName("btns");
    for (var i = 0; i < inputClass.length ; i++){
      inputClass[i].style.display="none";
      // console.log("boucle");
    }
    // console.log(inputClass[0]);
    var btnsTaches = document.getElementById("btns"+e);
    btnsTaches.style.display = "inline-block";
  }
  else {
    // console.log("else");
    btns.style.display = "inline-block";
  }
}

function abort() {
  btns.style.display = "none";
}

//-----onKeyPressed list------

function onKeyPressedList(e){
  // console.log(e.keyCode);
  if (e.keyCode === 13){
    // console.log(idModif);
    updateTable();
  }
}

//----- MODIF LISTES--------

function updateTable() {
  var tableName = document.getElementById("inputOrigin");
  requete.open("get", "createTable.php?tableName="+tableName.value,true);
  requete.send();
  requete.onload = refreshView;
  // console.log(tableName.value);
}

function delTable(id) {
  requete.open("get", "delTable.php?idli="+id,true);
  requete.send();
  requete.onload = refreshView;
}

//------ onKeyPressed input taches

function onKeyPressedTask(e, id){
  // console.log(e.keyCode);
  if (e.keyCode === 13){
    var idModif = id.substring(5);
    // console.log(idModif);
    updateTache(idModif);
  }
}

//------ MODIF TACHES

function updateTache(id) {

  var tacheName = document.getElementById("input"+id);
  requete.open("get", "createTache.php?content="+tacheName.value+"&idli="+id,true);
  requete.send();
  requete.onload = refreshView;
  // console.log("nom tache", tacheName.value);
  // console.log("id", id);
}

function delTache(idDouble){
  var id = idDouble.substring(3, idDouble.indexOf(' '));
  // var idList = idDouble.substring(idDouble.indexOf(' ')+1);
  requete.open("get", "delTache.php?idTask="+id,true);
  requete.send();
  requete.onload = refreshView;
  // console.log("id", id, idList);
}

// ------ CHECKBOX-------

function checking(id){
  var check = document.getElementById("check"+id);
  if (check.checked){
    requete.open("get", "checked.php?checked=1&idTask="+id,true);
    requete.send();
  }
  else {
    requete.open("get", "checked.php?checked=0&idTask="+id ,true);
    requete.send();
  }
}


</script>
</html>
