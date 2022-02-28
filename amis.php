

<?php
include_once('query.php');
include_once('Loginclass.php');
//on supprime la table ou il ya les publication de la fil dactu
query('DELETE FROM post_fil',array());


$idvisite=est_co();

$pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];


if (isset($_POST['supprimerami'])){

    query('DELETE FROM ami WHERE (id_ami1=:iduser AND id_ami2=:idprofile) OR (id_ami2=:iduser AND id_ami1=:idprofile)',array(':iduser'=>$idvisite,':idprofile'=>$_GET['idsupp']));

}


   function requeteami($pseudoco){

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

               
                        echo "<img src='".$nometphotore['photo_profil']."' width=100 ><br/>
                        ".$nometphotore['pseudo']."  vous a envoyer une requete dami <br/>

                                 <form action='amis.php?pseudo=".$pseudoco."&idprore=".$nometphotore['id']." 'method='post'>
                                
                                 <input type='submit' name='accepterre' value='accepter requete ami'>
                                 <input type='submit' name='refuserre' value='refuser requete ami'>

                                 </form>";




              

                    



                             }
     








}


  function mesamis($pseudoco){  $idvisite=est_co();

    
 
       $idprofile=(query('SELECT id FROM utilisateurs WHERE pseudo=:pseudoco',array(':pseudoco' => $pseudoco)))[0]['id'];


  
if ((!query('SELECT * FROM informations WHERE id_user=:id',array('id'=>$idprofile))) OR ($idvisite==$idprofile) OR
  
  (query('SELECT * FROM informations,ami WHERE ((ami.id_ami1=:id AND ami.id_ami2=:id2) OR (ami.id_ami1=:id2 AND ami.id_ami2=:id)) AND informations.id_user=:id AND lesamis=:qui',array('id'=>$idprofile,':qui'=>'Mes amis',':id2'=>$idvisite))) OR

   (query('SELECT * FROM informations WHERE id_user=:id AND
  lesamis=:qui',array('id'=>$idprofile,':qui'=>'Tout le monde'))))
{


       $ami=(query('SELECT * FROM ami WHERE id_ami1=:iduser OR id_ami2=:iduser',array('iduser'=>$idprofile)));


 foreach ($ami as $unami) {

     if ($unami['id_ami1']==$idprofile){

    $nomphotoami=(query('SELECT pseudo,photo_profil,id FROM utilisateurs WHERE id=:iduser',array('iduser'=>$unami['id_ami2'])))[0];


     }

    else{
     $nomphotoami=(query('SELECT pseudo,photo_profil,id FROM utilisateurs WHERE id=:iduser',array('iduser'=>$unami['id_ami1'])))[0];

      }


   echo "<img src='".$nomphotoami['photo_profil']."' width=100 ><br/>
                        <a href='profile.php?pseudo=".$nomphotoami['pseudo']."'>".$nomphotoami['pseudo']."   </a><br/>";

    if ($idprofile == $idvisite) {
    echo "<form action='amis.php?pseudo=".$pseudoco."&idsupp=".$nomphotoami['id']." 'method='post'>
                                
                                 <input type='submit' name='supprimerami' value='supprimer cet ami'>
                            

                                 </form>";    }                
 }
   
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
  <?php 

  if( $pseudoco ==$_GET['pseudo'] )
 
    { 
 echo "<div class='requetesamis'> <h2> Mes requetes d'amis :</h2> ";
 
 echo requeteami($pseudoco);

 echo "</div>";     



                              


} ?>

<?php   if( $pseudoco ==$_GET['pseudo'] ){

echo " <div class='mesamis'><h2>Mes amis :</h2>";}
else { echo " <div class='mesamis'><h2>Les amis de ".$_GET['pseudo']." :</h2>";
}
 
echo mesamis($_GET['pseudo']);

echo "</div>";







?>



<body></body></html>