<?php

include_once('query.php');
$idcom=connexpdo('myparam');
	
   function est_co() {
        if (isset($_COOKIE['SNID'])){

        if (query('SELECT  id_utilisateur FROM token_connexion WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID']) ))) {


                $iduser=(query('SELECT  id_utilisateur FROM token_connexion WHERE token=:token',array(':token'=>sha1($_COOKIE['SNID']) )))[0]['id_utilisateur'];
                
                if (isset($_COOKIE['SNID_'])) {
                	  return $iduser;

                  } 

                else {

                      $cstrong=True;
                      $token= bin2hex(openssl_random_pseudo_bytes(64,$cstrong));
                      query('INSERT INTO token_connexion VALUES (\'\',:token,:id_utilisateur)',array(':token'=>sha1($token),':id_utilisateur'=>$iduser));	

                      query('DELETE token_connexion WHERE token =:token ',array(':token'=>sha1($_COOKIE['SNID'])));	

                     setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                     setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);

                     return $iduser;


                }
                               


        }

     } 
     return false;
    }  
 




?>