<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pageTitle = 'RFID registreren';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

echo '<div class="content nieuw">';
?>

<?php if(perm('BEZ_BEKIJKEN')): ?>

    <form action="/functions/verwerken.php" method="POST">
        <input type="hidden" name="action" value="addBezoekerMedewerker">

        <label for="">RFID ID</label>
        <input type="text" name="rfid" placeholder="Voer hier de RFID code in" maxlength="12" minlenght="12" required><br>

        <label for="">Naam</label>
        <input type="text" name="naam" placeholder="John Doe" required><br>

        <label for="">Email</label>
        <input type="text" name="email" placeholder="example@mail.com" required><br>

        <button class="button" type="submit" name="submit">Toevoegen<img src="/images/icons/new-alt.png"></button>
    </form>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om een bezoeker te registeren. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>
