<?php
include_once('connexpdo.inc.php'); 

$idcom=connexpdo('myparam');

                      
                 function query($query, $params = array()){
                 	    $idcom=connexpdo('myparam');
                 	
                       
                      $statement = $idcom->prepare($query);
                      
                      $statement->execute($params);
                       if (explode(' ', $query)[0] == 'SELECT') {
                       $data = $statement->fetchAll();
                       
                       return $data;
                        }
                      }
                     ?>