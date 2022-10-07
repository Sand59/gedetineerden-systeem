<?php
session_start();

include '../include/database.php';
include '../classes/Authenticator.php';

$authenticator = new Authenticator($dbconn);

$naam = $_SESSION['naam'];
$QRtitle = "Hekkensluiter ({$naam})";
$QRcode = $authenticator->getQR($QRtitle, $_SESSION['auth_secret']);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Hekkensluiter</title>
        <link rel="stylesheet" href="/css/master.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.png">
    </head>
    <body>
        <div class="qr-code">
            <div class="qr-code-container">
               <form method="POST">
                  <h3>Hallo <?php echo $naam ?></h3>
                  <p>Vul de verkregen code in</p>
                  <?php if($_SESSION['auth_qr'] == true) {
                     echo "<img src='".$QRcode."' alt=''>";
                  } ?>
                  <input name="code" pattern="[0-9]*" placeholder="" type="text" maxlength="6">
                  <p id="invalid">Code is niet juist</p>
                  <button name="submit" type="submit" class="button">Verify</button>
               </form>
            </div>
        </div>
    </body>
</html>

<?php
if (isset($_POST['submit']) && !empty($_POST['code'])) {
   $checkResult = $authenticator->verifyCode($_SESSION['auth_secret'], $_POST['code'], 2);

   if($checkResult) {
      $_SESSION['ingelogd'] = true;

      header('location: /pages/home.php');
      exit();
   }
   else {
      echo "<script>document.getElementById('invalid').style.display = 'block'</script>";
   }
}
?>
