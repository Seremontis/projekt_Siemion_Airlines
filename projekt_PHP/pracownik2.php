    <?php
    function wykaz($zmienna){
        include ('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        $kolumny="SHOW COLUMNS FROM {$zmienna}";       
        $wykonaj=$baza->prepare($kolumny);
        $wykonaj->execute();
        $ilosc=$wykonaj->rowCount();
            while($dane=$wykonaj->fetch())
                echo "<th>{$dane[0]}</th>";
            echo "</tr>";
            $rekordy="select * FROM {$zmienna}";
            $wykonaj2=$baza->query($rekordy);
            while($dane=$wykonaj2->fetch()){
                echo "<tr>";
                for($i=0;$i<$ilosc;$i++)
                    echo "<td>{$dane[$i]}</td>";
                echo "</tr>";
            }    
        echo "</table>";
    }

    function rozklad(){
        include ('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        echo "<th>id_rozkladu</th><th>Data</th><th>godzina</th><th>Skad</th><th>dokad</th><th>id_samolotu</th><th>marka samolotu</th> <th>model samolotu</th><th>ilosc rezerwacji</th>";
        echo "</tr>";
        $rekordy="SELECT r.id_rozkladu,r.Data,r.godzina,t.Skad,t.dokad,s.id_samolotu,s.marka,s.model,r.ilosc_rezerwacji FROM rozklad r,trasa t,samolot s WHERE r.id_trasy=t.id_trasy and r.id_samolotu=s.id_samolotu";
        $wykonaj2=$baza->query($rekordy);
        while($dane=$wykonaj2->fetch()){
            echo "<tr>";
            for($i=0;$i<9;$i++)
                echo "<td>{$dane[$i]}</td>";
            echo "</tr>";
        }    
        echo "</table>";    
    }

    function rezerwacja(){
        include ('polaczenie.php');
        echo "<table>";
        echo "<tr>";
        echo "<th>id_rezerwacji</th><th>id_klienta</th><th>Dane klienta</th><th>id_rozkladu</th><th>Data i godzina odlotu</th><th>id_samolotu</th>";
        echo "</tr>";
        $rekordy="SELECT r.id_rezerwacji,k.id_klienta,k.Imie+' '+k.Nazwisko,ro.id_rozkladu,ro.Data+' '+ro.godzina,ro.id_samolotu FROM rezerwacje r,klienci k,rozklad ro WHERE r.id_klienta=k.id_klienta and r.id_rozklad=ro.id_rozkladu";
        $wykonaj2=$baza->query($rekordy);
        while($dane=$wykonaj2->fetch()){
            echo "<tr>";
            for($i=0;$i<6;$i++)
                echo "<td>{$dane[$i]}</td>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <button type="submit" name="co"  value="trasy">Trasy</button>
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
        case "trasy":
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