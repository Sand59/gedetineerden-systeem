<?php
$pageTitle = "Nieuwe rol";
include($_SERVER['DOCUMENT_ROOT'].'/include/database.php');
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if(perm('ROL_AANPASSEN')) {
   if (isset($_POST["rol"])) {
      $rol = $_POST["rol"];
   }

   if (isset($_POST["id"])) {
      $id = $_POST["id"];
   }

   $objRollen = new Permissions($dbconn);
   $rollen = $objRollen->updateNaamRol($rol, $id);
}
else {
   echo 'Je hebt niet de juiste rechten';
}
?>
