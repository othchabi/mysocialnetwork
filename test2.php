
<?php
include_once('query.php');
include_once('Loginclass.php');
include_once('fonction-post.php');



$idvisite=est_co();

$pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];









    function afficherprofile($recherche){
         

         $profilerecherche=(query('SELECT * FROM utilisateurs WHERE pseudo LIKE CONCAT("%",:a,"%") ',array(':a'=>$recherche)));
         echo "<div class='lesprofile'>";
         
         foreach ($profilerecherche as $prore) {

         	
         echo "<img src='".$prore['photo_profil']."' width=100 ><br/>
                        <a href='profile.php?pseudo=".$prore['pseudo']."'>".$prore['pseudo']."   </a><br/>";



         }

   echo "</div>";

    }




    function afficherpublication($recherche){

                 //avoir les publication ou $recherche est mentionner dans le body
    	          $publication=(query('SELECT post.id,post.body,post.date,post.post_photo,post.id_profile,post.likes,utilisateurs.pseudo,utilisateurs.photo_profil


    	           FROM post,utilisateurs


    	            WHERE( utilisateurs.id=post.id_profile AND post.body   LIKE CONCAT("%",:a,"%"))
    	              OR (  utilisateurs.id=post.id_profile AND utilisateurs.pseudo LIKE CONCAT("%",:a,"%"))  GROUP BY  post.id',array(':a'=>$recherche)));
                 
                 //avoir les publication ou $recherche est mentionner dans le pseudo

    	  
           
//tous les resultats


                   
    	         

                 $userid=est_co();

                 $posts = "<div class='lespubli'>";
                 
                 foreach($publication as $p) {
         if ((!query('SELECT * FROM informations WHERE id_user=:id',array('id'=>$p['id_profile']))) OR ($p['id_profile']==$userid) OR
  
          (query('SELECT * FROM informations,ami WHERE ((ami.id_ami1=:id AND ami.id_ami2=:id2) OR (ami.id_ami1=:id2 AND ami.id_ami2=:id)) AND informations.id_user=:id AND lespublications=:qui',array('id'=>$p['id_profile'],':qui'=>'Mes amis',':id2'=>$userid))) OR

   (query('SELECT * FROM informations WHERE id_user=:id AND
  lespublications=:qui',array('id'=>$p['id_profile'],':qui'=>'Tout le monde'))))
{




                        $imgpost=$p['post_photo'];
  $posts .="<div class='publication'><img src='".$p['photo_profil']."' width=100 ><p ><a href='profile.php?pseudo=".$p['pseudo']."'>".$p['pseudo']."   </a><br/> a poster :</p>";
                        if($userid==$p['id_profile']){ 
                        $posts .= "<div class='supprpub'><form action='test2.php?rechercher=$recherche&postid=".$p['id']."' method='post'> 
                        <input type='submit' name='supprimerpub' value='supprimer post'></form></div>";

                            }

            

                 

                                if($imgpost){
                                
                                $posts .= "<img src='".$p['post_photo']."' width=300 ><br/>"; }

                                
                                $posts .= htmlspecialchars($p['body'])." <p> - poster le ".$p['date']."</p><form action='test2.php?rechercher=$recherche&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='like' value='Like'>
                                        <span>".$p['likes']." likes</span>
                                        
                                        <input type='submit' name='ecrirecommentaire' value='poster commentaire'>
                                        <textarea class='postcomm' name='commentairebody' rows='3' cols='50'></textarea>
                                </form>
                                
                                ";

                        
               
                          $posts.=affichercommentaire($p['id']);
                       
                        $posts .="</div><br><br>";
                     
                      }}

                $posts .="</div>";
        return $posts;}


    



    












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
          </label></form>"; ?>


        </a>
        

        <?php echo "<a href="."'fildactu.php?pseudo=$pseudoco'"."        >Fil d'actualite</a> "  ?>
        <?php echo "<a href="."'profile.php?pseudo=$pseudoco'"."'        >Mon Profile</a> "  ?>

        
        <?php echo "<a href="."'messages.php?pseudo=$pseudoco'"."        >Messages</a> "  ?>
        <?php echo "<a href="."'parametres.php?pseudo=$pseudoco'"."        >Parametres</a> "  ?>

        <?php echo "<a href="."'deconnexion.php?pseudo=$pseudoco'"."        >Deconnexion</a> "  ?>
      
      </ul>
    </nav>
  </header>






<body>
	
<?php 

     if (isset($_GET['rechercher'])){ $recher=$_GET['rechercher'];
        
     
       echo "<h4 > Les profiles qui correspendent a : ".$recher."</h4>";
      

     echo afficherprofile($recher);


       echo "<h4 > Les posts qui correspendent a : ".$recher."</h4>";

     echo afficherpublication($recher);




     	
     }
     

 

  




?>











</body></html>