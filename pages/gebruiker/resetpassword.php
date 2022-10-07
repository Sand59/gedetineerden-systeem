<?php
include '../../include/database.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Hekkensluiter</title>
        <link rel="stylesheet" href="../../css/master.css">
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
                <form name="Wachtwoord resetten" action="" method="post">
                    <input type="email" name="email" placeholder="E-mail"><br>
                    <input type="password" name="wachtwoord1" placeholder="Nieuw wachtwoord"><br>
                    <input type="password" name="wachtwoord2" placeholder="Herhaal nieuw wachtwoord"><br>
                    <input type="submit" name="versturen" value="submit">
                </form>
                <div class="login-terug">
                    <a href="../login.php"><img src="/images/icons/arrow-left.png" alt="">Terug</a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
if(isset($_POST['versturen'])) {
    if (isset($_GET['token']) && isset($_GET['timestamp'])) {
        $token = $_GET['token'];
        $timestamp1 = $_GET['timestamp'];
        $melding = "";

        if (htmlspecialchars($_POST['email']) && htmlspecialchars($_POST['wachtwoord1']) && htmlspecialchars($_POST['wachtwoord2'])) {
            $email = htmlspecialchars($_POST['email']);
            $wachtwoord_hash = password_hash($_POST['wachtwoord1'], PASSWORD_DEFAULT);

            if ($wachtwoord !== $wachtwoord2) {
                echo "<script>alert('Wachtwoord komt niet overeen');</script>";
                exit();
            }

            try {
                $sql = "SELECT * FROM gebruiker WHERE email = ? AND token = ?";
                $stmt = $dbconn->prepare($sql);
                $result = $stmt->execute(array($email, $token));

                if ($result) {
                    $timestamp2 = new DateTime('now');
                    $timestamp2 = $timestamp2->getTimestamp();
                    $dif = $timestamp2 - $timestamp1;

                    if ($dif < 43200) {
                        $query = "UPDATE gebruiker SET wachtwoord = ? WHERE email = ?";
                        $stmt = $dbconn->prepare($query);
                        $result = $stmt->execute(array($wachtwoord_hash, $email));

                        if ($result) {
                            echo "<script>alert('Wachtwoord is gereset');</script>";
                            header('refresh: 1; url = ../login.php');
                        }
                        else {
                            echo "<script>alert('Wachtwoord is niet gereset');</script>";
                        }
                    }

                    else {
                        echo "<script>alert('Vraag een nieuwe mail aan wachtwoord is verlopen');</script>";
                    }
                }
            }

            catch (PSOExeption $e) {
                echo $e->getMessage();
            }
        }

        else {
            echo "<script>alert('Niet alles is correct ingevuld');</script>";
        }
    }
}
?>
