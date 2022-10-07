<?php
$pageTitle = 'Verwijderd';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (perm('GED_BEWERKEN')) {
  if (isset($_GET["id"])) {
     $id = $_GET["id"];
  }
  else {
      header('location: ../gedetineerden.php');
  }
  
  $objGedetineerde = new Gedetineerde($dbconn);
  $gedetineerde = $objGedetineerde->deleteGedetineerde($id);
}
else {
   echo '<p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>';
}

echo '<div class="content">';
echo "Gedetineerde verwijderd";
?>
