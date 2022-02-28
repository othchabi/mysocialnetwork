<?php

include_once('Loginclass.php');
include_once("fonction-commentaire.php");
$userid=est_co();

echo "<link rel='stylesheet' type='text/css' href='css/style2.css'>";


if (isset($_POST['ecrirecommentaire']))
{
  creecommentaire($_POST['commentairebody'],$_GET['postid'],$userid);
  
}

                       if (isset($_POST['like']))
                        {   
                            likerpost($_GET['postid'],$userid);
          
          
                        }




                    if(isset($_POST['supprimerpub'])){
                     supprimerpost($_GET['postid']);
                     

                                     }






     function creepost($bodypost, $idconnecter, $idprofile) {

        $noimage="0";



            
                if ($idconnecter == $idprofile) { 

                if (strlen($bodypost) > 244 || strlen($bodypost) < 1) {
                        die('Incorrect length!');
                }




                 

                 query('INSERT INTO post VALUES (\'\', :bodypost, NOW(), :userid, 0,:image)', array(':bodypost'=>$bodypost , ':userid'=>$idprofile,':image'=>$noimage));}
        
                 else {
                        die('Impossible de faire une publication!');
                }
        }
             function supprimerpost($idpost) {




                 query('DELETE FROM commentaire WHERE id_post=:idpost',array(':idpost'=>$idpost));
                 
                 query('DELETE FROM post_like WHERE id_post=:idpost',array(':idpost'=>$idpost));
                 query('DELETE FROM post WHERE id=:idpost',array(':idpost'=>$idpost));
        
               
        }






             function creepostimage($bodypost, $idconnecter, $idprofile,$img) {

            
                   if ($idconnecter == $idprofile) { 

                            if (strlen($bodypost) > 240) {
                                         die('Incorrect length!');
                                                         }          

                        query('INSERT INTO post VALUES (\'\', :bodypost, NOW(), :userid, 0,:filedestination)', array(':bodypost'=>$bodypost , ':userid'=>$idprofile,':filedestination'=>$img));}
           
                 else {
                        die('Impossible de faire une publication!');
                }
        }

         function likerpost($postid, $userid) { 

                if (!query('SELECT id_user FROM post_like WHERE id_post=:postid AND id_user=:userid', array(':postid'=>$postid, ':userid'=>$userid))) {
                        query('UPDATE post SET likes=likes+1 WHERE id=:postid', array(':postid'=>$postid));
                        query('INSERT INTO post_like VALUES (\'\', :postid, :userid)', array(':postid'=>$postid, ':userid'=>$userid));
                } else {
                        query('UPDATE post SET likes=likes-1 WHERE id=:postid', array(':postid'=>$postid));
                        query('DELETE FROM post_like WHERE id_post=:postid AND id_user=:userid', array(':postid'=>$postid, ':userid'=>$userid));
                }


        }

       function afficherpost($userid, $pseudo, $idconnecter) {
                $dbposts = query('SELECT * FROM post WHERE id_profile=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $temp=query('SELECT * FROM utilisateurs WHERE id=:userid ORDER BY id DESC', array(':userid'=>$userid))[0];
                $posts = "";



  if ((!query('SELECT * FROM informations WHERE id_user=:id',array('id'=>$userid))) OR ($userid==$idconnecter) OR
  
          (query('SELECT * FROM informations,ami WHERE ((ami.id_ami1=:id AND ami.id_ami2=:id2) OR (ami.id_ami1=:id2 AND ami.id_ami2=:id)) AND informations.id_user=:id AND lespublications=:qui',array('id'=>$userid,':qui'=>'Mes amis',':id2'=>$idconnecter))) OR

   (query('SELECT * FROM informations WHERE id_user=:id AND
  lespublications=:qui',array('id'=>$userid,':qui'=>'Tout le monde'))))
              {

                foreach($dbposts as $p) {




                        $imgpost=$p['post_photo'];
                        $posts .="<div class='publication'><img src='".$temp['photo_profil']."'width=100>".$temp['pseudo']." :<br/><br/><br/>";
                  if($userid==$idconnecter){
                        $posts .= "<div class='supprpub'><form action='profile.php?pseudo=$pseudo&postid=".$p['id']."' method='post'><input type='submit' name='supprimerpub' value='supprimer post'></form></div>";

                
                    if(isset($_POST['supprimerpub'])){
                     supprimerpost($_GET['postid']);
                     header('Location: profile.php?pseudo='.$pseudo);

                                     }}
            

              

                    if($imgpost){

                                $posts .= " <img src='".$p['post_photo']."' width=300 ><br/>";}


            $posts .=htmlspecialchars($p['body'])."<br/><br/> - publié le ".$p['Date']."'<form action='profile.php?pseudo=$pseudo&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='like' value='like'>
                                        <span>".$p['likes']." likes</span>
                                        
                                        <input type='submit' name='ecrirecommentaire' value='post commentaire'>
                                        <textarea class='postcomm' name='commentairebody' rows='3' cols='50'></textarea>
                                        
                                </form>
                                
                                ";
                        
                        
               
                          $posts.=affichercommentaire($p['id']);
                          $posts .="</div></br></br>";
                     
                      }}

                
        return $posts;}


        function afficherpostfil($iduser){                        

             $pseudo=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $iduser)))[0]['pseudo'];
              
             $ami=(query('SELECT * FROM ami WHERE id_ami1=:iduser OR id_ami2=:iduser',array('iduser'=>$iduser)));
  
             
            foreach ($ami as $unami) {

               if ($unami['id_ami1'] == $iduser){
               if( !query('SELECT id_filuser FROM post_fil WHERE id_filuser=:id ',array(":id"=>$unami['id_ami2']))){
                query('INSERT INTO post_fil VALUES (\'\',:id_filuser)',array(":id_filuser"=>$unami['id_ami2']));}



                                                }

              if ($unami['id_ami2'] == $iduser){
              if( !query('SELECT id_filuser FROM post_fil WHERE id_filuser=:id ',array(":id"=>$unami['id_ami1']))){
               query('INSERT INTO post_fil VALUES (\'\',:id_filuser)',array(":id_filuser"=>$unami['id_ami1']));}

                  }
              
                
            
                }

                 
 //on trouve tous les posts en fonction de la date par ordre decroissant

                 $dbposts = query('SELECT DISTINCT  post.id,post.body,post.date,post.id_profile,post.likes,post.post_photo,utilisateurs.pseudo,utilisateurs.photo_profil  FROM post,post_fil,utilisateurs WHERE ((post.id_profile=post_fil.id_filuser AND utilisateurs.id=post.id_profile)
                 OR (post.id_profile=:temp AND utilisateurs.id=:temp)) ORDER BY post.date DESC',array(':temp'=>$iduser));

                 
               
              
                   $posts = "";

                foreach($dbposts as $p) { 
      if ((!query('SELECT * FROM informations WHERE id_user=:id',array('id'=>$p['id_profile'])))  OR ($iduser==$p['id_profile']) OR  
  

         (!query('SELECT * FROM informations WHERE id_user=:id AND
          lespublications=:qui',array('id'=>$p['id_profile'],':qui'=>'Personne'))))
              {
                                       
                 
                        $imgpost=$p['post_photo'];
                        $posts .="<div class='publication'><img src='".$p['photo_profil']."'width=100><a href='profile.php?pseudo=".$p['pseudo']."'>".$p['pseudo']." :</a><br/><br/><br/>";
                        if($_GET['pseudo']==$p['pseudo']){
                        $posts .= "<div class='supprpub'><form action='fildactu.php?pseudo=$pseudo&postid=".$p['id']."' method='post'><input type='submit' name='supprimerpub' value='supprimer post'></form></div>";

                                                        }
            



                  if($imgpost){

                                $posts .= " <img src='".$p['post_photo']."' width=300 ><br/>";}


                                $posts .=htmlspecialchars($p['body']). "<br/><br/> - publié le ".$p['date']."'<form action='fildactu.php?pseudo=$pseudo&postid=".$p['id']."' method='post'>
                                        <input type='submit' name='like' value='like'>
                                        <span>".$p['likes']." likes</span>
                                        
                                        <input type='submit' name='ecrirecommentaire' value='poster commentaire'>
                                        <textarea class='postcomm' name='commentairebody' rows='3' cols='50'></textarea>
                                        
                                </form>";

                          
                        
                        
                        $posts.=affichercommentaire($p['id']);
                        $posts .="</div></br></br>";

                     
                      } }   

                
                return $posts;




















             
       
        }


              


?>