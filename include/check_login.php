<?php
$file = str_replace(dirname($_SERVER['PHP_SELF']).'/','',$_SERVER['PHP_SELF'] );
$ingelogd = htmlspecialchars($_SESSION['ingelogd']) ?? false;

if (($file!='login.php') AND ($file!='authorisatie.php'))  {
    if (!$ingelogd) {
        session_destroy();
        session_unset();

        header("location: ../pages/login.php");
        exit;
    }
}
?>
