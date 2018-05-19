<?php
include ('./polaczenie.php');
session_start();

function zapisz($login,$kto,$dane){
    $plik='./dziennik.txt';
    $fp = fopen($plik, 'a');
    $czas=date('d-m-Y H:i:s');
    $zapisz="Login: {$login}\ttyp konta:{$kto}\tpołączenie {$dane}udane\t{$czas}\n";
    fwrite($fp,$zapisz);
    fclose($fp);
}

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
$ilosc;
if(isset($_POST["kto"])=="Pracownik"){
$sql="SELECT id_pracownika,login,haslo FROM Pracownicy where login LIKE ? AND haslo LIKE ?";
$zapytanie=$baza->prepare($sql);
$zapytanie->execute(array($_POST["login"],$_POST["haslo"]));
$ilosc=$zapytanie->rowCount();
}
else{
    $sql="SELECT id_klienta,login,haslo FROM Klienci where login LIKE ? AND haslo LIKE ?";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["login"],$_POST["haslo"]));
    $ilosc=$zapytanie->rowCount();
}

if($ilosc==1){

 $dane=$zapytanie->fetch();
    if(isset($_POST["kto"])=='Pracownik'){      
        $_SESSION["zalogowany"]="Pracownik";
        $_SESSION["login"]=$dane[0];
        zapisz( $_SESSION["login"], $_SESSION["zalogowany"],"");
        header('Location: pracownik.php');
        exit;
    }
    else{     
        $_SESSION["zalogowany"]="Klient";
        $_SESSION["login"]=$dane['id_klienta'];
        zapisz( $_SESSION["login"], $_SESSION["zalogowany"],"");
        header('Location: uzytkownik.php');
        exit; 
    }
}
else{
    $_SESSION['nick']=$_POST['login'];
    $_SESSION['blad']="błędny login bądź hasło";
    zapisz( $_SESSION["nick"], "---","nie");
    if(isset($_POST['kto']))
        $_SESSION['check']="checked";
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
                <form action="zaloguj1.php" method="POST" accept-charset="UTF-8">
                    <p>
                        <input type="text" name="login" value="<?php if(isset($_SESSION['nick'])){ echo $_SESSION['nick']; unset ($_SESSION['nick']);}?>" placeholder="Login" required/>
                    </p>

                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" required/>
                    </p>
                    <p>
                        <label><input type="checkbox" name="kto" value="Pracownik" style="width:20px;" <?php if(isset($_SESSION["check"])){ echo "checked"; unset ($_SESSION["check"]);}?>>Jestem pracownikiem</input></label>
                    </p>
                    <p>
                        <input type="submit" id="zatwierdz" value="Zaloguj" />
                    </p>
                    <p id="zle" style="margin-top:10px;">
                    <?php
                    echo "<span style='color:rgb(148, 6, 6);'>";
                    if(isset($_SESSION["blad"])) { echo $_SESSION["blad"]; unset ($_SESSION["check"]);}
                    echo "</span>";
                    }
                    ?>
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