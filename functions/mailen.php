<?php
use PHPMailer\PHPMailer\PHPMailer;
require '../../include/phpmailer/src/PHPMailer.php';
require '../../include/phpmailer/src/SMTP.php';
require '../../include/phpmailer/src/Exception.php';

function mailen($mailTo, $ontvangerNaam, $onderwerp, $bericht) {
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPAutoTLS = false;

    $mail->Host = 'mail.xxxxxx.hbcdeveloper.nl';
    $mail->Port = 587;

    $mail ->Username = 'xxxxxx';
    $mail ->Password = 'xxxxxx';

    $mail ->isHTML(true);
    $mail->setFrom("xxxxxx@xxxxxx.hbcdeveloper.nl", "Naam");
    $mail->Subject = $onderwerp;
    $mail->CharSet ='UTF-8';

    $bericht = "<body style=\"font-family: Verdana, Verdana, Geneva, sans-serif; font-size: 14px; color: #000;\">" . $bericht . "</body>";

    $mail -> addAddress($mailTo, $ontvangerNaam);
    $mail -> Body = $bericht;

    if ($mail->Send()) {
        echo "<script>alert('Mail is verstuurd');</script>";
        header('refresh: 1; url = ../../pages/login.php');
        exit();
    }

    else {
        echo 'Mailer Error: '.$mail->ErrorInfo;
        echo "<script>alert('Mail kon niet verstuurd worden...');</script>";
        header('refresh: 1; url = ../../pages/login.php');
    }
}
?>
