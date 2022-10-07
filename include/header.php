<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// autoloader nog toevoegen
require_once 'database.php';
include($_SERVER['DOCUMENT_ROOT'].'/include/check_login.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Gedetineerde.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Cellen.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Gebruiker.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Bezoeker.php');
include($_SERVER['DOCUMENT_ROOT'].'/classes/Permissions.php');

function perm($perm_code) {
   global $dbconn;
   $objPermissions = new Permissions($dbconn);
   $result = $objPermissions->checkPermission($perm_code);
   return $result;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Hekkensluiter</title>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/css/master.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- scripts -->
        <script>
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                document.getElementById("header").style.height = "150px";
            }
            else {
                document.getElementById("header").style.height = "250px";
            }
        }
        </script>
    </head>
    <body>
         <?php include($_SERVER['DOCUMENT_ROOT'].'/include/sidebar.php'); ?>

         <div class="wrapper">
            <header id="header">
               <div class="header-content">
                  <div class="header-content-items">
                     <a href="/pages/home.php"><h1 id="titel"><?php echo $pageTitle; ?></h1></a>
                     <a id="aantal" class="desc" href="javascript:history.back()"><img src='/images/icons/arrow-left.png'>Terug</a>
                  </div>
                  <div class="header-content-items uitloggen">
                     <a class="desc" href="/functions/uitloggen.php">Uitloggen<img src='/images/icons/log-out.png'></a>
                  </div>
                  <div id="menu" class="header-content-items hamburger-menu">
                     <img id="menu-icon" src='/images/icons/menu.png'>
                  </div>
               </div>
            </header>

            <script>
            const hamburger = document.getElementById("menu")
            const sidebar = document.getElementById("sidebar")
            const header = document.getElementById("header")
            const closeIcon = document.getElementById("menu-icon")

            hamburger.addEventListener('click', function(){
               sidebar.classList.toggle('responsive-sidebar')
               header.classList.toggle('responsive-header')

               if (header.classList.contains('responsive-header')) {
                  closeIcon.src = '/images/icons/close.png'
               } else {
                  closeIcon.src = '/images/icons/menu.png'
               }
            })
         </script>
