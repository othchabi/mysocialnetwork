<?php  
include_once ("myparam.inc.php");




function connexpdo($param){
	include_once($param.".inc.php");
	$dsn="mysql:host=".MYHOST.";dbname=".MABASE;
	$user=MYUSER;
	$pass=MYPASS;
	try{$idcom = new PDO($dsn,$user,$pass);
		return $idcom;}
		catch(PDOException $except){
			die('Erreur : ' . $except->getMessage());}
		}





		?>