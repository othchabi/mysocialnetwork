<?php

include_once('Loginclass.php');
if (!est_co()) {
        
        header("Location: index.php");
}

//on supprime la table des posts des amis pour le prochaine session 
query('DELETE FROM post_fil',array());


 $idvisite=est_co();

 $pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];

if($_GET['pseudo'] != $pseudoco){
        Die("action impossible !");
}



 if (isset($_POST['confirmer'])) { 

        if (isset($_POST['decopartout'])) {

                query('DELETE FROM token_connexion WHERE id_utilisateur=:id_utilisateur', array(':id_utilisateur'=>est_co()));

        } else {
                if (isset($_COOKIE['SNID'])) {
                        query('DELETE FROM token_connexion WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])));
                }
                setcookie('SNID', '1', time()-3600);
                setcookie('SNID_', '1', time()-3600);
        }

   header("Location: index.php");
}


?>
<html>
  
    <meta charset="UTF-8" />
    
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
      integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf"
      crossorigin="anonymous"
    />

<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,100&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="css/style2.css" />
    <title>MySocialNetwork</title>
  









<header class="topbar">
      
      <?php echo "<a href="."'fildactu.php?pseudo=$pseudoco'"." class='topbar-logo'        >MySocialNetwork</a> "  ?>
        
          

      
    <nav class='topbar_nav'>
    

          

          <a class="topbar-search">
             <?php   



              echo "
        <form class='recherche' action='test2.php'  method='get'>
          <input  type='search' name='rechercher' placeholder='Rechercher'>
          <label class='icon'>
            <button type='submit' ><i class='fas fa-search'></i></button>
          </label></form>"; ?></a>
        

        <?php echo "<a href="."'index.php?pseudo=$pseudoco'"."        >Fil d'actualite</a> "  ?>
        <?php echo "<a href="."'profile.php?pseudo=$pseudoco'"."'        >Mon Profile</a> "  ?>

        
        <?php echo "<a href="."'messages.php?pseudo=$pseudoco'"."        >Messages</a> "  ?>
        <?php echo "<a href="."'parametres.php?pseudo=$pseudoco'"."        >Parametres</a> "  ?>

        <?php echo "<a href="."'deconnexion.php?pseudo=$pseudoco'"."        >Deconnexion</a> "  ?>
      
      </ul>
    </nav>
  </header>
  <body>


<p>Etes vous sur vous voulez vous deconnecter ?</p>
<form  method="post">
        <input type="checkbox" name="decopartout" value="alldevices"> Se deconnecter sur tous les appareils?<br />
        <input type="submit" name="confirmer" value="Confirmer">
</form>
</body>
</html>