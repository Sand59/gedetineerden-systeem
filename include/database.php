<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$database = 'hekkensluiter';
$user = 'root';
$password = '';

try {
    $dbconn = new PDO("mysql:host=$host; dbname=$database", $user, $password);
    $dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbconn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}

catch(PDOException $e) {
    // add 500 page
    echo $e->getMessage();
    echo "connection failed";
}
?>
