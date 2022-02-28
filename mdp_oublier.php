<?php
include('Loginclass.php');



if (isset($_POST['initialisermdp'])) {

        $cstrong = True;
        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
        $email = $_POST['email'];
        $user_id = query('SELECT id FROM utilisateurs WHERE email=:email', array(':email'=>$email))[0]['id'];
        echo $user_id;
        query('INSERT INTO token_mdp VALUES (\'\', :token, :id_utilisateur)', array(':token'=>sha1($token), ':id_utilisateur'=>$user_id));
        echo 'Un email a ete envoyer pour changer votre mot de passe!';
        echo '<br />';
        echo $token; 
}

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
    <title>MySocialNetwork</title>
  </head>
  <body>
    <nav class="navbar bg-dark">
      <h1>
        <a href="index.php"> <i class="fas fa-code"></i> MySocialNetwork </a>
      </h1>
      <ul>
        <li><a href="binomes.php">Binome</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
    <section class="container">
     

      <h1 class="small text-primary">
       Vous Avez oublier votre mot de passe ?
      </h1><br/> <br/>
      <p class="lead"> Entrez votre adresse mail</p>
      <form action="index.php" class="form" method="post">
        <div class="form-group">
          <input type="text" name="email" placeholder="Votre Email" />
        </div>

        <input type="submit"  name="initialisermdp" value="Envoyer" class="btn btn-primary" />
      </form>
      <p class="my-1">
         Vous connecter : <br/>  <a href="login.php">login</a>
      </p>

    </section>
  </body>
</html>