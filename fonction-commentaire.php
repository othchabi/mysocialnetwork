<?php

include_once('Loginclass.php');

echo "<link rel='stylesheet' type='text/css' href='css/style2.css'>";

        function creecommentaire($bodycommentaire, $postId, $userId) { 
                if (strlen($bodycommentaire) > 244 || strlen($bodycommentaire) < 1) {
                        die('Taille impossible!');
                }

                if (!query('SELECT id FROM post WHERE id=:postid', array(':postid'=>$postId))) {
                        echo 'Invalid post ID';
                } else {
                        query('INSERT INTO commentaire VALUES (\'\', :comment, :userid, NOW(), :postid)', array(':comment'=>$bodycommentaire, ':userid'=>$userId, ':postid'=>$postId));
                }

        }

       function affichercommentaire($postId) {

                    $comm = "<label for='uncom' >Commentaires :  </label><div id='uncom' class='uncommentaire' >";
                    $commentaire = query('SELECT commentaire.body, utilisateurs.pseudo,utilisateurs.photo_profil,commentaire.date FROM commentaire, utilisateurs WHERE id_post =:postid AND commentaire.id_user = utilisateurs.id', array(':postid'=>$postId));
                    
 

                     foreach($commentaire as $comment) {
                       
                        $comm .= "<div class='com1'><img src='".$comment['photo_profil']."' width=80 ><div class='com2'><p><a href='profile.php?pseudo=".$comment['pseudo']."'>".$comment['pseudo']."   </a> a commenter  :</p>";
                       
                        $comm .= $comment['body']."<br> - commenter le : ".$comment['date']."</div></div>";


                     
                }
                 $comm .= "</div>";
                return $comm;
        }

?>