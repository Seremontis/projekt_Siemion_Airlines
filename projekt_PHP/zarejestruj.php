<?php
session_start();
include ('./polaczenie.php');
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>Rejestracja</title>
    <meta name="description" content="Rejestracja klienta do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" href="zarejestruj.css" type="text/CSS">
</head>

<body>
    <div id="kontener">
        <div id="rejestracja">

            <fieldset>
                <legend>Rejestracja</legend>
                <form action="rejestruj.php" method="POST">
                    <p style="font-size:12px; color: #ffff66; font-weight:bold;"><?php if(isset($_SESSION['blad'])) {echo $_SESSION["blad"]; unset($_SESSION['blad']);} ?></p>
                    <p>
                        <input type="text" name="imie" value="<?php if(isset($_SESSION['imie'])) { echo $_SESSION["imie"]; unset ($_SESSION["imie"]);} ?>" placeholder="Imię" required />
                    </p>

                    <p>
                        <input type="text" name="nazwisko"  value="<?php if(isset($_SESSION['nazwisko'])) { echo $_SESSION["nazwisko"]; unset ($_SESSION["nazwisko"]);} ?>"  placeholder="Nazwisko" required />
                    </p>

                    <p>
                        <input type="text" name="pesel" value="<?php if(isset($_SESSION['pesel'])) { echo $_SESSION["pesel"]; unset ($_SESSION["pesel"]);} ?>"  placeholder="Pesel lub nr dowodu osobistego" required />
                    </p>

                    <p>
                        <input type="email" name="mail" value="<?php if(isset($_SESSION['mail'])) { echo $_SESSION["mail"]; unset ($_SESSION["mail"]);} ?>" placeholder="E-mail" require/>
                    </p>
                    <p>
                        <input type="tel" name="telefon"  value="<?php if(isset($_SESSION['telefon'])) { echo $_SESSION["telefon"]; unset ($_SESSION["telefon"]);} ?>"  placeholder="Telefon" required/>
                    </p>
                    <hr/>
                    <p>
                        <input type="login" name="login"  value="<?php if(isset($_SESSION['login'])) { echo $_SESSION["login"]; unset ($_SESSION["login"]);} ?>"  placeholder="Login" required/>
                    </p>
                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" required/>
                    </p>

                    <p>
                        <input type="submit" id="zatwierdz" value="Zarejestruj" />
                    </p>
                </form>
            </fieldset>
            <div id="odsylacz">
                <p>Jeśli masz już konto to
                <a href="zaloguj.php">zaloguj się</a></p>
                <p>Jeśli jesteś pracownikiem i nie masz jeszcze konta skontaktuj się z administratorem</p>
            </div>
        </div>
    </div>

</body>

</html>