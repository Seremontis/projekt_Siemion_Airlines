<?php
session_start();

if(isset($_SESSION["zalogowany"])==false || empty($_SESSION["zalogowany"]==true || $_SESSION["zalogowany"]!="Pracownik")){
        echo "<script>alert('Nie ma uprawnień do tego miejsca');
        window.location.href = 'index1.php';</script>";
        exit;

}

include ('polaczenie.php');

if(isset($_GET["operacja"])==true)
    $operacja=$_GET["operacja"];
else
    $operacja='';


if($operacja=="samolot"){
    $sql="INSERT INTO samolot(model,marka,ilosc_miejsc,zasieg) values (?,?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_GET["model"],$_GET["marka"],$_GET["miejsca"],$_GET["dystans"]));

    if($zapytanie->rowCount()>0)
        echo "<script>alert('Wykonano pomyślnie');</script>";  
    else
        echo "<script>alert('Niepowodzenie');</script>"; 
        
    $operacja='';    
}
else if($operacja=="trasa"){
    $sql="INSERT INTO trasa(skad,dokad,dystans,zalecana_pojemnosc) values (?,?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_GET["start"],$_GET["meta"],$_GET["dystans"],$_GET["pojemnosc"]));

    if($zapytanie->rowCount()>0)
        echo "<script>alert('Wykonano pomyślnie');</script>";  
    else
        echo "<script>alert('Niepowodzenie');</script>";  
        $operacja='';
}
else if($operacja=="rozklad"){
    $sql="INSERT INTO rozklad(data,godzina,id_trasy,id_samolotu) values (?,?,?,?)";
    $zapytanie=$baza->prepare($sql);
    $zapytanie->execute(array($_GET["data"],$_GET["godzina"],$_GET["trasa"],$_GET["samolot"]));

    if($zapytanie->rowCount()>0)
        echo "<script>alert('Wykonano pomyślnie');</script>";  
    else
        echo "<script>alert('Niepowodzenie');</script>";  

        $operacja='';
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Siemion Airlines-VIP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="pracownik.css" />
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>

        $(document).ready(function () {
        $("#rozklad").hide(0, function () {
        });
        $("#samolot").hide(0, function () {
        });
        $("#trasa").hide(0, function () {
        });

            $("#dodajroz").click(function () {
                $("#rozklad").toggle("slow", function () {
                });
                $("#samolot").hide(function () { });
                $("#trasa").hide(function () { });
            });
            $("#dodajsam").click(function () {
                $("#samolot").toggle("slow", function () {
                });
                $("#rozklad").hide(function () { });
                $("#trasa").hide(function () { });
            });
            $("#dodajtrase").click(function () {
                $("#trasa").toggle("slow", function () {
                });
                $("#samolot").hide(function () { });
                $("#rozklad").hide(function () { });
            });
        })

    </script>
</head>

<body>
    <div id="kontener">
    <div id="panel">
        <a href="wyloguj.php"><div id="wyloguj">Wyloguj się</div></a>  
    </div>
        <div id="opcje">
            <ul>
                <h1>Wybierz opcję:</h1>
                <form action="pracownik2.php" method="post">
                    <li>
                        <button type="submit" id="przek" value="Pokaz spis">Pokaz spis</button>
                    </li>
                </form>
                
                <li>
                    <button id="dodajsam">Dodaj samolot</button>
                </li>
                <div id="samolot">
                    <form action="pracownik.php" method="get">
                        <?php
                            ?>
                        <fieldset>
                            <p>Model:
                                <input type="text" name="model" placeholder="Model" required />
                            </p>
                            <p>Marka:
                                <input type="text" name="marka" placeholder="Marka" required/>
                            </p>
                            <p>ilosc miejsc:
                                <input type="number" name="miejsca" placeholder="pojemność" required/>
                            </p>
                            <p>Zasięg[km]:
                                <input type="number" name="dystans" placeholder="Zasięg" required/>
                            </p>

                            <p>
                                <input type="hidden" name="operacja" value="samolot"/>
                                <input type="submit" value="Zatwierdź" />
                            </p>
                        </fieldset>
                    </form>
                </div>
                <li>
                    <button id="dodajtrase">Dodaj trasę</button>
                </li>
                <div id="trasa">
                    <form action="pracownik.php" method="get">
                        <fieldset>
                            <p>Skąd:
                                <input type="text" name="start" placeholder="Skąd" required/>
                            </p>
                            <p>Dokąd:
                                <input type="text" name="meta" placeholder="Dokąd" required/>
                            </p>
                            <p>Dystans:
                                <input type="number" name="dystans" placeholder="Dystans" required/>
                            </p>
                            <p>Zalecana pojemność:
                                <input type="number" name="pojemnosc" placeholder="Zalecana pojemność" required/>
                            </p>

                            <p>
                                <input type="hidden" name="operacja" value="trasa">
                                <input type="submit" value="Zatwierdź" />
                            </p>
                        </fieldset>
                    </form>

                </div>

                <li>
                    <button id="dodajroz">Dodaj rozklad</button>
                </li>
                <div id="rozklad">
                    <form action="pracownik.php" method="get">
                        <fieldset>
                            <p>Data:
                                <input type="date" name="data" placeholder="Data" required/>
                            </p>
                            <p>Godzina:
                                <input type="time" name="godzina" placeholder="Data" required/>
                            </p>
                            <p>Trasa:
                                <select name="trasa">
                                    <?php

                                $sql="SELECT id_trasy,skad,dokad FROM trasa";
                                $zapytanie=$baza->query($sql);
                                if($zapytanie->rowCount()>0){
                                    while($dane=$zapytanie->fetch()){
                                        echo "<option value='{$dane[0]}'>{$dane[1]}-{$dane[2]}</option>";
                                    }
                                }
                                else
                                    echo "<option>brak</option>";
                                    ?>
                                </select>
                                
                            </p>

                            <p>Samolot:
                                <select name="samolot">
                                <?php
                                $sql="SELECT id_samolotu,model,marka FROM samolot";
                                $zapytanie=$baza->query($sql);
                                    if($zapytanie->rowCount()>0){
                                         while($dane=$zapytanie->fetch())
                                            echo "<option value='{$dane[0]}'>{$dane[0]}.{$dane[1]} {$dane[2]}</option>";
                                        }
                                    else
                                        echo "<option>brak</option>";
                                        ?>
                                </select>
                            </p>

                            <p>
                                <input type="hidden" name="operacja" value="samolot"/>
                                <input type="submit" value="Zatwierdź" />
                            </p>
                        </fieldset>
                    </form>
                </div>

            </ul>
        </div>
    </div>

</body>

</html>