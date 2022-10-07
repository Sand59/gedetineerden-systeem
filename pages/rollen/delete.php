<?php
$pageTitle = "Nieuwe rol";
include($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if(perm('ROL_AANPASSEN')) {
   if (isset($_GET["id"])) {
      $id = $_GET["id"];
   }

   $objRollen = new Permissions($dbconn);
   $rollen = $objRollen->deleteRol($id);
}
else {
   echo 'Je hebt niet de juiste rechten';
}
?>