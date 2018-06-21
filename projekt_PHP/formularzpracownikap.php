<?php

class Formularz{

    function __construct(){
        require('kontrolaupr.php');
        kontrolaDostepu();
        $this->wykonaj($_POST['modyf']);
    }

    function __dectruct(){
        unset($_POST['modyf']);
    }


function wykonaj($zmienna){
  require ('polaczenie.php');
switch($zmienna){
    case "samolot":
    $sql="UPDATE samolot SET model=?, marka=?, nr_taborowy=?,ilosc_miejsc=? WHERE id_samolotu=?";
    $modyf=$baza->prepare($sql);
    $modyf->execute(array($_POST['model1'],$_POST['marka1'],$_POST['nr_taborowy1'],$_POST['pojemnosc1'],$_POST['id']));
    if($modyf->rowCount()>0)
    {
        header('Location: .\pracownik2.php?co=samolot');
        exit;
    }
    else
    {
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: .\pracownik2.php?co=samolot');
        exit;
}

    break;
    case "trasa":
    $sql="UPDATE trasa SET skad=?, dokad=?, zalecana_pojemnosc=? WHERE id_trasy=?";
    $modyf=$baza->prepare($sql);
    $modyf->execute(array($_POST['start'],$_POST['meta'],$_POST['pojemnosc'],$_POST['id']));
    if($modyf->rowCount()>0){
        header('Location: .\pracownik2.php?co=trasa');
        exit;}
    else
    {
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: .\pracownik2.php?co=trasa');
        exit;
}
    break;

    case "rozklad":
    if($_POST["data"]>date('Y-m-d') && $_POST["godzina"]>date('h:i')){
    $sql="UPDATE rozklad SET Data=:data, godzina=:godzina, id_trasy=:idt, id_samolotu=:ids WHERE rozklad.id_rozkladu=:idr";
    $modyf=$baza->prepare($sql);
    $modyf->bindParam(':data', $_POST["data"], PDO::PARAM_STR);
    $modyf->bindParam(':godzina', $_POST["godzina"], PDO::PARAM_STR);
    $modyf->bindParam(':idt', $_POST["trasa"], PDO::PARAM_INT);
    $modyf->bindParam(':ids', $_POST["samolot"], PDO::PARAM_INT);
    $modyf->bindParam(':idr', $_POST["id"], PDO::PARAM_INT);
    $modyf->execute();
    if($modyf->rowCount()>0){
              header('Location: .\pracownik2.php?co=rozklady');
                exit;
    }
    else{
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: .\pracownik2.php?co=rozklady');
        exit;
}
    }
    else
    {

        echo "<script>alert('Niepoprawna godzina');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=rozklady');
        exit;
    }
    break;

    case "klienci":  
    if((sha1($_POST['haslo']))!=$_SESSION['haslo'])
        $haslo=sha1($_POST['haslo']);
    else
        $haslo=$_SESSION['haslo'];
    unset ($_SESSION['haslo']);
    $sql="UPDATE klienci SET imie=:imie,Nazwisko=:naz,PESEL=:pes,mail=:mail,telefon=:tel,login=:log,haslo=:has WHERE id_kLienta=:id";
    $modyf=$baza->prepare($sql);
    $modyf->bindParam(':imie', $_POST["imie"], PDO::PARAM_STR);
    $modyf->bindParam(':naz', $_POST["nazwisko"], PDO::PARAM_STR);
    $modyf->bindParam(':pes', $_POST["pesel"], PDO::PARAM_STR);
    $modyf->bindParam(':mail', $_POST["mail"], PDO::PARAM_STR);
    $modyf->bindParam(':tel', $_POST["telefon"], PDO::PARAM_STR);
    $modyf->bindParam(':log', $_POST["login"], PDO::PARAM_STR);
    $modyf->bindParam(':has', $haslo, PDO::PARAM_STR);
    $modyf->bindParam(':id', $_POST["id"], PDO::PARAM_INT);
    $modyf->execute();
    if($modyf->rowCount()>0){
        header('Location: .\pracownik2.php?co=klienci');
        
        exit;}
    else
    {
        header('Location: .\pracownik2.php?co=klienci');
        exit;
    }

    break;

    case "pracownicy":  
    if((sha1($_POST['haslo']))!=$_SESSION['haslo'])
        $haslo=sha1($_POST['haslo']);
    else
        $haslo=$_SESSION['haslo'];
    unset ($_SESSION['haslo']);
    $sql="UPDATE pracownicy SET imie=:imie,nazwisko=:naz,pesel=:pes,mail=:mail,telefon=:tel,login=:log,haslo=:has,uprawnienia=:upr,adres_zamieszkania=:adres WHERE id_pracownika=:id";
    $modyf=$baza->prepare($sql);
    $modyf->bindParam(':imie', $_POST["imie"], PDO::PARAM_STR);
    $modyf->bindParam(':naz', $_POST["nazwisko"], PDO::PARAM_STR);
    $modyf->bindParam(':pes', $_POST["pesel"], PDO::PARAM_STR);
    $modyf->bindParam(':mail', $_POST["mail"], PDO::PARAM_STR);
    $modyf->bindParam(':tel', $_POST["telefon"], PDO::PARAM_STR);
    $modyf->bindParam(':log', $_POST["login"], PDO::PARAM_STR);
    $modyf->bindParam(':has', $haslo, PDO::PARAM_STR);
    $modyf->bindParam(':id', $_POST["id"], PDO::PARAM_INT);
    $modyf->bindParam(':adres', $_POST["adres"], PDO::PARAM_STR);
    $modyf->bindParam(':upr', $_POST["upr"], PDO::PARAM_INT);
    $modyf->execute();
    if($modyf->rowCount()>0){
        header('Location: .\pracownik2.php?co=pracownicy');
        exit;
    }
    else
    {
        header('Location: .\pracownik2.php?co=pracownicy');
        exit;
    }

    break;

    default:
        break;
}
}
}
?>