<html>
<head>
    <link rel="stylesheet" type="text/css" href="rejestruj.css">
</head>

    <body>
<div id="konetener">
<?php

include ('./polaczenie.php');

$sql="INSERT INTO Klienci(imie,nazwisko,pesel,mail,telefon,login,haslo) values (?,?,?,?,?,?,?)";
$zapytanie=$baza->prepare($sql);
$zapytanie->execute(array($_POST["imie"],$_POST['nazwisko'],$_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login'],$_POST['haslo']));

$ilosc=$zapytanie->rowCount();

if($ilosc==1){
    echo "<script>alert('Rejestracja zakończona pozytywnie');</script>";

}
else{
    echo 'Coś poszło nie tak :(';
    echo "<script>alert('Nieprawidłowe dane');</script";
    header('Location: zarejestruj.php');
    exit;
}

?>
</div>
</body>
</html>