<?php

include_once('Loginclass.php');


$tokenvalide= False;

if (est_co()) {
        
        if (isset($_POST['changer_mdp'])) {

                $oldpassword = $_POST['ancienmdp'];
                $newpassword = $_POST['nouveaumdp'];
                $newpasswordrepeat = $_POST['nouveaumdp2'];
                $userid = est_co();

                if (password_verify($oldpassword, query('SELECT mdp FROM utilisateurs WHERE id=:userid', array(':userid'=>$userid))[0]['mdp'])) {

                        if ($newpassword == $newpasswordrepeat) {

                                if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60) {

                                        query('UPDATE utilisateurs SET mdp=:newpassword WHERE id=:userid', array(':newpassword'=>password_hash($newpassword, PASSWORD_BCRYPT), ':userid'=>$userid));
                                        echo 'Mot de passe a ete change !';
                                }

                        } else {
                                echo 'Les deux nouveaux mot de passe sont differents!';
                        }

                } else {
                        echo 'Mot de passe incorrect!';
                }

        }

 } else { if (isset($_GET['token'])) {




 	    $token=$_GET['token'];
 	    if (query('SELECT id_utilisateur FROM token_mdp WHERE token=:token', array(':token'=>sha1($token)))) {
 	    	     $userid= query('SELECT id_utilisateur FROM token_mdp WHERE token=:token', array(':token'=>sha1($token)))[0]['id_utilisateur'];
 	    	     $tokenvalide=True;
 	    	     if (isset($_POST['changer_mdp'])) {
 	    	     	$newpassword=$_POST['nouveaumdp'];
 	    	     	$newpasswordrepeat=$_POST['nouveaumdp2'];

 	    	     	if ($newpasswordrepeat==$newpasswordrepeat) {

 	    	     		if (strlen($newpassword) >= 6 && strlen($newpassword) <= 60 ) {

 	    	     			query('UPDATE utilisateurs SET mdp =:newpassword WHERE id=:userid',array(':newpassword'=>password_hash($newpassword,PASSWORD_BCRYPT),':userid'=>$userid));
 	    	     			echo 'MDP a ete changer ';
 	    	     			query('DELETE FROM token_mdp WHERE id_utilisateur=:userid',array(':userid' => $userid));
 	    	     		}
 	    	     	}else { echo 'Les deux mots de passe sont different';}
 	    	     }
 }else {die('Token non valide');}}
 else { die('Non connecter');}}




?>

<h1>changer mdp</h1>

<form action="<?php if (!$tokenvalide) { echo 'changer_mdp.php'; } else { echo 'changer_mdp.php?token='.$token.''; } ?>" method="post">
	<?php if (!$tokenvalide) { echo '<input type="password" name="ancienmdp" value="" placeholder="Mot de passe actuel ..."><p />'; } ?>      
        <input type="password" name="nouveaumdp" value="" placeholder="Nouveau mot de passe ..."><p />
        <input type="password" name="nouveaumdp2" value="" placeholder="Confirmation nouveau mot de passe ..."><p />
        <input type="submit" name="changer_mdp" value="Changer">
</form>