<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Hekkensluiter</title>
        <link rel="stylesheet" href="/css/master.css">
        <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.png">
    </head>
    <body>
        <div class="login">
            <div class="login-left">
                <img src="/images/login-background.png" alt="">
            </div>
            <div class="login-right">
                <h2>Inloggen</h2>
                <form action="/functions/authorisatie.php" method="POST">
                    <input type="text" name="inlognaam" id="inlognaam" size="25" placeholder="inlognaam"><br>
                    <input type="password" id="wachtwoord" name="wachtwoord" size="25" placeholder="wachtwoord"><br>
                    <a class="wachtwoord-link" href="/pages/gebruiker/forgotpassword.php">Wachtwoord vergeten...</a>
                    <input type="submit" name="submit" value="login"><br><br>
                </form>
                <div class="login-terug">
                    <a href="/Project/klantenportaal/index.html"><img src="/images/icons/arrow-left.png" alt="">Terug</a>
                </div>
            </div>
        </div>
    </body>
</html>
