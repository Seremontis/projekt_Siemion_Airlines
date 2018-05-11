<?php
include ('./polaczenie.php');

try{

    $baza=new PDO(DSN,UZYTKOWNIK,HASLO);

}
catch(PDOException $e){
    echo "Bląd połączenia; ".$e->getMessage();
} 
if($_POST["kto"]=="Klient"){
$sql="SELECT login,haslo FROM Klienci where login LIKE ? AND haslo LIKE ?";
$zapytanie=$baza->prepare($sql);
$zapytanie->execute(array($_POST["login"],$_POST["haslo"]));
}
else{
    $sql="SELECT login,haslo FROM Pracownicy where login LIKE ? AND haslo LIKE ?";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["login"],$_POST["haslo"]));
}
$ilosc=$zapytanie->rowCount();
if($ilosc>0){
    if($_POST["kto"]=="Klient"){
    header('Location: uzytkownik.html');
    exit;
    }
    else{
        header('Location: index.php');
        exit;   
    }
}
else{
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
    <link rel="stylesheet" type="text/css" href="zaloguj.css" />
</head>

<body>

    <div id="kontener">
        <div id="logowanie">

            <fieldset>
                <legend>Logowanie</legend>
                <form action="zaloguj1.php" method="POST" accept-charset="UTF-8">
                    <p>
                        <input type="text" name="login" placeholder="Login" required/>
                    </p>

                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" required/>
                    </p>
                    <p>
                        <input type="hidden" name="kto" value="Klient" />
                        <input type="checkbox" name="kto" value="Pracownik"style="width:20px;">Jestem pracownikiem</input>
                    </p>
                    <p>
                        <input type="submit" id="zatwierdz" content="Zaloguj" />
                    </p>
                    <p id="zle" style="margin-top:10px;">
                    <?php
                    echo '<span style="color:rgb(148, 6, 6);">Nieprawidłowy login bądź hasło</span>';
                    }
                    ?>
                    </p>
                </form>
            </fieldset>
            <div id="odsylacz">
                <a href="zarejestruj.php">Rejestracja</a>
            </div>
        </div>
    </div>

</body>

</html>