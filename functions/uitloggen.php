<?php
include '../include/database.php';

session_start();
session_destroy();
session_unset();

header('location: ../pages/login.php');
?>
