<?php
include_once('query.php');
include_once('Loginclass.php');



$idvisite=est_co();

$pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];
$mabio=(query('SELECT bio FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['bio'];


if ($pseudoco != $_GET['pseudo']) {

      header('Location : index.php');

}


if (isset($_POST['confirmerbio'])) {


    if (strlen($_POST['bio']) >= 1 && strlen($_POST['bio']) <= 60 ){


        query('UPDATE utilisateurs SET bio=:bio WHERE id=:iduser',array(':bio'=>$_POST['bio'],':iduser'=>$idvisite));

    } 

    else { echo "impossible de changer la bio";
          }
  

}







if (isset($_POST['uploadprofileimg'])) {


        $file = $_FILES['file'];
 
        $filename = $_FILES['file']['name'];

        $filetmpname = $_FILES['file']['tmp_name'];

        $filesize = $_FILES['file']['size'];

        $fileerror = $_FILES['file']['error'];

        $filetype = $_FILES['file']['type'];



        $fileext = explode('.',$filename);
        $fileactualext= strtolower(end($fileext));
        $allowed = array('jpg','jpeg','png');

        if (in_array($fileactualext,$allowed)) {

                if ($fileerror === 0) {

                        if ($filesize < 10000000) { $filenamenew = uniqid('',true).".".$fileactualext;
                        $filedestination ='image/'.$filenamenew;
                        move_uploaded_file($filetmpname,$filedestination);
                        
                        query('UPDATE utilisateurs SET photo_profil=:filedestination WHERE id=:iduser',array(':filedestination'=>$filedestination,':iduser'=>$idvisite));


                        } else { echo "votre photo est tros lourde"; }

                }else { echo "Erreur upload"; }


        }else { echo "Vous ne pouvez pas envoyer"; }
     }



if (isset($_POST['confirmerpseudo'])) {


if (!query('SELECT pseudo FROM utilisateurs WHERE pseudo=:pseudo', array(':pseudo'=>$_POST['textpseudo'])))
 {

     if (strlen($_POST['textpseudo']) >= 3 && strlen($_POST['textpseudo']) <= 32){

           if (preg_match('/[a-zA-Z0-9_]+/', $_POST['textpseudo'])){

                 
 
            query('UPDATE utilisateurs SET pseudo=:pseudo WHERE id=:iduser',array(':pseudo'=>$_POST['textpseudo'],':iduser'=>$idvisite));
            $pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];
            
            header('Location: parametres.php?pseudo='.$pseudoco);
               
                         

                        } else {
                                echo 'Pseudo non valide';
                        }
                } else {
                        echo 'Pseudo Trop long ou trop court ';
                }

        } else {
                echo 'pseudo déja utilise ';
        }
}



if (isset($_POST['changermdp'])) {

                $oldpassword = $_POST['ancienmdp'];
                $newpassword = $_POST['nouveaumdp'];
                $newpasswordrepeat = $_POST['nouveaumdp2'];
              

                if (password_verify($oldpassword, query('SELECT mdp FROM utilisateurs WHERE id=:userid', array(':userid'=>$idvisite))[0]['mdp'])) {

                        if ($newpassword == $newpasswordrepeat) {

                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                        query('UPDATE utilisateurs SET mdp=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$idvisite));
                                        echo 'Mot de passe a ete change !';
                                } else{echo 'nouveau mot de passe est trop court ou trop long';}

                        } else {
                                echo 'Les deux nouveaux mot de passe sont differents!';
                        }

                } else {
                        echo 'Mot de passe incorrect!';
                }

        }


$default='Public';

if (isset($_POST['quibio'])){ 

  //si il nyas aucune information
  if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
  { 
     query('INSERT INTO informations VALUES (\'\',:lesamis,:labio,:lespublications,:iduser)',array(':labio'=>$_POST['droitbio'],':lesamis'=>$default,':lespublications'=>$default,':iduser'=>$idvisite));

  }
  else {


  	query('UPDATE informations SET labio=:labio WHERE id_user=:iduser',array(':labio'=>$_POST['droitbio'],':iduser'=>$idvisite));
  }
}
if (isset($_POST['quiami'])){


  //si il nyas aucune information
  if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
  { 
     query('INSERT INTO informations VALUES (\'\',:lesamis,:labio,:lespublications,:iduser)',array(':labio'=>$default,':lesamis'=>$_POST['droitami'],':lespublications'=>$default,':iduser'=>$idvisite));
 
  }
  else {


  	query('UPDATE informations SET lesamis=:lesamis WHERE id_user=:iduser',array(':lesamis'=>$_POST['droitami'],':iduser'=>$idvisite));
  }
}
if (isset($_POST['quipub'])){

  //si il nyas aucune information
  if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
  { 
     query('INSERT INTO informations VALUES (\'\',:lesamis,:labio,:lespublications,:iduser)',array(':labio'=>$default,':lesamis'=>$default,':lespublications'=>$_POST['droitpub'],':iduser'=>$idvisite)); 

  }
  else {


  	query('UPDATE informations SET lespublications=:lespublications WHERE id_user=:iduser',array(':lespublications'=>$_POST['droitpub'],':iduser'=>$idvisite));
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
        

        <?php echo "<a href="."'index.php?pseudo=$pseudoco'"."        >Fil d'actualite</a> "  ?>
        <?php echo "<a href="."'profile.php?pseudo=$pseudoco'"."'        >Mon Profile</a> "  ?>

        
        <?php echo "<a href="."'messages.php?pseudo=$pseudoco'"."        >Messages</a> "  ?>
        <?php echo "<a href="."'parametres.php?pseudo=$pseudoco'"."        >Parametres</a> "  ?>

        <?php echo "<a href="."'deconnexion.php?pseudo=$pseudoco'"."        >Deconnexion</a> "  ?>
      
      </ul>
    </nav>
  </header>
  
  <div class ='containerparam'> <h2> Mes parametres :</h2>
  <div class='containerparam1'>
  <h3>Changer ma bio :</h3>
<form method="post" > 
<textarea type='text' class='changerbio' name='bio'> <?php echo $mabio; ?>  </textarea>
<input type="submit" name='confirmerbio' value='changer ma bio '></form>

</form>

</div></br>
  <div class='containerparam1'>
  <h3>Changer de photo de profile :</h3>

  <?php  $maphoto=(query('SELECT photo_profil FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['photo_profil'];
 echo "<form action='parametres.php?pseudo=".$pseudoco."'  method='post' enctype='multipart/form-data'>
        
        <input type='file' name='file'>
        <input type='submit' name='uploadprofileimg' value='Confirmer Image'>

</form>";
?>


<p>Ma photo de profile : </p>
<?php echo "<img src='".$maphoto."'width=100>"; ?>



</div></br>
   <div class='containerparam2'>
  <h3>Changer de pseudo :</h3></h3>
 <?php   $pseudoco=(query('SELECT pseudo FROM utilisateurs WHERE id=:id',array(':id' => $idvisite)))[0]['pseudo'];
 echo "<form   method='post' enctype='multipart/form-data'>
          <input type='text' name='textpseudo' value=".$pseudoco." placeholder='Entrez votre nouveau pseudo'><p />
          <input type='submit' name='confirmerpseudo' value='Changer pseudo'>


</form>";
?>
</div></br>
  <div class='containerparam1'>
  <h3>Changer mon mot de passe :</h3>


<form  method="post">
	    <input type="password" name="ancienmdp" value="" placeholder="Mot de passe actuel ..."><p />

        <input type="password" name="nouveaumdp" value="" placeholder="Nouveau mot de passe ..."><p />
        <input type="password" name="nouveaumdp2" value="" placeholder="Confirmation nouveau mot de passe ..."><p />
        <input type="submit" name="changermdp" value="Changer Mon Mot de passe">
</form>




</div>




</br>
  <div class='containerparam1'>
  <h3>Changer qui peut voir mes informations :</h3>

<form method='post'>
<?php

 echo "<label for='droitbio'>Qui peut voir ma bio : </label>" ?>

<select name="droitbio">
	<option value="Public">Tout le monde</option>
	<option value="Mes amis">Mes amis</option>
	<option value="Personne">Personne</option><

</select>
<br>
<input type='submit' name='quibio'	 value='Changer'>
</form>

<br>

<form method='post'>

<?php


 echo "<label for='droitami'>Qui peut voir mes amis : </label>" ?>

<select name="droitami">
	<option value="Public">Tout le monde</option>
	<option value="Mes amis">Mes amis</option>
	<option value="Personne">Personne</option><

</select>
<br>
<input type='submit' name='quiami' value='Changer'>
</form>


<br>
<form method='post'>
<?php

 echo "<label for='droitpub'>Qui peut voir mes publications : </label>" ?>

<select name="droitpub">
	<option value="Public">Tout le monde</option>
	<option value="Mes amis">Mes amis</option>
	<option value="Personne">Personne</option><

</select>
<br>
<input type='submit' name='quipub' value='Changer'>
</form>
<?php 

    if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
    {
    	echo "Ma bio est : Public ";
    }
    else { $qui=query('SELECT labio FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite))[0]['labio'];

    	echo "Ma bio peut etre vu par : ".$qui;
    }
    echo "<br><br>";
    if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
    {
    	echo "Ma liste d'amis est : Public "; 
    }
    else { $qui=query('SELECT lesamis FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite))[0]['lesamis'];

    	echo "Ma liste d'amis peut etre vu par : ".$qui;
    }
    echo "<br><br>";
    if (!query('SELECT id FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite)))
    {
    	echo "Mes publications sont : Public ";
    }
    else { $qui=query('SELECT lespublications FROM informations WHERE id_user=:iduser',array(':iduser'=>$idvisite))[0]['lespublications'];

    	echo "Mes peuvent etre vu  par : ".$qui;
    }
    echo "<br><br>";
 





?>




</div></br>





  </div>


<body></body></html>