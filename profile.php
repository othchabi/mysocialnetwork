<?php

include_once('Loginclass.php');
include_once('fonction-post.php');
include_once('fonction-commentaire.php');
include_once('uploadimage.php');

echo "<link rel='stylesheet' type='text/css' href='css/style2.css'>";

$pseudo="";




$idvisite=est_co();

 $pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];



if (isset($_GET['pseudo']))
	{  
      

    //Si il existe un utilisateur avec ce pseudo
      if (query('SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo',array(':pseudo' => $_GET['pseudo']))){
             
           
           


           $pseudo=(query('SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo',array(':pseudo' => $_GET['pseudo'])))[0]['pseudo'];
           $idprofilepage= (query('SELECT id FROM utilisateurs WHERE pseudo=:pseudo',array(':pseudo'=>$pseudo)))[0]['id'];

       //on prend limage


           $imageprofile = (query('SELECT photo_profil FROM utilisateurs WHERE id=:iduser ',array(':iduser'=>$idprofilepage)))[0]['photo_profil'];
           
           


           
           

             //Si on appuie sur envoyer une requete
               if (isset($_POST['Requete'])) {

               
               	 if ($idprofilepage != $idvisite) {


                      //Si la requete n'a pas deja ete envoyer on lenvoie
                   if (!query('SELECT id_envoie FROM requete_ami WHERE id_recoit=:iduser AND id_envoie=:idenvoie',array(':iduser'=>$idprofilepage,':idenvoie'=>$idvisite))) { 

        	           query('INSERT INTO requete_ami VALUES (\'\',:iduser,:idenvoie)',array(':iduser'=>$idprofilepage,':idenvoie'=>$idvisite));}
        	          //sinon on envoie ce message
        	       else { echo 'Vous avez déja envoyer une requete d ami';
                         }
              //Aenvoyer est toujours vrai a la fin 
                }


                                              }



              $estami=query('SELECT * FROM ami WHERE (id_ami1=:id1 AND id_ami2=:id2) OR (id_ami2=:id1 AND id_ami1=:id2) ',array(':id1'=>$idvisite,':id2'=>$idprofilepage));
              






            //Si on appuie sur le bouton qui supprime la requete

          if (isset($_POST['suppRequete'])) {

               	 if ($idprofilepage != $idvisite) { 

            //Si la requete existe dans la table des requetes on la supprime
             if (query('SELECT id_envoie FROM requete_ami WHERE id_recoit=:iduser AND id_envoie=:idenvoie',array(':iduser'=>$idprofilepage,':idenvoie'=>$idvisite))) {

        	   query('DELETE FROM requete_ami WHERE id_recoit=:iduser AND id_envoie=:idenvoie',array(':iduser'=>$idprofilepage,':idenvoie'=>$idvisite));
        	}
              
              //Aenvoyer est toujours faux a la fin 
             
            


       }  }
       
     
       if (isset($_POST['post'])) {
          

                  if ($_FILES['fileimage']['size'] == 0) {
                       creepost($_POST['posttext'],$idvisite,$idprofilepage);
                  
                    }

                    else { $filedestination=uploadimage('fileimage');
                           
                           if($filedestination){ 

                           	creepostimage($_POST['posttext'],$idvisite,$idprofilepage,$filedestination);
                           }
                           else{ Die('Erreur image');}
                }




          	}                      


          //on prend la bio 








       //Si une requete existe de la part de celui qui est connecter Aenvoyer est vrai
      
      if (query('SELECT id_envoie FROM requete_ami WHERE id_envoie=:idenvoie ',array(':idenvoie'=>$idvisite))) 
      { 
      	$Aenvoyer=True;


      }

  


     

          
            $posts = afficherpost($idprofilepage,$pseudo,$idvisite);
          


   





   }













   else { die('Utilisateur non trouve'); 
         }






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
        <?php echo "<a href="."'profile.php?pseudo=$pseudoco'"."        >Mon Profile</a> "  ?>

        
        <?php echo "<a href="."'messages.php?pseudo=$pseudoco'"."        >Messages</a> "  ?>
        <?php echo "<a href="."'parametres.php?pseudo=$pseudoco'"."        >Parametres</a> "  ?>

        <?php echo "<a href="."'deconnexion.php?pseudo=$pseudoco'"."        >Deconnexion</a> "  ?>
      
      </ul>
    </nav>
  </header>













<body>



<div class="proimg">
<img  src=<?php echo $imageprofile; ?> width=300 ></div>

</div><?php




               if ($idprofilepage==$idvisite){ echo "<h1 class='proftxt1'>Bonjour ".$pseudo."</h1><br>";} 
               else   { echo "<h1 class='proftxt1'>Profile de $pseudo</h1>";  } ?>
             

             <?php   


             if ((query('SELECT * FROM ami WHERE (id_ami1=:iduser1 AND id_ami2=:iduser2) OR (id_ami2=:iduser1 AND id_ami1=:iduser2)',array('iduser1'=>$idprofilepage,'iduser2'=>$idvisite)))) {
                                  echo "<h1 class='estami'>(Ami)</h1>"; }  ?>
                
               <?php echo	"<div class='voirami'><form action='amis.php?pseudo=".$pseudo."' method='post' enctype='multipart/form-data'>
		
			
        
        <input type='submit' name='amis' value='Voir les amis'></div></form>"; ?>

<div class='voirreq'>
<form   method="post">
	    <?php  
        if (($idprofilepage != $idvisite) AND (!$estami)) {


             if  (query('SELECT * FROM requete_ami WHERE id_envoie=:id1 AND id_recoit=:id2',array(':id1'=>$idvisite,':id2'=>$idprofilepage )))
                    {
                        echo '<input  type="submit" name="suppRequete" value="Supprimer requete d ami">';
                    } 
                  if  (!query('SELECT * FROM requete_ami WHERE id_envoie=:id1 AND id_recoit=:id2 ',array(':id1'=>$idvisite,':id2'=>$idprofilepage )))
                   {
                        echo '<input  type="submit" name="Requete" value="Envoyer requete d ami">';
                   }

               
        }
        ?>
</form>
</div>
<?php 
if($idprofilepage==$idvisite){

	$mabio=query('SELECT bio FROM utilisateurs WHERE id=:idvisite',array(":idvisite"=>$idvisite))[0]['bio'];
	echo "<div class='bio' ><label for='b'>Bio :</label><div name='b' ><p>".$mabio."<p/></div></div>";
}
else
{
if( !query('SELECT labio FROM informations WHERE id_user=:idprofilepage', array(':idprofilepage'=>$idprofilepage)))
{
   $bio=query('SELECT bio FROM utilisateurs WHERE id=:idvisite',array(":idvisite"=>$idprofilepage))[0]['bio'];

   echo "<div class='bio' ><label for='b'>Bio :</label><div name='b' ><p>".$bio."<p/></div></div>";


}
else 
    {  

	$infobio=query('SELECT labio FROM informations WHERE id_user=:id2',array(':id2'=>$idprofilepage))[0]['labio'];
	

	if($infobio =='Tout le monde'){
   $bio=query('SELECT bio FROM utilisateurs WHERE id=:idvisite',array(":idvisite"=>$idprofilepage))[0]['bio'];

   echo "<div class='bio' ><label for='b'>Bio :</label><div name='b' ><p>".$bio."<p/></div></div>";
	}
	if($infobio=='Personne'){ 

	}

	if (($infobio=='Mes amis') AND (query('SELECT * FROM ami WHERE (id_ami1=:idvisite AND id_ami2=:idprofile ) OR (id_ami2=:idvisite AND id_ami1=:idprofile )',array(':idvisite'=>$idvisite,':idprofile'=>$idprofilepage) )))    



		{    $bio=query('SELECT bio FROM utilisateurs WHERE id=:idvisite',array(":idvisite"=>$idprofilepage))[0]['bio'];

             echo "<div class='bio' ><label for='b'>Bio :</label><div name='b' ><p>".$bio."<p/></div></div>";
}



}

}



?>

<?php if ($idprofilepage == $idvisite) {
echo "<div class='poster'>
<label for='posttext'>Postez quelque chose : </label>
	<form action='profile.php?pseudo=".$pseudo."' method='post' enctype='multipart/form-data'>
		
			<textarea class='posttext' name='posttext' rows='8' cols='80'></textarea>
        <br/>Upload an image or file :
        <input type='file' name='fileimage'>
        <input type='submit' name='post' value='post'>

    </form>
</div>
<h1 class='titreposte'> Mes posts :</h1><div class='posts' >
        ".$posts."
</div>";
}

else {
echo "<h1 class='titreposte2'> Les posts de  ".$pseudo." :</h1><div class='posts2' >
        ".$posts."
</div>";

}

?>

</body>
</html>