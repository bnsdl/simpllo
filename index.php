<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login Simpllo</title>
</head>
<body>
  <?php

  include 'header.php';
  echo "<p id='bienvenue'>Bienvenue sur Simpllo, le gestionnaire de projets !</p>"
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
  margin: 50px auto;
  font-size: 2em;
  text-align: center;
  width: 800px;
}

#header {
  display: none;
}


#inscription {
  text-align: center;
}


</style>

</html>
