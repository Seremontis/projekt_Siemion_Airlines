<?php
session_start();
include ('kontrolaupr.php');


kontrolaDostepu();


if(isset($_POST['usunrozkl'])){
    include ('polaczenie.php');
    $sql="DELETE FROM rozklad WHERE id_rozkladu=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunrozkl']);
    $usun->execute();
    header('Location: .\pracownik2.php?co=rozklady');
    exit;

}
else if(isset($_POST['usunsamolot'])){
    include ('polaczenie.php');
    $sql="DELETE FROM samolot WHERE id_samolotu=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunsamolot']);
    $usun->execute();
    header('Location:.\pracownik2.php?co=samolot');
    exit;
}
else if(isset($_POST['usunrez'])){
    include ('polaczenie.php');
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

    header('Location: .\pracownik2.php?co=rezerwacje');
    exit;
}
else if(isset($_POST['usuntrasa'])){
    include ('polaczenie.php');
    $sql="DELETE FROM trasa WHERE id_trasy=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usuntrasa']);
    $usun->execute();
    header('Location: .\pracownik2.php?co=trasa');
    exit;
}
else if(isset($_POST['usunklienci'])){
    include ('polaczenie.php');
    $sql="DELETE FROM klienci WHERE id_klienta=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunklienci']);
    $usun->execute();
    header('Location: .\pracownik2.php?co=klienci');
    exit;
}

else if(isset($_POST['usunpracownicy'])){
    include ('polaczenie.php');
    $sql="DELETE FROM pracownicy WHERE id_pracownika=:id";
    $usun=$baza->prepare($sql);
    $usun->bindValue(":id",$_POST['usunpracownicy']);
    $usun->execute();
    header('Location: .\pracownik2.php?co=pracownicy');
    exit;
}


    function wykaz($zmienna){
        include('polaczenie.php');
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
                    if(($i==7 && $zmienna=="klienci") || ($i==8 && $zmienna=="pracownicy")){
                        echo "<td>";
                        for($y=0;$y<strlen($dane[$i]);$y++)
                            echo "*";
                        echo "</td>";
                    }  
                    else if($i==9 && $zmienna=="pracownicy"){    
                        echo "<td>";
                        if($dane[$i]==1)
                            echo "Super praconwik";
                        else
                            echo "Zwykły pracownik";
                        echo "</td>";
                    }                
                    else
                        echo "<td>{$dane[$i]}</td>";
                    

                }
                   
                echo "<td><form action='formularzpracownika.php' method='post'>
                        <input type='hidden' name='edytuj{$zmienna}' value='{$dane[0]}'/>
                        <button type='submit' id='edytuj' /></button></form>
                        <form action='pracownik2.php' method='post'>";
                        if(isset($_SESSION['uprawnienia']) && ($_SESSION["log"])!=$dane[0]){
                        echo "<input type='hidden' name='usun{$zmienna}' value='{$dane[0]}'/>
                            <button type='submit' id='usun' /></button></form></td>";
                           
                        }
                echo "</tr>";
            }    
        echo "</table>";
       
    }

    function rozklad(){
        include('polaczenie.php');
        echo "<p id='opcja'><a id='generuj' href='generuj.php'>Generuj plik pdf</a></p>";
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
            <form action='pracownik2.php' method='post'>";
            if(isset($_SESSION['uprawnienia'])){
            echo "<input type='hidden' name='usunrozkl' value='{$dane['0']}'/>
            <button type='submit' id='usun' /></button></form></td>";
            }
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
        $rekordy="SELECT r.id_rezerwacji,k.id_klienta,concat(k.Imie,' ',k.Nazwisko),ro.id_rozkladu,concat(ro.Data,' ',ro.godzina),ro.id_samolotu FROM rezerwacje r,klienci k,rozklad ro WHERE r.id_klienta=k.id_klienta and r.id_rozklad=ro.id_rozkladu";
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