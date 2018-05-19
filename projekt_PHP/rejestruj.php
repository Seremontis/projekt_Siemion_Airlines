<?php
session_start();


?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="rejestruj.css">
</head>

    <body>
<div id="konetener">
<?php

/*$haslo = sha1($_POSTP["haslo"]);*/

include ('./polaczenie.php');

$spr="SELECT id_klienta FROM klienci WHERE PESEL=? OR mail=? OR telefon=? OR login=?";
$zapytanie=$baza->prepare($spr);
$zapytanie->execute(array($_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login']));
$ilosc=$zapytanie->rowCount();


if($ilosc==0){
$sql="INSERT INTO Klienci(imie,nazwisko,pesel,mail,telefon,login,haslo) values (?,?,?,?,?,?,?)";
$zapytanie=$baza->prepare($sql);
$zapytanie->execute(array($_POST["imie"],$_POST['nazwisko'],$_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login'],$_POST['haslo']));

$ilosc=$zapytanie->rowCount();

if($ilosc==1){
    echo "<script>alert('Rejestracja zakończona pozytywnie <br/> Teraz możesz się zalogować');</script>";
    header('Location: index1.php');
    exit;

}
else{
    $_SESSION["imie"]=$_POST["imie"];
    $_SESSION["nazwisko"]=$_POST['nazwisko'];
    $_SESSION["pesel"]=$_POST['pesel'];
    $_SESSION["mail"]=$_POST['mail'];
    $_SESSION["telefon"]=$_POST['telefon'];
    $_SESSION["login"]=$_POST['nazwisko'];
    $_SESSION["haslo"]=$_POST['haslo'];
    header('Location: zarejestruj.php');
    exit;
}
}
else{
    $_SESSION["imie"]=$_POST["imie"];
    $_SESSION["nazwisko"]=$_POST['nazwisko'];
    $_SESSION["pesel"]=$_POST['pesel'];
    $_SESSION["mail"]=$_POST['mail'];
    $_SESSION["telefon"]=$_POST['telefon'];
    $_SESSION["login"]=$_POST['login'];
    $_SESSION["blad"]="Jedna z wartosci już istnieje w bazie";
    header('Location: zarejestruj.php');
    exit;
}
?>
</div>
</body>
</html>