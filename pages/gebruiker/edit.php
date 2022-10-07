<?php
$pageTitle = 'Gebruiker bewerken';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["id"])) {
   $id = $_GET["id"];
}

$objGebruiker = new Gebruiker($dbconn);
$gebruiker = $objGebruiker->getGebruiker($id);
$gebruiker = $gebruiker->fetch();

$objRollen = new Permissions($dbconn);
$rollen = $objRollen->getRollen();
?>

<script>
    document.getElementById('titel').innerHTML = "<?php echo $gebruiker['naam']; ?>";
</script>

<?php
echo '<div class="content nieuw">';
echo $id;
$html = '';
foreach ($rollen as $row) {
   $html .= "<option value='".$row['id']."'>".$row['rol']."</option>";
}
?>

<?php if(perm('GEB_BEWERKEN')): ?>

<form action="../../functions/verwerken.php?id=<?= $id ?>" method="POST">
   <input type="hidden" name="action" value="updateGebruiker">

   <label for="">Naam</label>
   <input type="text" name="naam" value="<?= $gebruiker['naam']; ?>" placeholder="John Doe" required><br>

   <label for="">Inlognaam</label>
   <input type="text" name="inlognaam" value="<?= $gebruiker['inlognaam']; ?>" placeholder="jd" required><br>

   <label for="">Email</label>
   <input type="text" name="email" value="<?= $gebruiker['email']; ?>" placeholder="test@mail.com" required><br>

   <label for="">Rol</label>
   <select id='rol' name='rol' class='custom-select'>
      <option value="<?= $gebruiker["rol"]; ?>"><?= $gebruiker["rol"]; ?></option>
      <?= $html; ?>
   </select>

   <button class="button" type="submit" name="submit">Opslaan<img src="/images/icons/save.png"></button>
</form>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bewerken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
