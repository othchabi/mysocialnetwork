
<?php 

include_once('query.php');
$idcom=connexpdo('myparam');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
      integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
      crossorigin="anonymous"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Raleway"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="css/style.min.css" />
    <title>Acceuil</title>
  </head>
  <body>
    <nav class="navbar bg-dark">
      <h1>
        <a href="index.php"> MySocialNetwork </a>
      </h1>
      <ul>
        <li><a href="binomes.php">Binome</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
    <section class="landing">
      <div class="dark-overlay">
        <div class="landing-inner">
          <h1 class="x-large">MySocialNetwork</h1>
          <p class="lead">
            Projet 2021 En Programation web
          </p>
          <div class="buttons">
            <a href="inscription.php" class="btn btn-primary">Inscription</a>
            <a href="login.php" class="btn btn">Login</a>
          </div>
        </div>
      </div>
    </section>
  </body>
</html>
