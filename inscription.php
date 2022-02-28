<?php
include_once('query.php');




if (isset($_POST['creecompte'])) {

        $username = $_POST['pseudo'];
        $password = $_POST['mdp'];
        $email = $_POST['email'];
        
  
if (!query('SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo', array(':pseudo'=>$username)))
 {

     if (strlen($username) >= 3 && strlen($username) <= 32){

           if (preg_match('/[a-zA-Z0-9_]+/', $username)){

                  if (strlen($password) >= 6 && strlen($password) <= 60){

                         if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                         	 

                               if (!query('SELECT email FROM utilisateurs WHERE email=:email', array(':email'=>$email))){

                                        query('INSERT INTO utilisateurs VALUES (\'\', :username, :password, :email,:photo_profil,:bio)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT), ':email'=>$email,':photo_profil'=>"image/defaut.png",':bio'=>''));
                                        echo ("Inscription reussie !");



                                        } 
                                else { echo 'Email deja utilise';}}

                             else {
                            echo 'Email non valide!';
                             }
                         } 

                         else {
                            echo 'Mot de passe non valide !';
                        }
                        } else {
                                echo 'Pseudo non valide';
                        }
                } else {
                        echo 'Pseudo non valide';
                }

        } else {
                echo 'utilisateur déja inscrit!';
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
    <title>Bienvenue a MySocialNetwork</title>
  </head>
  <body>
    <nav class="navbar bg-dark">
      <h1>
        <a href="index.php">  MySocialNetwork </a>
      </h1>
      <ul>
        <li><a href="binomes.php">Binome</a></li>
        <li><a href="inscription.php">Inscription</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
    <section class="container">
      <h1 class="large text-primary">
        Inscription
      </h1>
      <p class="lead"><i class="fas fa-user"></i>  Cree votre compte</p>
      <form  class="form" method='post'>
        <div class="form-group">
          <input type="text" name='pseudo' placeholder="Nom utilisateur" required />
        </div>
        <div class="form-group">
          <input type="email" name='email' placeholder="Adresse Email" />
          <small class="form-text">
             
          </small>
        </div>
        <div class="form-group">
          <input type="password"  name='mdp'  placeholder="Mot de passe" minlength="6" />
        </div>

        <input type="submit"  name='creecompte' value="Inscription" class="btn btn-primary" />
      </form>
      <p class="my-1">
        Vous avez deja un compte ? <a href="login.php">Login</a>
      </p>
    </section>
  </body>
</html>



