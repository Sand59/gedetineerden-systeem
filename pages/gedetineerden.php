<?php
$pageTitle = 'Gedetineerden';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objGedetineerde = new Gedetineerde($dbconn);
$gedetineerde = $objGedetineerde->getGedetineerden();
$aantal = $gedetineerde->rowCount();
?>

<script>
    document.getElementById('aantal').innerHTML = "<?php echo $aantal . ' records gevonden'; ?>";
</script>

<?php
echo '<div class="content">';
?>

<?php if(perm('GED_BEKIJKEN')): ?>

<table class="flex-table">
    <thead>
        <tr>
            <th></th>
            <th>Naam</th>
            <th>Geslacht</th>
            <th>BSN</th>
            <th>Geboortedatum</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php
$table = "";

if ($aantal > 0) {
    foreach ($gedetineerde as $row) {
        $table .= "<tr>
                      <td><div class='image-wrapper-table'><img src='/images/fotos/foto-01.jpg'></div></td>
                      <td data-label='Naam'>".$row['naam']."</td>
                      <td data-label='Geslacht'>".$row['geslacht']."</td>
                      <td data-label='BSN'>".$row['bsn_nummer']."</td>
                      <td data-label='Geboortedatum'>".$row['geboortedatum']."</td>
                      <td><div class='image-wrapper-link'><a href='gedetineerde/view.php?id={$row['id']}'>Bekijken</a><img src='/images/icons/open.png'></div></td>
                  </tr>";
    }
}

else {
    $table = '<tr>
                  <td>Geen gegevens</td>
              </tr>';
}

$table .= '</table></tbody>';
echo $table;
?>

<div class="add">
   <?php if(perm('GED_TOEVOEGEN')): ?>
      <a href="gedetineerde/new.php">Nieuwe gedetineerde<img src="/images/icons/new.png"></a>
   <?php endif; ?>
</div>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>


<?php
echo '</div>';

include '../include/footer.php';
?>
