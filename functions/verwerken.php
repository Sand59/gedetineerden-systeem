<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../include/database.php';
include '../classes/Gedetineerde.php';
include '../classes/Permissions.php';
include '../classes/Bezoeker.php';
include '../classes/Gebruiker.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = htmlspecialchars($_POST['action']) ?? null;
    switch ($action) {
        case "updateGedetineerde":
            updateGedetineerde();
            break;

        case "addBezoeker":
            addBezoeker();
            break;

        case "addGedetineerde":
            addGedetineerde();
            break;

        case "addGebruiker":
            addGebruiker();
            break;

        case "updateRol":
            updateRol();
            break;

        case "updateGebruiker":
            updateGebruiker();
            break;

        case "addBezoekerMedewerker":
            addBezoekerMedewerker();
            break;

        default:
            echo "Er gaat iets fout, neem contact op met de beheerder";
    }
}

else {
    header('url = ../pages/gedetineerden.php');
}

// adres toevoegen en sql injection
function updateGedetineerde() {
    global $dbconn;
    $naam = htmlspecialchars($_POST['naam']) ?? null;
    $geboortedatum = htmlspecialchars($_POST['geboortedatum']) ?? null;
    $geslacht = htmlspecialchars($_POST['geslacht']) ?? null;
    $huidige_cel = htmlspecialchars($_POST['huidige_cel']) ?? null;
    $bsn_nummer = htmlspecialchars($_POST['bsn_nummer']) ?? null;
    $gedrag = htmlspecialchars($_POST['gedrag']) ?? null;
    $datum_arrestatie = htmlspecialchars($_POST['datum_arrestatie']) ?? null;
    $datum_aankomst = htmlspecialchars($_POST['datum_aankomst']) ?? null;
    $datum_vrijlating = htmlspecialchars($_POST['datum_vrijlating']) ?? null;
    $id = htmlspecialchars($_GET['id']) ?? null;

    $objGedetineerde = new Gedetineerde($dbconn);
    $gedetineerde = $objGedetineerde->updateGedetineerde($naam, $geboortedatum, $geslacht, $huidige_cel, $bsn_nummer, $gedrag, $datum_arrestatie, $datum_aankomst, $datum_vrijlating, $id);

    if ($gedetineerde) {
        header('location: ../pages/gedetineerde/view.php?id='.$id.'');
        exit();
    }

    else {
        echo "<p>{$naam} is niet aangepast</p><br>";
        header('refresh: 1; url = ../pages/gedetineerden.php');
        exit();
    }
}

function addBezoekerMedewerker() {
    global $dbconn;
    $rfid = htmlspecialchars($_POST['rfid']) ?? null;
    $naam = htmlspecialchars($_POST['naam']) ?? null;
    $email = htmlspecialchars($_POST['email']) ?? null;

    $objBezoeker = new Bezoeker($dbconn);
    $bezoeker = $objBezoeker->addBezoekerMedewerker($rfid, $naam, $email);

    if ($bezoeker) {
        header('location: /pages/bezoeker/geregistreerd.php');
        exit();
    }

    else {
        echo "<p>{$naam} is niet toegevoegd, er is waarschijnlijk iets fout gegaan</p><br>";
        header('location: /pages/bezoeker/geregistreerd.php');
        exit();
    }
}

function addGebruiker() {
   global $dbconn;
   $naam = htmlspecialchars($_POST['naam']) ?? null;
   $inlognaam = htmlspecialchars($_POST['inlognaam']) ?? null;
   $wachtwoord = htmlspecialchars($_GET['wachtwoord']) ?? null;
   $wachtwoord_hash = password_hash($_POST['wachtwoord1'], PASSWORD_DEFAULT);
   $email = htmlspecialchars($_POST['email']) ?? null;
   $rol = htmlspecialchars($_POST['rol']) ?? null;

   $objGebruiker = new Gebruiker($dbconn);
   $gebruiker = $objGebruiker->addGebruiker($naam, $inlognaam, $wachtwoord_hash, $email, $rol);

   if ($gebruiker) {
       header('location: ../pages/gebruikers.php');
       exit();
   }

   else {
       echo "<p>{$naam} is niet toegevoegd, er is waarschijnlijk iets fout gegaan</p><br>";
       header('location: ../pages/gebruikers.php');
       exit();
   }
}

function updateGebruiker() {
   global $dbconn;
   $naam = htmlspecialchars($_POST['naam']) ?? null;
   $inlognaam = htmlspecialchars($_POST['inlognaam']) ?? null;
   $email = htmlspecialchars($_POST['email']) ?? null;
   $rol = htmlspecialchars($_POST['rol']) ?? null;
   $id = htmlspecialchars($_GET['id']) ?? null;

   $objGebruiker = new Gebruiker($dbconn);
   $gebruiker = $objGebruiker->updateGebruiker($naam, $inlognaam, $email, $rol, $id);

   if ($gebruiker) {
       header('location: ../pages/gebruikers.php');
       exit();
   }

   else {
       echo "<p>{$naam} is niet aangepast, er is waarschijnlijk iets fout gegaan</p><br>";
       header('location: ../pages/gebruikers.php');
       exit();
   }
}

function addBezoeker() {
    global $dbconn;
    $naam = htmlspecialchars($_POST['naam']) ?? null;
    $datum = htmlspecialchars($_POST['datum']) ?? null;
    $id = htmlspecialchars($_GET['id']) ?? null;
    $tijd_van = htmlspecialchars($_POST['tijd_van']) ?? null;
    $tijd_tot = htmlspecialchars($_POST['tijd_tot']) ?? null;
    $email = htmlspecialchars($_POST['email']) ?? null;

    $objBezoeker = new Bezoeker($dbconn);
    $bezoeker = $objBezoeker->addBezoeker($naam, $datum, $id, $tijd_van, $tijd_tot, $email);

    if ($bezoeker) {
        header('location: ../pages/bezoeker/view.php?id='.$id.'');
        exit();
    }

    else {
        echo "<p>{$naam} is niet toegevoegd, er is waarschijnlijk iets fout gegaan</p><br>";
        header('refresh: 2; url = ../pages/bezoeker/view.php?id='.$id.'');
        exit();
    }
}

function addGedetineerde() {
    global $dbconn;
    $naam = htmlspecialchars($_POST['naam']) ?? null;
    $geboortedatum = htmlspecialchars($_POST['geboortedatum']) ?? null;
    $geslacht = htmlspecialchars($_POST['geslacht']) ?? null;
    $adres = htmlspecialchars($_POST['adres']) ?? null;
    $bsn_nummer = htmlspecialchars($_POST['bsn_nummer']) ?? null;
    $gedrag = htmlspecialchars($_POST['gedrag']) ?? null;
    $datum_arrestatie = htmlspecialchars($_POST['datum_arrestatie']) ?? null;
    $datum_aankomst = htmlspecialchars($_POST['datum_aankomst']) ?? null;
    $datum_vrijlating = htmlspecialchars($_POST['datum_vrijlating']) ?? null;
    $cel = htmlspecialchars($_POST['cel']) ?? null;

    $objGedetineerde = new Gedetineerde($dbconn);
    $gedetineerde = $objGedetineerde->addGedetineerde($naam, $geboortedatum, $geslacht, $adres, $bsn_nummer, $gedrag, $datum_arrestatie, $datum_aankomst, $datum_vrijlating, $cel);

    if ($gedetineerde) {
        header('location: ../pages/gedetineerden.php');
        exit();
    }

    else {
        echo "<p>{$naam} is niet toegevoegd</p><br>";
        header('refresh: 2; url = ../pages/gedetineerden.php');
        exit();
    }
}

function updateRol() {
   global $dbconn;

   $objPermissions = new Permissions($dbconn);

   // get rollen
   $rollen = $objPermissions->getRollen();

   foreach ($rollen as $row) {
      // get permissions
      $permissions = $objPermissions->getPermissions();

      $rolId = $row['id'];

      foreach ($permissions as $row2) {
         $permId = $row2['perm_id'];

         // checked checkboxes
         $rol = $row['rol'].$permId;
         $checked = isset($_POST[$rol]);

         // set rollen
         $objPermissions->setRollen($checked, $rolId, $permId);
      }
   }

   header('location: /pages/rollen.php');
   exit();
}
?>
