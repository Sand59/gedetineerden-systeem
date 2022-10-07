<?php
session_start();
include '../include/database.php';
include '../classes/Gebruiker.php';
include '../classes/Authenticator.php';

if ($_POST['submit']) {
    $inlognaam = htmlspecialchars($_POST['inlognaam']) ?? null;
    $wachtwoord = htmlspecialchars($_POST['wachtwoord']) ?? null;
}

else {
    header('refresh: 1, ../pages/login.php');
}

$objGebruiker = new Gebruiker($dbconn);
$gebruikers = $objGebruiker->getGebruikerLogin($inlognaam);

if ($gebruikers->rowCount() !== 1) {
    echo "<script>alert('Uw inlognaam of wachtwoord is onjuist');</script>";

    session_destroy();
    session_unset();

    header('refresh: 1; url = ../pages/login.php');
    exit;
}

$gebruikers = $gebruikers->fetch();
$wachtwoord_hash = $gebruikers['wachtwoord'];

if (!password_verify($wachtwoord, $wachtwoord_hash)) {
    echo "<script>alert('Uw inlognaam of wachtwoord is onjuist');</script>";

    session_destroy();
    session_unset();

    header('refresh: 1; url = ../pages/login.php');
    exit;
}

else {
    $_SESSION['inlognaam'] = $inlognaam;
    $_SESSION['naam'] = $gebruikers['naam'];
    $_SESSION['wachtwoord'] = $wachtwoord;
    $_SESSION['rol'] = $gebruikers['rol'];
    $_SESSION['rol_id'] = $gebruikers['rol_id'];
    $_SESSION['id'] = $gebruikers['id'];

    if ($gebruikers['auth_secret'] != null) {
      $_SESSION['auth_secret'] = $gebruikers['auth_secret'];
      $_SESSION['auth_qr'] = false;
    }
    
    else {
      $authenticator = new Authenticator($dbconn);
      
      $secret = $authenticator->generateRandomSecret();
      $newSecret = $authenticator->addAuthSecret($secret, $_SESSION['id']);
      $gebruikers = $objGebruiker->getGebruikerLogin($inlognaam);
      $gebruikers = $gebruikers->fetch();

      $_SESSION['auth_secret'] = $gebruikers['auth_secret'];
      $_SESSION['auth_qr'] = true;
    }

    header('location: ../functions/2fa.php');
    exit;
}
?>
