<?php
$pageTitle = 'Geen gegevens';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');
?>

<div class="profiel-wrapper">

    <?php if(perm('GED_BEKIJKEN')): ?>

    <div class="profiel-image-wrapper">
        <img src="../../images/profiel/gedetineerde.png">
    </div>
    <div class="profiel-gegevens">
        <h2>Gegevens</h2>

        <table class="profiel-table">

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('location: ../gedetineerden.php');
}

// gedetineerde
$objGedetineerde = new Gedetineerde($dbconn);
$gedetineerde = $objGedetineerde->getGedetineerde($id);
$gedetineerdeCel = $objGedetineerde->getGedetineerdeCel($id);
$aantal = $gedetineerde->rowCount();

// bezoeker
$objBezoeker = new Bezoeker($dbconn);
$bezoekers = $objBezoeker->getBezoeker($id);
$gedetineerde = $gedetineerde->fetchAll();
?>

<script>
    document.getElementById('titel').innerHTML = "<?php echo $gedetineerde[0]['naam']; ?>";
</script>

<?php
$geschiedenis = '';
foreach ($gedetineerdeCel as $row) {
    $geschiedenis .= '<div class="celgeschiedenis">
                          <p>Cel '.$row["cel_nummer"].'</p>
                          <p>'.$row["overplaatsing"].'</p>
                      </div>';
};

$bezoeker = '';
foreach ($bezoekers as $row) {
    $bezoeker .= '<div class="bezoekers">
                          <p>'.$row["naam"].'</p>
                          <p>'.$row["datum"].'</p>
                      </div>';
};


$table = '';
if ($aantal > 0) {
    foreach ($gedetineerde as $row) {
        $table .= "<tr>
                            <th>Naam</th>
                            <td data-label='Naam'>".$row['naam']."</td>
                          </tr>
                          <tr>
                            <th>Geboortedatum</th>
                            <td data-label='Geboortedatum'>".$row['geboortedatum']."</td>
                          </tr>
                          <tr>
                            <th>Geslacht</th>
                            <td data-label='Geslacht'>".$row['geslacht']."</td>
                          </tr>
                          <tr>
                            <th>Huidige cel</th>
                            <td data-label='Huidige cel'>".$row['huidige_cel']."</td>
                          </tr>
                          <tr>
                            <th>Celgeschiedenis</th>
                            <td data-label='Celgeschiedenis'>". $geschiedenis ."</td>
                          </tr>
                          <tr>
                            <th>BSN-nummer</th>
                            <td data-label='BSN-nummer'>".$row['bsn_nummer']."</td>
                          </tr>
                          <tr>
                            <th>Zaken</th>
                            <td data-label='Zaken'><a href='zaken/view.php?id={$row['id']}'>Bekijk</a></td>
                          </tr>
                          <tr>
                            <th>Gedrag</th>
                            <td data-label='Gedrag'>".$row['gedrag']."</td>
                          </tr>
                          <tr>
                            <th>Bezoekers</th>
                            <td data-label='Bezoekers'>". $bezoeker ."</td>
                          </tr>
                          <tr>
                            <th>Arrestatie</th>
                            <td data-label='Arrestatie'>".$row['datum_arrestatie']."</td>
                          </tr>
                          <tr>
                            <th>Aankomst</th>
                            <td data-label='Aankomst'>".$row['datum_aankomst']."</td>
                          </tr>
                          <tr>
                            <th>Vrijlating</th>
                            <td data-label='Vrijlating'>".$row['datum_vrijlating']."</td>
                          </tr>";
    }
}

else {
    $table =   '<tr>
                  <td>Geen gegevens</td>
               </tr>';
}

echo $table;
?>

<tr>
   <th>
      <?php
      if(perm('GED_BEWERKEN')) { echo '<a class="button" href="../../pages/gedetineerde/edit.php?id='. $id .'">Bewerken<img src="../../images/icons/edit.png"></a>'; }
      if(perm('GED_VERWIJDER')) { echo '<a class="button" href="../../pages/gedetineerde/delete.php?id='. $id .'">Verwijderen<img src="../../images/icons/trash.png"></a>'; }
      ?>
   </th>
</tr>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
include '../../include/footer.php';
?>
