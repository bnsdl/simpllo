<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <link type="text/css" rel="stylesheet" href="standard.css"/>
  <style media="screen">

  #bouton {
    margin-left: 275px;
  }

  </style>
  <title>Login Simpllo</title>
</head>
<body>
  <?php
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
    <p id="textError">
      <?php
      if (isset($_GET['error'])){
        echo "Identifiant ou mot de passe incorrect";
      }
      ?>
    </p>
    <p style="text-align: right"><a href="inscription.php">Pas encore de compte? Inscription par ici</a></p>
  </form>
</body>
</html>
