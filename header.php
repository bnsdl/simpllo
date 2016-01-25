
<html>

<body onclick="hideMenu()">


  <header id="header">
    <ul>
      <?php

      if (isset($_SESSION['user'])){
        echo "<li style='cursor:pointer; padding:7px' class='home'><a onclick='redirect(".$_SESSION['user'].")'>Simpllo</a>";
      }
      else {
        echo "<li style='cursor:pointer; padding:7px' class='home'><a onclick='redirect()'>Simpllo</a>";
      }

      ?>
    </li>
  <li class='right'>Notif</li>
  <li class='right menu' onclick="showMenu()"  style='cursor:pointer'>Mon compte</li>
  <div id="menu" class="menu">
    <ul>
      <li><p><a href="infosPerso.php">Informations</a></p></li>
      <li><p>Paramètres</p></li>
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

header{
  border: 1px solid black;
  padding: 10px;
  background: rgb(125, 214, 244);
}

ul {
  list-style-type: none;
}

li{
  display: inline;
  margin-right: 20px;
}

.right {
  float: right;
}

.home {
  font-size: 1.5em;
  border: 1px solid black;
  border-radius: 100%;
}

#menu {
  display: none;
  text-align: center;
  border: 1px solid black;
  border-radius: 3px;
  width: 120px;
  position: absolute;
  top: 60px;
  right: 75px;
  box-shadow: 0px 0px 5px 2px #656565;
  padding: 20px 10px 10px 10px;
}

#container {
  display: block;
  width: 320px;
  margin: 100px auto;
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
  background: white;
  cursor: pointer;
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
