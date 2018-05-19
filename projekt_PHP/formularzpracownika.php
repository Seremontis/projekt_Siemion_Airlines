<?php

require('polaczenie.php');

session_start();

if(isset($_SESSION["zalogowany"])==false || empty($_SESSION["zalogowany"])==true || $_SESSION["zalogowany"]!="Pracownik"){
    echo "<script>alert('Nie ma uprawnień do tego miejsca, zaloguj się');
    window.location.href = 'index1.php';</script>";
    exit;

}
if(isset($_POST['modyf']))
    $zmienna=$_POST['modyf'];
else
    $zmienna="";

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

    break;

    case "klienci":
    
    $sql="UPDATE klienci SET Imie=:imie,Nazwisko=:naz,PESEL=:pes,mail=:mail,telefon=:tel,login=:log,haslo=:has WHERE id_kLienta=:id";
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

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formularz edycji</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="formularz.css" />
   <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
    <script>

        $(document).ready(function () {
        $("#rozklad").hide();
        $("#edytujsamolot").hide();
        $("#edytujklienci").hide();
        $("#edytujtrasa").hide();
        $("#<?php if(isset($_POST["edytujsamolot"]))
                    echo "edytujsamolot";
                    else if(isset($_POST["edytujroz"]))
                    echo "rozklad";
                    else if(isset($_POST["edytujtrasa"]))
                    echo "edytujtrasa";
                    else if(isset($_POST["edytujklienci"]))
                    echo "edytujklienci"; ?>").show();

        });
    </script>
</head>
<body>
    <div id="kontener">
        
        
                <div id="edytujsamolot">
                 <?php if(isset($_POST["edytujsamolot"])){
                            $sql="SELECT * FROM samolot where id_samolotu=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujsamolot"]));
                            $rzad=$zapytanie->fetch();
                            ?>
                <form action="formularzpracownika.php" method="POST">
                        <fieldset>
                            <p>Model:
                                <input type="text" name="model1" placeholder="Model" value="<?php echo $rzad[1];?>" required />
                            </p>
                            <p>Marka:
                                <input type="text" name="marka1" placeholder="Marka" value="<?php echo $rzad[2];?>" required/>
                            </p>
                            <p>Nr taborowy:
                                <input type="text" name="nr_taborowy1" placeholder="Nr_taborowy" maxlength="5" value="<?php echo $rzad[3];?>" required/>
                            </p>

                            <p>ilosc miejsc:
                                <input type="number" name="pojemnosc1" placeholder="pojemność" value="50" value="<?php echo $rzad[4];?>" required/>
                            </p>

                            <p>
                                <input type="hidden" name="modyf" value="samolot"/>
                                <input type="hidden" name="id" value="<?php echo $rzad[0];?>"/>
                                <input type="submit" value="Zatwierdź" />
                                <button><a href="http://localhost/projekt_PHP/pracownik2.php">Powrót</a></button>
                            </p>
                        </fieldset>
                </form>
                    <?php } ?>
                    </div>
                 
            <div id="edytujtrasa">
                 <?php if(isset($_POST["edytujtrasa"])){
                            $sql="SELECT * FROM trasa where id_trasy=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujtrasa"]));
                            $rzad=$zapytanie->fetch();
                            ?>
                    <form action="formularzpracownika.php" method="POST">
                    <fieldset>
                            <p>Skąd:
                                <input type="text" name="start" placeholder="Skąd" value="<?php echo $rzad[1];?>"  required/>
                            </p>
                            <p>Dokąd:
                                <input type="text" name="meta" placeholder="Dokąd" value="<?php echo $rzad[2];?>"  required/>
                            </p>
                            
                            <p>Zalecana pojemność:
                                <input type="number" name="pojemnosc" placeholder="Zalecana pojemność" value="<?php echo $rzad[3];?>" required/>
                            </p>

                            <p>
                                <input type="hidden" name="modyf" value="trasa"/>
                                <input type="hidden" name="id" value="<?php echo $rzad[0];?>"/>
                                <input type="submit" value="Zatwierdź" />
                                <button><a href="http://localhost/projekt_PHP/pracownik2.php">Powrót</a></button>
                            </p>
                        </fieldset>
                    </form>
                 <?php } ?>
            </div>

                    <div id="rozklad">
                    <?php if(isset($_POST["edytujroz"])){
                            $sql="SELECT * FROM rozklad where id_rozkladu=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujroz"]));
                            $rzad=$zapytanie->fetch();
                            ?>
                    <form action="formularzpracownika.php" method="POST">
                        <fieldset>
                            <p>Data:
                                <input type="date" name="data" placeholder="Data" value="<?php echo $rzad[1];?>" required/>
                            </p>
                            <p>Godzina:
                                <input type="time" name="godzina" placeholder="time" value="<?php echo $rzad[2];?>"  required/>
                            </p>
                            <p>Trasa:
                                <select name="trasa" id="t">
                                    <?php

                                $sql="SELECT id_trasy,skad,dokad FROM trasa";
                                $zapytanie=$baza->query($sql);
                                if($zapytanie->rowCount()>0){
                                    while($dane=$zapytanie->fetch()){
                                        if($dane[0]==$rzad[3])
                                        echo "<option selected value='{$dane[0]}'>{$dane[1]}-{$dane[2]}</option>";
                                        else
                                        echo "<option value='{$dane[0]}'>{$dane[1]}-{$dane[2]}</option>";

                                    }
                                }
                                else
                                    echo "<option>brak</option>";
                                    ?>
                                </select>
                                
                            </p>

                            <p>Samolot:
                                <select name="samolot" id="s">
                                <?php
                                $sql="SELECT id_samolotu,model,marka FROM samolot";
                                $zapytanie=$baza->query($sql);
                                    if($zapytanie->rowCount()>0){
                                         while($dane=$zapytanie->fetch())
                                         if($dane[0]==$rzad[4])
                                         echo "<option selected value='{$dane[0]}' >{$dane[1]}-{$dane[2]}</option>";
                                         else
                                         echo "<option value='{$dane[0]}'>{$dane[1]}-{$dane[2]}</option>";
                                         }
                                    else
                                        echo "<option>brak</option>";
                                        ?>
                                </select>
                            </p>

                            <p>
                                <input type="hidden" name="modyf" value="rozklad"/>
                                <input type="hidden" name="id" value="<?php echo $_POST["edytujroz"]; ?>" />
                                <input type="submit" value="Zatwierdź" />
                                <button><a href="http://localhost/projekt_PHP/pracownik2.php">Powrót</a></button>
                            </p>
                        </fieldset>
                    </form>
                                    <?php } ?>
                </div>

            <div id="edytujklienci">
                <?php if(isset($_POST["edytujklienci"])){
                            $sql="SELECT * FROM klienci where id_klienta=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujklienci"]));
                            $rzad=$zapytanie->fetch();
                            ?>

                <form action="formularzpracownika.php" method="POST">
                    <p>
                        Imię: <input type="text" name="imie" value="<?php echo $rzad[1] ?>" placeholder="Imię" require />
                    </p>

                    <p>
                        Nazwisko: <input type="text" name="nazwisko"  value="<?php echo $rzad[2] ?>"  placeholder="Nazwisko" require />
                    </p>

                    <p>
                        PESEL bądź dowód<input type="text" name="pesel" value="<?php echo $rzad[3] ?>"  placeholder="Pesel lub nr dowodu osobistego" require />
                    </p>

                    <p>
                        E-mail:<input type="email" name="mail" value="<?php echo $rzad[4] ?>" placeholder="E-mail" require/>
                    </p>
                    <p>
                        Telefon<input type="tel" name="telefon"  value="<?php echo $rzad[5] ?>"  placeholder="Telefon" require/>
                    </p>
                    <hr/>
                    <p>
                        Login <input type="login" name="login"  value="<?php echo $rzad[6] ?>"  placeholder="Login" require/>
                    </p>
                    <p>
                        Hasło :<input type="password" name="haslo" value="<?php echo $rzad[7] ?>" placeholder="Hasło" require/>
                    </p>

                    <p>
                                <input type="hidden" name="modyf" value="klienci"/>
                                <input type="hidden" name="id" value="<?php echo $_POST["edytujklienci"]; ?>"/>
                                <input type="submit" value="Zatwierdź" />
                                <button><a href="http://localhost/projekt_PHP/pracownik2.php">Powrót</a></button>
                            </p>

                    </form>
                </fieldset>
                <?php } ?>
            </div>
            

    </div>
</body>
</html>