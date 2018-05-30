<?php
include ('polaczenie.php');
session_start();
kontrolaDostepu();




function kontrolaDostepu(){
if(isset($_SESSION["zalogowany"])==false || $_SESSION["zalogowany"]!="Klient"){
        echo "<script>alert('Nie ma uprawnień do tego miejsca,zaloguj się');
        window.location.href = 'index1.php';</script>";
        exit;
}
}

if(isset($_GET['dodaj'])){
    $sql="INSERT INTO rezerwacje(id_klienta,id_rozklad) VALUES (:klient,:rozkl)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->bindValue(':klient',$_SESSION['login'],PDO::PARAM_INT);
    $zapytanie->bindValue(':rozkl',$_GET['dodaj'],PDO::PARAM_INT);
    $zapytanie->execute();

    $sql="SELECT count(*) FROM rezerwacje WHERE id_rozklad=:rozkl";
    $zapytanie1=$baza->prepare($sql);
    $zapytanie1->bindValue(':rozkl',$_GET['dodaj'],PDO::PARAM_INT);
    $zapytanie1->execute();
    $rzad=$zapytanie1->fetch();
    $ile=$rzad[0];

    $sql="UPDATE rozklad SET ilosc_rezerwacji=:ile WHERE id_rozkladu=:rozkl";
    $zapytanie2=$baza->prepare($sql);
    $zapytanie2->bindValue(':ile',$ile,PDO::PARAM_INT);
    $zapytanie2->bindValue(':rozkl',$_GET['dodaj'],PDO::PARAM_INT);
    $zapytanie2->execute();


    if($zapytanie->rowCount()==1){
        header("Location: .\uzytkownik.php?skad={$_SESSION['skad']}&dokad={$_SESSION['dokad']}");
        exit;
    }
}

if(isset($_GET['usun'])){
    $sql="DELETE FROM rezerwacje WHERE id_klienta=:klient AND id_rozklad=:rozkl";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->bindValue(':klient',$_SESSION['login'],PDO::PARAM_INT);
    $zapytanie->bindValue(':rozkl',$_GET['usun'],PDO::PARAM_INT);
    $zapytanie->execute();
    
    $sql="SELECT count(*) FROM rezerwacje WHERE id_rozklad=:rozkl";
    $zapytanie1=$baza->prepare($sql);
    $zapytanie1->bindValue(':rozkl',$_GET['usun'],PDO::PARAM_INT);
    $zapytanie1->execute();
    $rzad=$zapytanie1->fetch();
    $ile=$rzad[0];

    $sql="UPDATE rozklad SET ilosc_rezerwacji=:ile WHERE id_rozkladu=:rozkl";
    $zapytanie2=$baza->prepare($sql);
    $zapytanie2->bindValue(':ile',$ile,PDO::PARAM_INT);
    $zapytanie2->bindValue(':rozkl',$_GET['usun'],PDO::PARAM_INT);
    $zapytanie2->execute();

    if($zapytanie->rowCount()==1){
        
        header("Location: .\uzytkownik.php?skad={$_SESSION['skad']}&dokad={$_SESSION['dokad']}");
        exit;
    }
}



?>