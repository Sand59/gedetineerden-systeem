<?php
$pageTitle = 'Nieuwe gedetineerde';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

echo '<div class="content nieuw">';
?>

<?php if(perm('GED_TOEVOEGEN')): ?>

<form action="../../functions/verwerken.php" method="POST">
    <input type="hidden" name="action" value="addGedetineerde">

    <label for="">Naam</label>
    <input type="text" name="naam" placeholder="Naam" required><br>

    <label for="">Geboortedatum</label>
    <input type="text" name="geboortedatum" placeholder="yyyy-mm-dd" required><br>

    <label for="">Geslacht</label>
    <input type="text" name="geslacht" placeholder="Man/Vrouw" required><br>

    <label for="">Adres</label>
    <input type="text" name="adres" placeholder="Straatnaam, Plaats" required><br>

    <label for="">BSN-nummer</label>
    <input type="text" name="bsn_nummer" placeholder="12345678" required><br>

    <label for="">Gedrag</label>
    <input type="text" name="gedrag" placeholder="Goed/Matig/Slecht" required><br>

    <label for="">Datum arrestatie</label>
    <input type="text" name="datum_arrestatie" placeholder="yyyy-mm-dd" required><br>

    <label for="">Datum aankomst</label>
    <input type="text" name="datum_aankomst" placeholder="yyyy-mm-dd" required><br>

    <label for="">Datum vrijlating</label>
    <input type="text" name="datum_vrijlating" placeholder="yyyy-mm-dd" required><br>

    <label for="">Cel</label>
    <input type="text" name="cel" placeholder="Celnaam" required><br>

    <button class="button" type="submit" name="submit">Toevoegen<img src="/images/icons/new-alt.png"></button>
</form>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om een nieuwe gedetineerde toe te voegen. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
