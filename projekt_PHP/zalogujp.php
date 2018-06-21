<?php

class Zaloguj{
    
function __construct(){
$this->kontrolaDostepu();
if((isset($_POST['login'])) && (isset($_POST['haslo'])))
    $this->logowanie();
}

function zapisz($login,$kto,$dane){
    $plik='./dziennik.txt';
    $fp = fopen($plik, 'a');
    $czas=date('d-m-Y H:i:s');
    $zapisz="Login: {$login};typ konta:{$kto};tpołączenie {$dane}udane;{$czas};{$_SERVER['REMOTE_ADDR']};{$_SERVER['HTTP_USER_AGENT']};\n";
    fwrite($fp,$zapisz);
    fclose($fp);
}

function kontrolaDostepu(){
if(isset($_SESSION["zalogowany"]) && isset($_SESSION["log"])){
                  
    if($_SESSION["zalogowany"]=="Pracownik"){
        header('Location: .\pracownik.php');
        exit;
    }

    else if($_SESSION["zalogowany"]=="Klienci"){
        header('Location: .\uzytkownik.php');
        exit;
    }
}
}

function logowanie(){
include ('./polaczenie.php');
$ilosc;
$haslo = sha1($_POST["haslo"]);
if(isset($_POST["kto"])=="Pracownik"){
$sql="SELECT id_pracownika,login,haslo,uprawnienia FROM Pracownicy where login LIKE ? AND haslo LIKE ?";
$zapytanie=$baza->prepare($sql);
$zapytanie->execute(array($_POST["login"],$haslo));
$ilosc=$zapytanie->rowCount();
}
else{
    $sql="SELECT id_klienta,login,haslo FROM Klienci where login LIKE ? AND haslo LIKE ?";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["login"],$haslo));
    $ilosc=$zapytanie->rowCount();
}

if($ilosc==1){

 $dane=$zapytanie->fetch();
    if(isset($_POST["kto"])=='Pracownik'){      
        $_SESSION["zalogowany"]="Pracownik";
        $_SESSION["log"]=$dane[0];
        if($dane[3]!=0)
            $_SESSION["uprawnienia"]=$dane[3];
        $this->zapisz( $_SESSION["log"], $_SESSION["zalogowany"],"");
        header('Location: pracownik.php');
        exit;
    }
    else{     
        $_SESSION["zalogowany"]="Klient";
        $_SESSION["log"]=$dane['id_klienta'];
        $this->zapisz( $_SESSION["log"], $_SESSION["zalogowany"],"");
        header('Location: uzytkownik.php');
        exit; 
    }
}
else{
    $_SESSION['nick']=$_POST['login'];
    $_SESSION['blad']="błędny login bądź hasło";
    $this->zapisz( $_SESSION["nick"], "---","nie");
    if(isset($_POST['kto']))
        $_SESSION['check']="checked";
}
}
}


?>