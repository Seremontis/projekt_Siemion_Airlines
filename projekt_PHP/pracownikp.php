<?php
session_start();
require ('kontrolaupr.php');


function dodajDoBazy(){
    error_reporting(0);
    include('polaczenie.php');
if(isset($_POST["operacja"])==true)
    $operacja=$_POST["operacja"];
else
    $operacja='';


if($operacja=="samolot"){
    $sql="SELECT nr_taborowy FROM samolot WHERE nr_taborowy=?";
    $spr=$baza->prepare($sql);
    $spr->execute(array($_POST['nr_taborowy']));
    if($spr->rowCount()==0){
    $sql="INSERT INTO samolot(model,marka,nr_taborowy,ilosc_miejsc) values (?,?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["model"],$_POST["marka"],$_POST["nr_taborowy"],$_POST["miejsca"]));

    if($zapytanie->rowCount()>0)
        echo "<script>alert('Wykonano pomyślnie');</script>";  
    else
        echo "<script>alert('Niepowodzenie');</script>"; 
    }
    else{
        echo "<script>alert('istnieje już samolot o tym nr_taborowym');";
    }    
    $operacja='';    
}
else if($operacja=="trasa"){
    $sql="SELECT skad,dokad FROM trasa WHERE skad=? AND dokad=?";
    $spr=$baza->prepare($sql);  
    $spr->execute(array($_POST['start'],$_POST['meta']));
    if($spr->rowCount()==0){
    $sql="INSERT INTO trasa(skad,dokad,zalecana_pojemnosc) values (?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["start"],$_POST["meta"],$_POST["pojemnosc"]));

    if($zapytanie->rowCount()>0)
        echo "<script>alert('Wykonano pomyślnie');</script>";  
    else
        echo "<script>alert('Niepowodzenie');</script>";  
        $operacja='';
    }
    else "<scirpt>alert('Podana trasa już istnieje');";
}
else if($operacja=="rozklad"){
    if($_POST['trasa']!='brak' AND $_POST['samolot']!='brak'){
     $data=time();
    if($_POST["data"]>date('Y-m-d') && $_POST["godzina"]>date('h:i')){
    $sql="SELECT id_rozkladu FROM rozklad WHERE data=? AND godzina=? AND id_trasy=? AND id_samolotu=?";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_POST["data"],$_POST["godzina"],$_POST["trasa"],$_POST["samolot"]));
    if($zapytanie->rowCount()==0){
        $sql="INSERT INTO rozklad(data,godzina,id_trasy,id_samolotu) values (?,?,?,?)";
        $zapytanie1=$baza->prepare($sql);
        $zapytanie1->execute(array($_POST["data"],$_POST["godzina"],$_POST["trasa"],$_POST["samolot"]));

        if($zapytanie1->rowCount()>0)
            echo "<script>alert('Wykonano pomyślnie');</script>";  
        else
            echo "<script>alert('Niepowodzenie');</script>";  
        }
    else echo "<script>alert('Podany rozkład już istnieje');</script>";  
        
    }
    else echo "<script>alert('Podana godzina bądź data jest nieaktualna');</script>";            
    }
    else echo "<script>alert('Brak wybranego samolotu bądź trasy');</script>";
    $operacja='';
}
    else if($operacja=="pracownik"){  
    $spr="SELECT id_pracownika FROM pracownicy WHERE PESEL=? OR mail=? OR telefon=? OR login=?";
    $zapytanie=$baza->prepare($spr);
    $zapytanie->execute(array($_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['login']));
    $ilosc=$zapytanie->rowCount();
    
    
    if($ilosc==0){
    $sql="INSERT INTO Pracownicy(imie,nazwisko,pesel,mail,telefon,adres_zamieszkania,login,haslo,uprawnienia) values (?,?,?,?,?,?,?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $haslo = sha1($_POST['haslo']);
    $zapytanie->execute(array($_POST["imie"],$_POST['nazwisko'],$_POST['pesel'],$_POST['mail'],$_POST['telefon'],$_POST['adres'],$_POST['login'],$haslo,$_POST['upr']));
    
    $ilosc=$zapytanie->rowCount();
    
    if($ilosc==1){
        // header('Location: pracownik.php');
        //$_SESSION['udane']=1;
        echo "<script>alert('Zakończono powodzeniem');</script>";
    
    
    }
        else{
        $_SESSION["imie"]=$_POST["imie"];
        $_SESSION["nazwisko"]=$_POST['nazwisko'];
        $_SESSION["pesel"]=$_POST['pesel'];
        $_SESSION["mail"]=$_POST['mail'];
        $_SESSION["telefon"]=$_POST['telefon'];
        $_SESSION['adres']=$_POST['adres'];
        $_SESSION["login"]=$_POST['login'];
        $_SESSION["upr"]=$_POST['upr'];
        echo "<script>alert('Zakończono niepowodzeniem');</script>";
        }
    }
    else{
        $_SESSION["imie"]=$_POST["imie"];
        $_SESSION["nazwisko"]=$_POST['nazwisko'];
        $_SESSION["pesel"]=$_POST['pesel'];
        $_SESSION["mail"]=$_POST['mail'];
        $_SESSION["telefon"]=$_POST['telefon'];
        $_SESSION['adres']=$_POST['adres'];
        $_SESSION["login"]=$_POST['login'];
        $_SESSION["upr"]=$_POST['upr'];
        echo "<script>alert('Dane istnieją w już bazie');</script>";
    }
    
    }
}
    

?>