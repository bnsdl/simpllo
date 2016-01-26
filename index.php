<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Simpllo</title>
</head>
<body>
  <?php

  include 'header.php';
  echo "<div id='bienvenue'><p>Bienvenue sur Simpllo, le gestionnaire de projets !</p></div>"
  ?>
  <form action="login.php" method="post" id="container">
    <p id="login">
      <label for="champLogin">Identifiant</label>
      <input id="champLogin" class="inputForm" name="login"></input>
    </p>
    <p id="pwd">
      <label for="champPwd">Password</label>
      <input id="champPwd" type="password" class="inputForm" name="pwd"></input>
    </p>
    <button id="bouton" type="submit">Login</button>
    <p id="inscription"><a href="inscription.php">Pas encore de compte? Inscription par ici</a></p>
    <p id="textError">
      <?php
      if (isset($_GET['error'])){
        echo "Identifiant ou mot de passe incorrect";
      }
      ?>
    </p>
  </form>
</body>
<style media="screen">

#bienvenue {
  /*margin: 50px auto;*/
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

#header {
  display: none;
}


#inscription {
  margin-top: -10px;
  text-align: center;
}


</style>

</html>
