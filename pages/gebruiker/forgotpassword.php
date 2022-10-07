<?php
include '../../include/database.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Hekkensluiter</title>
        <link rel="stylesheet" href="/images/master.css">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.png">
    </head>
    <body>
        <div class="login">
            <div class="login-left">
                <img src="/images/login-background.png" alt="">
            </div>
            <div class="login-right">
                <h2>Nieuw wachtwoord</h2>
                <form action="" enctype="multipart/form-data" method="post">
                    <input type="email" name="e-mail" placeholder="e-mail"><br><br>
                    <div class="g-recaptcha" data-sitekey="6LcKyVkfAAAAAG3QsNZKxYFb0CMZ7iSK5bAjWvG6">
                    </div><br>
                    <input type="submit" name="submit" value="submit">
                </form>
                <div class="login-terug">
                    <a href="/pages/login.php"><img src="/images/icons/arrow-left.png" alt="">Terug</a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
if (isset($_POST['submit'])) {
    $melding = "";
    $email = htmlspecialchars($_POST['e-mail']);

    $secretKey = "6LcKyVkfAAAAAD3JEI_MDJXuslJ_WG-rH8h0LJpH";
    $responseKey = $_POST['g-recaptcha-response'];
    $userIP= $_SERVER['REMOTE_ADDR'];

    // Aanroepen api:
    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$responseKey&remoteip=$userIP";
    $response = file_get_contents($url);
    $response = json_decode($response);

    if (!$response->success) {
        echo "<script>alert('reCHAPTCHA failed');</script>";
        exit();
    }

    // Timestamp
    $token = bin2hex(random_bytes(32));
    $timestamp = new DateTime("now");
    $timestamp = $timestamp->getTimestamp();

    // Token opslaan
    try {
        $sql = "UPDATE gebruiker SET token = ? WHERE email = ?";
        $stmt = $dbconn->prepare($sql);
        $stmt = $stmt->execute(array($token, $email));

        if (!$stmt) {
            echo "<script>alert('Kon niet opslaan in de datebase');</script>";
        }
    }

    catch (PDOException $e) {
        echo $e->getMessage();
    }

    // URL configureren
    $url = sprintf("%s://%s", isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']!='of-f'?'https':'http',$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."./wachtwoord_resetten.php");
    $url = 'https://www.43383.hbcdeveloper.nl/pages/gebruiker/resetpassword.php';

    // Token en timestamp toevoegen
    $url = $url."?token=".$token."&timestamp=".$timestamp;

    // URL mailen
    include("../../functions/mailen.php");
    $onderwerp = "Wachtwoord resetten";
    $bericht = "<p>Als je je wachtwoord wilt resetten klik <a href=".$url.">hier</a></p>";

    try {
        mailen($email, "klant", $onderwerp, $bericht);
        $melding = 'Open je mail om verder te gaan';
    }

    catch (Exception $e) {
        $melding = 'Kon geen mail versturen - ' + $mail->ErrorInfo;
    }

    echo $melding;
}
?>
