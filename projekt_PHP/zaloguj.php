<?php
include ('./polaczenie.php');
session_start();

if(isset($_SESSION["zalogowany"]) && isset($_SESSION["login"])){
    if($_SESSION["zalogowany"]=="Pracownik"){
        header('Location: pracownik.php');
        exit;
    }

    else if($_SESSION["zalogowany"]=="Klienci"){
        header('Location: uzytkownik.php');
        exit;
    }

}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Siemion Airlines</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>Logowanie</title>
    <meta name="description" content="Rejestracja do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" href="zaloguj.css" />
</head>

<body>

    <div id="kontener">
        <div id="logowanie">

            <fieldset>
                <legend>Logowanie</legend>
                <form action="zaloguj1.php" method="POST">
                    <p>
                        <input type="text" name="login" placeholder="Login" required/>
                    </p>

                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" required/>
                    </p>
                    <p>
                        <label><input type="checkbox"name="kto" value="Pracownik" style="width:20px;">Jestem pracownikiem</label>
                    </p>

                    <p>
                        <input type="submit" id="zatwierdz" value="Zaloguj" />
                    </p>
                </form>
            </fieldset>
            <div id="odsylacz">
                <div id="powrot"><a href="index1.php">Powrót</a></div>
                <div style="cler:both;"></div>
                <div id="rejestracja"><a href="zarejestruj.php">Rejestracja</a></div>
            </div>
        </div>
    </div>

</body>

</html>