<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../../include/database.php';
include '../../../classes/Bezoeker.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $objBezoeker = new Bezoeker($dbconn);
    $bezoeker = $objBezoeker->getDruppel($id);

    if($bezoeker) {
        // Bezoeker bestaat
        $status = $objBezoeker->bezoekerGeschiedenis($id);

        if($status == 'in') {
            echo json_encode(['success' => true, 'message' => 'Welkom']);
            exit();
        }
        else if($status == 'uit') {
            echo json_encode(['success' => true, 'message' => 'Tot ziens']);
            exit();
        }
    }
    else {
        // Bezoeker bestaat niet
        echo json_encode(['success' => false, 'error' => 'Deze rfid druppel is niet bij ons geregisteerd']);
        exit();
    }
}
?>
