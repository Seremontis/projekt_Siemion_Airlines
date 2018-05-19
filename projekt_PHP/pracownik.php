<?php
session_start();

if(isset($_SESSION["zalogowany"])==false || empty($_SESSION["zalogowany"])==true || $_SESSION["zalogowany"]!="Pracownik"){
        echo "<script>alert('Nie ma uprawnień do tego miejsca, zaloguj się');
        window.location.href = 'index1.php';</script>";
        exit;

}

include ('polaczenie.php');

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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Siemion Airlines-VIP</title>
    <meta name="description" content="Rejestracja do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" href="pracownik.css" />
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>

        $(document).ready(function () {
        $("#rozklad").hide();
        $("#samolot").hide();
        $("#trasa").hide();
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
                    <form action="pracownik.php" method="POST">
                        <fieldset>
                            <p>Model:
                                <input type="text" name="model" placeholder="Model" required />
                            </p>
                            <p>Marka:
                                <input type="text" name="marka" placeholder="Marka" required/>
                            </p>
                            <p>Nr taborowy:
                                <input type="text" name="nr_taborowy" placeholder="nr_taborowy" maxlength="5" required/>
                            </p>

                            <p>ilosc miejsc:
                                <input type="number" name="miejsca" placeholder="pojemność" value="50" required/>
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
                    <form action="pracownik.php" method="POST">
                        <fieldset>
                            <p>Skąd:
                                <input type="text" name="start" placeholder="Skąd" required/>
                            </p>
                            <p>Dokąd:
                                <input type="text" name="meta" placeholder="Dokąd" required/>
                            </p>
                            
                            <p>Zalecana pojemność:
                                <input type="number" name="pojemnosc" placeholder="Zalecana pojemność" value="50" required/>
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
                    <form action="pracownik.php" method="POST">
                        <fieldset>
                            <p>Data:
                                <input type="date" name="data" placeholder="Data" value="<?php echo date('Y-m-d');?>" required/>
                            </p>
                            <p>Godzina:
                                <input type="time" name="godzina" placeholder="time" value="<?php echo date('H:i');?>"  required/>
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
                                <input type="hidden" name="operacja" value="rozklad"/>
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