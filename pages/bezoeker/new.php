<?php
$pageTitle = 'Nieuwe bezoeker';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('location: ../bezoekers.php');
}

$objBezoeker = new Bezoeker($dbconn);
$bezoekers = $objBezoeker->getBezoeker($id);

echo '<div class="content nieuw">';
?>

<?php if(perm('BEZ_TOEVOEGEN')): ?>

<form action="../../functions/verwerken.php?id=<?= $id ?>" method="POST">
    <input type="hidden" name="action" value="addBezoeker">

    <label for="">Naam</label>
    <input type="text" name="naam" placeholder="Naam" required><br>

    <label for="">Datum</label>
    <input type="text" name="datum" placeholder="yyyy-mm-dd" required><br>

    <label for="">Van</label>
    <input type="text" name="tijd_van" placeholder="yyyy-mm-dd" required><br>

    <label for="">Tot</label>
    <input type="text" name="tijd_tot" placeholder="yyyy-mm-dd" required><br>

    <label for="">Email</label>
    <input type="text" name="email" placeholder="example@email.com" required><br>

    <button class="button" type="submit" name="submit">Toevoegen<img src="/images/icons/new-alt.png"></button>
</form>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om een bezoeker te registeren. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
