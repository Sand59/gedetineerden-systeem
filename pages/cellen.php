<?php
$pageTitle = 'Cellen';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objCellen = new Cellen($dbconn);
$cellen = $objCellen->getCellen();
$aantalCellen = $objCellen->getAantalCellen();
$aantal = $cellen->rowCount();
?>

<script>
    document.getElementById('aantal').innerHTML = "<?php echo 'Hier kan je zien in welke cellen de gedetineerde zitten' ?>";
</script>

<?php
echo "<div class='content'>";
if(perm('CEL_BEKIJKEN')) {
   echo "<div class='cellen'>";

   if ($aantal > 0) {
      foreach ($cellen as $row) {
               echo "<div class='cellen-items'>
                        <div class='cellen-top'>
                           <h2>Cel " . $row['cel_nummer'] . "</h2>
                           <div class='cellen-img-wrapper'>
                                 <a href='cel/view.php?cel={$row['cel_nummer']}'><img src='/images/icons/arrow-right.png'></a>
                           </div>
                        </div>
                        <div class='cellen-content-row'>
                           <div class='cellen-content-col'>
                                 <p>Afdeling</p>
                           </div>
                           <div class='cellen-content-col'>
                                 <p>" . $row['afdeling'] . "</p>
                           </div>
                        </div>
                        <div class='cellen-content-row'>
                           <div class='cellen-content-col'>
                                 <p>Aantal</p>
                           </div>
                           <div class='cellen-content-col'>
                                 <p>" . $row['aantal'] . " gedetineerden</p>
                           </div>
                        </div>
                        <div class='cellen-content-row'>
                           <div class='cellen-content-col'>
                                 <p>Laatste wijziging</p>
                           </div>
                           <div class='cellen-content-col'>
                                 <p>" . $row['laatste_wijziging'] . "</p>
                           </div>
                        </div>
                     </div>";
      }
   }

   else {
      echo "Geen gegevens";
   }
}
else {
   echo '<p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>';
}
echo "</div>";
include '../include/footer.php';
?>
