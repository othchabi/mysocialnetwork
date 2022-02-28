<?php

include_once('Loginclass.php');
include_once('query.php');

include_once('fonction-post.php');
include_once('fonction-commentaire.php');


 $idvisite=est_co();

 $pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];
 if($_GET['pseudo'] != $pseudoco){
        Die("action impossible !");
}

$filactualite=False;

if ($idvisite)
{
    $userid=est_co();

    $filactualite=True;
}
else 
 {  echo 'Non connecter';

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
        

        <?php echo "<a href="."'fildactu.php?pseudo=$pseudoco'"."        >Fil d'actualite</a> "  ?>
        <?php echo "<a href="."'profile.php?pseudo=$pseudoco'"."'        >Mon Profile</a> "  ?>

        
        <?php echo "<a href="."'messages.php?pseudo=$pseudoco'"."        >Messages</a> "  ?>
        <?php echo "<a href="."'parametres.php?pseudo=$pseudoco'"."        >Parametres</a> "  ?>

        <?php echo "<a href="."'deconnexion.php?pseudo=$pseudoco'"."        >Deconnexion</a> "  ?>
      
      </ul>
    </nav>
  </header>













<body> <h1 class="filactu" >Mon Fil d'actualité :</h1><div id='test' class="containerpost"> <?php 


 echo afficherpostfil($idvisite);





 ?>
   
 </div>
</body>

</html>