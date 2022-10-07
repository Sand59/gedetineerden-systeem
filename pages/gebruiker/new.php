<?php
$pageTitle = 'Nieuwe gedetineerde';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

$objRollen = new Permissions($dbconn);
$rollen = $objRollen->getRollen();

echo '<div class="content nieuw">';

$html = '';
foreach ($rollen as $row) {
   $html .= "<option value='".$row['id']."'>".$row['rol']."</option>";
}
?>

<?php if(perm('GEB_TOEVOEGEN')): ?>

<form action="../../functions/verwerken.php" method="POST">
    <input type="hidden" name="action" value="addGebruiker">

    <label for="">Naam</label>
    <input type="text" name="naam" placeholder="John Doe" required><br>

    <label for="">Inlognaam</label>
    <input type="text" name="inlognaam" placeholder="jd" required><br>

    <label for="">Wachtwoord</label>
    <input type="text" name="wachtwoord" placeholder="wachtwoord" required><br>

    <label for="">Email</label>
    <input type="text" name="email" placeholder="test@mail.com" required><br>

    <label for="">Rol</label>
    <select id='rol' name='rol' class='custom-select'><?= $html; ?></select>

    <button class="button" type="submit" name="submit">Toevoegen<img src="/images/icons/new-alt.png"></button>
</form>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
