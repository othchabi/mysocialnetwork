<?php
include_once('query.php');


if (isset($_POST['Connexion'])) {
        $username = $_POST['pseudo'];
        $password = $_POST['mdp'];

        if (query('SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo', array(':pseudo'=>$username))) { 

                if (password_verify($password,query('SELECT mdp FROM utilisateurs WHERE pseudo=:pseudo', array(':pseudo'=>$username))[0]['mdp'])) {
                        echo 'Connexion reussie !';


                $cstrong=True;

                $token= bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                $id=query('SELECT id from utilisateurs  WHERE pseudo=:pseudo',array(':pseudo'=>$username))[0]['id'];
                query('INSERT INTO token_connexion VALUES (\'\',:token,:id_utilisateur)',array(':token'=>sha1($token),':id_utilisateur'=>$id));	


                setcookie("SNID",$token,time()+ 60*60*24*7,'/',NULL,NULL,True);
                setcookie("SNID_",'1',time()+ 60*60*24*3,'/',NULL,NULL,True);
 
                header('Location: profile.php?pseudo='.$username);




                } else {
                        echo 'Mot de passe incorrect!';
                }

        } else {
                echo 'Utilisateurs non inscrit !';
        }

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
        <a href="index.php">  MySocialNetwork </a>
      </h1>
      <ul>
        <li><a href="binomes.php">Binome</a></li>
        <li><a href="Inscription.php">Inscription</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
    <section class="container">
     

      <h1 class="large text-primary">
        login
      </h1>
      <p class="lead"><i class="fas fa-user"></i> Login</p>
      <form  class="form" method="post">
        <div class="form-group">
          <input type="text" name="pseudo" placeholder="Nom utilisateur" />
        </div>
        <div class="form-group">
          <input type="password" name="mdp" placeholder="Mot de passe" />
        </div>
        <input type="submit"  name="Connexion" value="Login" class="btn btn-primary" />
      </form>
      <p class="my-1">
        Vous n'avez pas de compte ? <a href="Inscription.php">Inscription</a>
      </p>
            <p class="my-1">
        Vous avez oubliez votre mot de passe ? <a href="mdp_oublier.php">Cliquez ici</a>
      </p>
    </section>
  </body>
</html>