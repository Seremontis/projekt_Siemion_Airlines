    <?php
    require ('pracownik2p.php');
    ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SiemionAirlines-panel pracownika</title>
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
        <button type="submit" name="co" value="samolot">Samoloty</button>
        <button type="submit" name="co"  value="rozklady">Rozkłady</button>
        <button type="submit" name="co" value="rezerwacje">Rezerwacje</button>
        <button type="submit" name="co"  value="trasa">Trasy</button>
        <button type="submit" name="co" value="klienci" >Klienci</button>
        <button type="submit" name="co" value="pracownicy" <?php if(!isset($_SESSION['uprawnienia'])) echo "disabled style='background-color:gray;color:red;'"; ?> >Pracownicy</button>
        
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
        case "pracownicy":
            wykaz("pracownicy");
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