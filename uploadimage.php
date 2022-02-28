<?php
include_once('query.php');
include_once('Loginclass.php');




function uploadimage($fileimage){
          print_r($_FILES[$fileimage]);

        $file = $_FILES[$fileimage];
 
        $filename = $_FILES[$fileimage]['name'];

        $filetmpname = $_FILES[$fileimage]['tmp_name'];

        $filesize = $_FILES[$fileimage]['size'];

        $fileerror = $_FILES[$fileimage]['error'];

        $filetype = $_FILES[$fileimage]['type'];



        $fileext = explode('.',$filename);
        $fileactualext= strtolower(end($fileext));
        $allowed = array('jpg','jpeg','png');

        if (in_array($fileactualext,$allowed)) {

                if ($fileerror === 0) {

                        if ($filesize < 10000000) { $filenamenew = uniqid('',true).".".$fileactualext;
                        $filedestination ='image/'.$filenamenew;
                        move_uploaded_file($filetmpname,$filedestination);
                        
                        return $filedestination;

                        } else { echo "votre photo est tros lourde"; }

                }else { echo "Erreur upload"; }


        }else { echo "Vous ne pouvez pas envoyer"; }
}



?>