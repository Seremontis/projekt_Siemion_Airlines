<?php
session_start();
include ('polaczenie.php');

if(isset($_SESSION["zalogowany"])==false || $_SESSION["zalogowany"]!="Klient"){
        echo "<script>alert('Nie ma uprawnień do tego miejsca,zaloguj się');
        window.location.href = 'index1.php';</script>";
        exit;
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
        header("Location: uzytkownik.php?skad={$_SESSION['skad']}&dokad={$_SESSION['dokad']}");
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
        
        header("Location: uzytkownik.php?skad={$_SESSION['skad']}&dokad={$_SESSION['dokad']}");
        exit;
    }
}


?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Siemion Airlines-panel użytkownika</title>
    <meta name="description" content="panel użytkownika">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" href="uzytk.css" />
    <link rel="stylesheet" type="text/css" href="tabela.css" />
</head>

<body>
<div id="kontener">
    <div id="panel">
        <a href="wyloguj.php"><div id="wyloguj">Wyloguj się</div></a> 
    </div>
    <div id="wyszukiwarka">
        <form action="uzytkownik.php" method="GET">
            <fieldset>
                <legend>
                    <h1>Wyszukiwarka</h1>
                </legend>
                <p>Skąd:
                    <select id="wybierz1" name="skad" id="skad">
                        <option></option>
                    <?php
                                $sql="SELECT DISTINCT skad FROM trasa";
                                $zapytanie=$baza->query($sql);
                                if($zapytanie->rowCount()>0){
                                    while($dane=$zapytanie->fetch()){
                                        echo "<option value='{$dane[0]}'>{$dane[0]}</option>";
                                    }
                                }
                                else
                                    echo "<option>brak</option>";
                    ?>
                    </select>
                </p>
                </select>
                <p>
                    Dokąd:

                    <select id="wybierz2" name="dokad" id="dokad">
                        <option></option>
                    <?php
                                $sql="SELECT DISTINCT dokad FROM trasa";
                                $zapytanie=$baza->query($sql);
                                if($zapytanie->rowCount()>0){
                                    while($dane=$zapytanie->fetch()){
                                        echo "<option value='{$dane[0]}'>{$dane[0]}</option>";
                                    }
                                }
                                else
                                    echo "<option>brak</option>";
                    ?>
                    </select>
                </p>
                <p id="zatwierdz">
                <input type="submit" content="Wyszukaj">
                <input type="reset" content="Wyczyść">
                </p>

            </fieldset>
        </form>
    </div>
    <div id="wynik">
    <?php
if(empty($_GET['skad'])==false && empty($_GET['dokad'])==false){
    $_SESSION['skad']=$_GET['skad'];
    $_SESSION['dokad']=$_GET['dokad'];

    $rekordy="SELECT r.id_rozkladu,t.skad,t.dokad,concat(s.marka,' ',s.model),(s.ilosc_miejsc)-(r.ilosc_rezerwacji),concat(r.Data,' ',r.godzina) FROM rozklad r, trasa t, samolot s WHERE (r.id_samolotu=s.id_samolotu AND r.id_trasy=t.id_trasy) AND ((r.Data=CURRENT_DATE AND r.godzina>CURRENT_TIME) OR r.Data>CURRENT_DATE) AND t.skad=? AND t.dokad=?";
    $wykonaj2=$baza->prepare($rekordy);
    $wykonaj2->execute(array($_SESSION['skad'],$_SESSION['dokad']));
    $ilosc=$wykonaj2->rowCount();
    if($ilosc>0){
        echo "<table>";
        echo "<tr>";
        echo "<th>Skad</th><th>Dokad</th><th>samolot</th><th>wolne miejsca</th><th>Data i godzina odlotu</th><th></th>";
        echo "</tr>";
        while($dane=$wykonaj2->fetch()){
        echo "<tr>";
        $id_roz=$dane[0];
        for($i=1;$i<6;$i++)
                echo "<td>{$dane[$i]}</td>";

        $spr="SELECT * FROM rezerwacje WHERE id_klienta=? AND id_rozklad=?"; 
        $wykonaj3=$baza->prepare($spr);
        $wykonaj3->execute(array($_SESSION['login'],$id_roz));
        $ilosc=$wykonaj3->rowCount();
        echo "<td>";
        if($ilosc==0){
            echo "<form action='uzytkownik.php' method='get'>
                <input type='hidden' name='dodaj' value={$id_roz}/>
                <button type='submit' id='dodaj' /></button></form>";
        }
        else{
        echo "<form action='uzytkownik.php' method='get'>
        <input type='hidden' name='usun' value={$id_roz}/>
        <button type='submit' id='usun' /></button></form>";
        }
        echo "</td>";
        }  
        echo "</table>";
    }
    else
        echo "<script>alert('Brak połączeń');</script>";
    
}  
    ?>
    </div>
</div>


</body>

</html>