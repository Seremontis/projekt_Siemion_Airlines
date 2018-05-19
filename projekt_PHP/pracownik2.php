    <?php
    session_start();
if(isset($_SESSION["zalogowany"])==false || empty($_SESSION["zalogowany"])==true || $_SESSION["zalogowany"]!="Pracownik"){
    echo "<script>alert('Nie ma uprawnień do tego miejsca, zaloguj się');
    window.location.href = 'index1.php';</script>";
    exit;

}


if(isset($_POST['usunrozkl'])){
    require('polaczenie.php');
    $sql="DELETE FROM rozklad WHERE id_rozkladu=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunrozkl']);
    $usun->execute();
    header('Location: http://localhost/projekt_PHP/pracownik2.php?co=rozklady');
    exit;

}
else if(isset($_POST['usunsamolot'])){
    require('polaczenie.php');
    $sql="DELETE FROM samolot WHERE id_samolotu=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunsamolot']);
    $usun->execute();
    header('Location: http://localhost/projekt_PHP/pracownik2.php?co=samolot');
    exit;
}
else if(isset($_POST['usunrez'])){
    require('polaczenie.php');
    $sql="DELETE FROM rezerwacje WHERE id_rezerwacji=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunrez']);
    $usun->execute();

    $sql="SELECT count(*) FROM rezerwacje WHERE id_rozklad=?";
    $zapytanie1=$baza->prepare($sql);
    $zapytanie1->execute(array($_POST['usunid']));
    $rzad=$zapytanie1->fetch();
    $ile=$rzad[0];

    $sql="UPDATE rozklad SET ilosc_rezerwacji=:ile WHERE id_rozkladu=:rozkl";
    $zapytanie2=$baza->prepare($sql);
    $zapytanie2->bindValue(':ile',$ile,PDO::PARAM_INT);
    $zapytanie2->bindValue(':rozkl',$_POST['usunid'],PDO::PARAM_INT);
    $zapytanie2->execute();

    header('Location: http://localhost/projekt_PHP/pracownik2.php?co=rezerwacje');
    exit;
}
else if(isset($_POST['usuntrasa'])){
    require('polaczenie.php');
    $sql="DELETE FROM trasa WHERE id_trasy=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usuntrasa']);
    $usun->execute();
    header('Location: http://localhost/projekt_PHP/pracownik2.php?co=trasa');
    exit;
}
else if(isset($_POST['usunklienci'])){
    require('polaczenie.php');
    $sql="DELETE FROM klienci WHERE id_klienta=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunklienci']);
    $usun->execute();
    header('Location: http://localhost/projekt_PHP/pracownik2.php?co=klienci');
    exit;
}

    function wykaz($zmienna){
        require('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        $kolumny="SHOW COLUMNS FROM {$zmienna}";       
        $wykonaj=$baza->prepare($kolumny);
        $wykonaj->execute();
        $ilosc=$wykonaj->rowCount();
            while($dane=$wykonaj->fetch())
                echo "<th>{$dane[0]}</th>";
            echo "<th style='width:90px;'>Modyfikacje</th>";
            echo "</tr>";
            $rekordy="select * FROM {$zmienna}";
            $wykonaj2=$baza->query($rekordy);
            while($dane=$wykonaj2->fetch()){
                echo "<tr>";
                for($i=0;$i<$ilosc;$i++){
                    if($i!=7)
                        echo "<td>{$dane[$i]}</td>";
                    else{
                        echo "<td>";
                        for($y=0;$y<strlen($dane[$i]);$y++)
                            echo "*";
                    echo "</td>";
                    }

                }
                   
                echo "<td><form action='formularzpracownika.php' method='post'>
                        <input type='hidden' name='edytuj{$zmienna}' value='{$dane['0']}'/>
                        <button type='submit' id='edytuj' /></button></form>
                        <form action='pracownik2.php' method='post'>
                        <input type='hidden' name='usun{$zmienna}' value='{$dane['0']}'/>
                        <button type='submit' id='usun' /></button></form></td>";
                echo "</tr>";
            }    
        echo "</table>";
    }

    function rozklad(){
        require('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        echo "<th>id_rozkladu</th><th>Data</th><th>godzina</th><th>Skad</th><th>dokad</th><th>id_samolotu</th><th>marka samolotu</th> <th>model samolotu</th><th>ilosc rezerwacji</th><th style='width:90px;'>Modyfikacje</th>";
        echo "</tr>";
        $rekordy="SELECT r.id_rozkladu,r.Data,r.godzina,t.Skad,t.dokad,s.id_samolotu,s.marka,s.model,r.ilosc_rezerwacji FROM rozklad r,trasa t,samolot s WHERE r.id_trasy=t.id_trasy and r.id_samolotu=s.id_samolotu";
        $wykonaj2=$baza->query($rekordy);
        while($dane=$wykonaj2->fetch()){
            echo "<tr>";
            for($i=0;$i<9;$i++)
                echo "<td>{$dane[$i]}</td>";
                
            echo "<td><form action='formularzpracownika.php' method='post'>
            <input type='hidden' name='edytujroz' value='{$dane['0']}'/>
            <button type='submit' id='edytuj' /></button></form>
            <form action='pracownik2.php' method='post'>
            <input type='hidden' name='usunrozkl' value='{$dane['0']}'/>
            <button type='submit' id='usun' /></button></form></td>";
            echo "</tr>";
        }    
        echo "</table>";    
    }

    function rezerwacja(){
        include ('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        echo "<th>id_rezerwacji</th><th>id_klienta</th><th>Dane klienta</th><th>id_rozkladu</th><th>Data i godzina odlotu</th><th>id_samolotu</th><th style='width:15px;'>Modyfikacje</th>";
        echo "</tr>";
        $rekordy="SELECT r.id_rezerwacji,k.id_klienta,k.Imie+' '+k.Nazwisko,ro.id_rozkladu,ro.Data+' '+ro.godzina,ro.id_samolotu FROM rezerwacje r,klienci k,rozklad ro WHERE r.id_klienta=k.id_klienta and r.id_rozklad=ro.id_rozkladu";
        $wykonaj2=$baza->query($rekordy);
        while($dane=$wykonaj2->fetch()){
            echo "<tr>";
            for($i=0;$i<6;$i++)
                echo "<td>{$dane[$i]}</td>";
            echo "<td><form action='pracownik2.php' method='post'>
                <input type='hidden' name='usunrez' value='{$dane['0']}'/>
                <input type='hidden' name='usunid' value='{$dane['3']}'/>
                <button type='submit' id='usunrez' /></button></form></td>";
            echo "</tr>";
        }    
        echo "</table>";    
    }

    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiemionAirlines-rozpiska</title>
    <meta name="description" content="Rejestracja do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" href="pracownik.css" />
    <link rel="stylesheet" type="text/css" href="tabela.css" />
</head>
<body>
<div id="kontener">
<div id="panel">
        <a href="wyloguj.php"><div id="wyloguj">Wyloguj się</div></a>
        <a href="pracownik.php"><div id="powrot">Powrót</div></a>    
    </div>
    <div id="wyszukiwarka1">
    <form action="pracownik2.php" method="get">
        <button type="submit" name="co" value="samolot">samoloty</button>
        <button type="submit" name="co"  value="rozklady">Rozkłady</button>
        <button type="submit" name="co" value="rezerwacje">Rezerwacje</button>
        <button type="submit" name="co"  value="trasa">Trasy</button>
        <button type="submit" name="co" value="klienci" >klienci</button>
    </form>

        
    </div>
    <div id="tabela">
    <?php
    if(isset($_GET["co"])){
        $info=$_GET["co"];
        switch($info){
            case "klienci":
            wykaz("klienci");
            break;
        case "trasa":
            wykaz("trasa");
            break;
        case "rozklady":
            rozklad();
            break;
        case "samolot":
            wykaz("samolot");
            break;
        case "rezerwacje":
            rezerwacja();
            break;
        default:
            break;
        }
    }

?>
    </div>
    </div>
</body>
</html>