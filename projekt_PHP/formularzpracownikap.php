<?php
require('kontrolaupr.php');

session_start();
kontrolaDostepu();

if(isset($_POST['modyf']))
    wykonaj($_POST['modyf']);



function wykonaj($zmienna){
  require_once ('polaczenie.php');
switch($zmienna){
    case "samolot":
    $sql="UPDATE samolot SET model=?, marka=?, nr_taborowy=?,ilosc_miejsc=? WHERE id_samolotu=?";
    $modyf=$baza->prepare($sql);
    $modyf->execute(array($_POST['model1'],$_POST['marka1'],$_POST['nr_taborowy1'],$_POST['pojemnosc1'],$_POST['id']));
    if($modyf->rowCount()>0)
    {
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=samolot');
        exit;
    }
    else
    {
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=samolot');
        exit;
}

    break;
    case "trasa":
    $sql="UPDATE trasa SET skad=?, dokad=?, zalecana_pojemnosc=? WHERE id_trasy=?";
    $modyf=$baza->prepare($sql);
    $modyf->execute(array($_POST['start'],$_POST['meta'],$_POST['pojemnosc'],$_POST['id']));
    if($modyf->rowCount()>0){
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=trasa');
        exit;}
    else
    {
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=trasa');
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
              header('Location: http://localhost/projekt_PHP/pracownik2.php?co=rozklady');
                exit;
    }
    else{
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=rozklady');
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
    $sql="UPDATE klienci SET imie=:imie,Nazwisko=:naz,PESEL=:pes,mail=:mail,telefon=:tel,login=:log,haslo=:has WHERE id_kLienta=:id";
    $modyf=$baza->prepare($sql);
    $modyf->bindParam(':imie', $_POST["imie"], PDO::PARAM_STR);
    $modyf->bindParam(':naz', $_POST["nazwisko"], PDO::PARAM_STR);
    $modyf->bindParam(':pes', $_POST["pesel"], PDO::PARAM_STR);
    $modyf->bindParam(':mail', $_POST["mail"], PDO::PARAM_STR);
    $modyf->bindParam(':tel', $_POST["telefon"], PDO::PARAM_STR);
    $modyf->bindParam(':log', $_POST["login"], PDO::PARAM_STR);
    $modyf->bindParam(':has', $_POST["haslo"], PDO::PARAM_STR);
    $modyf->bindParam(':id', $_POST["id"], PDO::PARAM_INT);
    $modyf->execute();
    if($modyf->rowCount()>0){
        echo "<script>alert('>0');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=klienci');
        
        exit;}
    else
    {
        echo "<script>alert('Dane nie zostały zapisane');</script>";
        header('Location: http://localhost/projekt_PHP/pracownik2.php?co=klienci');
        exit;
    }

    break;

    default:
        break;
}
}
?>