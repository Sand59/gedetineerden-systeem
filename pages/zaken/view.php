<?php
$pageTitle = 'Zaken / Naam';
include($_SERVER['DOCUMENT_ROOT'].'/include/header.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('location: ../zaken.php');
}

$objGedetineerde = new Gedetineerde($dbconn);
$gedetineerde = $objGedetineerde->getGedetineerde($id);
$gedetineerde = $gedetineerde->fetch();
?>

<script>
    document.getElementById('titel').innerHTML = "<?php echo "Zaken / ". $gedetineerde['naam'] ?>";
</script>

<?php
echo '<div class="content zaken-container">';
?>

<?php if(perm('ZAKEN_BEKIJKEN')): ?>

<?php if(perm('ZAKEN_TOEVOEGEN')): ?>
   <form method="POST" enctype="multipart/form-data">
      <input id="file" type="file" name="file">
      <label class="upload-icon" for="file"><img src="/images/icons/upload.png">Kies bestand</label>
      <input type="submit" value="Toevoegen" name="submit">
   </form>
<?php endif; ?>

<?php
if (isset($_GET["id"])) {
    $id = $_GET["id"];
}
else {
    header('refresh: 1; url=zaken/view.php');
}

if (isset($_POST["submit"])) {
    // waardes aangeven
    $target_dir = "../../bestanden/$id/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // check of er al mapje is
    if (!file_exists("../../bestanden/$id")) {
        mkdir("../../bestanden/$id", 0777, true);
    }

    // check of bestandsnaam al bestaat in mapje
    if (!file_exists($target_file)) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          echo "Het bestand is geupload<br>";
        }
        else {
            echo "Het bestand is niet geupload<br>";
        }
    }
    else {
        echo "Bestandsnaam bestaat al<br>";
    }
}

echo "<div class='zaken'>";

if (file_exists("../../bestanden/$id")) {
    $d = opendir("../../bestanden/$id");
    while ($bestanden = readdir($d)) {
        $bnaam = "../../bestanden/$id/".$bestanden;
        if (is_file($bnaam)) {
            echo "<div class='zaken-items'><a href='$bnaam' target='_blank'>$bestanden</a><a href='$bnaam' target='_blank'>Openen</a></div>";
        }
    }
    closedir($d);
}

else {
    echo "Geen zaken gevonden";
}
?>

<?php else: ?>
   <p>Je hebt niet de juiste rechten om dit te bekijken. Klik <a class="no-perm" href="/pages/home.php">hier</a> om terug te gaan naar de homepagina.</p>
<?php endif; ?>

<?php
echo '</div>';
include '../../include/footer.php';
?>
