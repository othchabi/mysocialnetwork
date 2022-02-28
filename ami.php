

<?php
include_once('query.php');
include_once('Loginclass.php');

$idcom=connexpdo('mysocialnetwork','myparam');


   function requeteami(){

                   $iduser=est_co();


                  if (isset($_POST['accepterre'])){
   
                   


                  query('INSERT INTO ami VALUES (\'\',:id1,:id2)',array(':id1'=>$_GET['idprore'],'id2'=>$iduser));
                  query('DELETE FROM requete_ami WHERE id_envoie=:id1 AND id_recoit=:id2',array(':id1'=>$_GET['idprore'],'id2'=>$iduser));




                  }





                  if (isset($_POST['refuserre'])){



                  query('DELETE FROM requete_ami WHERE id_envoie=:id1 AND id_recoit=:id2',array(':id1'=>$_GET['idprore'],'id2'=>$iduser));

                  	
                  }







                  





                   /*function afficherrequete(){*/
                   

                   $requeteami=(query('SELECT id_envoie FROM requete_ami WHERE id_recoit=:iduser',array('iduser'=>$iduser)));
 
 
                
        
                   foreach($requeteami  as $re){ 

                        $idperso=$re['id_envoie'];
                          

                        $nometphotore=(query('SELECT pseudo,photo_profil,id FROM utilisateurs WHERE id=:idperso',array(':idperso'=>$idperso)))[0];

               
                        echo "<img src='".$nometphotore['photo_profil']."' width=50 ><br/>
                        ".$nometphotore['pseudo']."  vous a envoyer une requete dami <br/>

                                 <form action='ami.php?idprore=".$nometphotore['id']." 'method='post'>
                                
                                 <input type='submit' name='accepterre' value='accepter requete ami'>
                                 <input type='submit' name='refuserre' value='refuser requete ami'>

                                 </form>";




              

                    



                             }
     








}


  function mesamis(){
 
                    





 















  }
?>

<html>
  
    <meta charset="UTF-8" />
    


<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;1,100&display=swap" rel="stylesheet"> 

    <link rel="stylesheet" href="css/style2.css" />
    <title>MySocialNetwork</title>
  









<header class="topbar">
      
        <a class="topbar-logo" href="index.html"> </i> MySocialNetwork </a>
          

      
    <nav class='topbar_nav'>
    

          

          <a class="topbar-search">
          <input  type="search" placeholder="Rechercher">
          <label class="icon">
            <span class="fas fa-search"></span>
          </label></a>
        

        <a href="index.php">Fil d'actualite</a>
        <?php echo "<a href="."'profile.php?pseudo=".$_GET['pseudo']."'        >Mon Profile</a> "  ?>

        
        <a href="message.php">Messages</a>
        <a href="parametre.php">Parametres</a>

        <a href="deconnexion.php">Deconnexion</a>
      
      </ul>
    </nav>
  </header>













<body></body></html>