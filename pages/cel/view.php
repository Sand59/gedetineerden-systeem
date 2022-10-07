<?php
$pageTitle = 'Hekkensluiter';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["cel"])) {
    $cel_nummer = $_GET["cel"];
}
else {
    header('location: ../cellen.php');
}

$objCel = new Cellen($dbconn);
$cel = $objCel->getCel($cel_nummer);
$aantal = $cel->rowCount();
?>

<script>
    document.getElementById('titel').innerHTML = "<?php echo "Cel " . $cel_nummer ?>";
</script>

<?php
echo '<div class="content">';
?>

<?php if(perm('CEL_BEKIJKEN')): ?>

<table class="flex-table">
    <thead>
        <tr>
            <th></th>
            <th>Naam</th>
            <th>Geslacht</th>
            <th>BSN</th>
            <th>Geboortedatum</th>
            <th>Cel</th>
            <th></th>
        </tr>
    </thead>
    <tbody>

<?php
$table = '';
if ($aantal > 0) {
    foreach ($cel as $row) {
        $table .= "<tr>
                            <td>
                                <div class='image-wrapper-table'>
                                    <img src='/images/fotos/foto-01.jpg'>
                                </div>
                            </td>
                            <td data-label='Naam'>".$row['naam']."</td>
                            <td data-label='Geslacht'>".$row['geslacht']."</td>
                            <td data-label='BSN'>".$row['bsn_nummer']."</td>
                            <td data-label='Geboortedatum'>".$row['geboortedatum']."</td>
                            <td data-label='Cel'>".$row['huidige_cel']."</td>
                            <td>
                                <div class='image-wrapper-link'>
                                    <a href='/pages/gedetineerde/view.php?id={$row['id']}'>Bekijken</a>
                                    <img src='/images/icons/open.png'>
                                </div>
                            </td>
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

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bewerken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
