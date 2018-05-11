<?php
include ('./polaczenie.php');

try{

    $baza=new PDO(DSN,UZYTKOWNIK,HASLO);
}
catch(PDOException $e){
    echo "Bląd połączenia; ".$e->getMessage();
}
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>Rejestracja</title>
    <meta name="description" content="Rejestracja do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="zarejestruj.css" type="text/CSS">
</head>

<body>
    <div id="kontener">
        <div id="rejestracja">

            <fieldset>
                <legend>Rejestracja</legend>
                <form action="rejestruj.php" method="POST">
                    <p>
                        <input type="text" name="imie" placeholder="Imię" require />
                    </p>

                    <p>
                        <input type="text" name="nazwisko" placeholder="Nazwisko" require />
                    </p>

                    <p>
                        <input type="text" name="pesel" placeholder="Pesel lub nr dowodu osobistego" require />
                    </p>

                    <p>
                        <input type="email" name="mail" placeholder="E-mail" require/>
                    </p>
                    <p>
                        <input type="tel" name="telefon" placeholder="Telefon" require/>
                    </p>
                    <hr/>
                    <p>
                        <input type="login" name="login" placeholder="Login" require/>
                    </p>
                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" require/>
                    </p>

                    <p>
                        <input type="submit" id="zatwierdz" content="Zaloguj" require/>
                    </p>
                </form>
            </fieldset>
            <div id="odsylacz">
                Jeśli masz już konto to
                <a href="zaloguj.html">zaloguj się</a>
            </div>
        </div>
    </div>

</body>

</html>