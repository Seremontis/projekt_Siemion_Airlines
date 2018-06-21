<?php
class Rejestracja{

function Rejestracja(){
    if(isset($_SESSION["zalogowany"]))
        unset ($_SESSION["zalogowany"]);
    
}

function rejestruj(){
include ('./polaczenie.php');

$spr="SELECT id_klienta FROM klienci WHERE PESEL=? OR mail=? OR telefon=? OR login=?";
$zapytanie=$baza->prepare($spr);
$zapytanie->execute(array($_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login']));
$ilosc=$zapytanie->rowCount();


if($ilosc==0){
$sql="INSERT INTO Klienci(imie,nazwisko,pesel,mail,telefon,login,haslo) values (?,?,?,?,?,?,?)";
$zapytanie=$baza->prepare($sql);
$haslo = sha1($_POST["haslo"]);
$zapytanie->execute(array($_POST["imie"],$_POST['nazwisko'],$_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login'],$haslo));

$ilosc=$zapytanie->rowCount();

if($ilosc==1){
    $_SESSION['rej']='Rejestracja zakończona pomyślnie,można się zalogować';
    header('Location: zaloguj.php');
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
    $_SESSION["blad"]="Jedna z wartosci już istnieje w bazie";
    header('Location: zarejestruj.php');
    exit;
}
}
}
}
?>
