<?php
$pageTitle = "Nieuwe rol";
include($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if(perm('ROL_AANPASSEN')) {
   $objRollen = new Permissions($dbconn);
   $rollen = $objRollen->addRol();
}
else {
   echo 'Je hebt niet de juiste rechten';
}
?>