<?php
session_start();
require ('formularzpracownikap.php');
require_once ('polaczenie.php');

if(isset($_POST['modyf'])){       
        $klasa=new Formularz();     
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Formularz edycji</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" media="screen" href="css/formularz.css" />
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
    <div class="kontener">
        
        
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
                            </p>
                            </form>
                            <p>
                                <a class="abutton" href=".\pracownik2.php?co=samolot">Powrót</a>
                            </p>
                        </fieldset>
                
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
                            </p>
                            </form>
                            <p>
                                <a class="abutton" href=".\pracownik2.php?co=trasa">Powrót</a>
                            </p>
                        </fieldset>
                    
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
                            </p>
                            </form>
                            <p>
                                <a class="abutton" href=".\pracownik2.php?co=rozklady">Powrót</a>
                            </p>
                        </fieldset>
                                    <?php } ?>
                </div>

            <div id="edytujklienci">
                <?php if(isset($_POST["edytujklienci"])){
                            $sql="SELECT * FROM klienci where id_klienta=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujklienci"]));
                            $rzad=$zapytanie->fetch();
                            $_SESSION['haslo']=$rzad[7];
                            ?>

                <form action="formularzpracownika.php" method="POST">
                    <p>
                        Imię: <input type="text" name="imie" value="<?php echo $rzad[1] ?>" placeholder="Imię" required />
                    </p>

                    <p>
                        Nazwisko: <input type="text" name="nazwisko"  value="<?php echo $rzad[2] ?>"  placeholder="Nazwisko" required />
                    </p>

                    <p>
                        PESEL bądź dowód<input type="text" name="pesel" value="<?php echo $rzad[3] ?>"  placeholder="Pesel lub nr dowodu osobistego" required />
                    </p>

                    <p>
                        E-mail:<input type="email" name="mail" value="<?php echo $rzad[4] ?>" placeholder="E-mail" required/>
                    </p>
                    <p>
                        Telefon<input type="tel" name="telefon"  value="<?php echo $rzad[5] ?>"  placeholder="Telefon" required/>
                    </p>
                    <hr/>
                    <p>
                        Login <input type="login" name="login"  value="<?php echo $rzad[6] ?>"  placeholder="Login" required/>
                    </p>
                    <p>
                        Hasło :<input type="password" name="haslo" value="<?php echo $rzad[7] ?>" placeholder="Hasło" required/>
                    </p>

                    <p>
                                <input type="hidden" name="modyf" value="klienci"/>
                                <input type="hidden" name="id" value="<?php echo $_POST["edytujklienci"]; ?>"/>
                                <input type="submit" value="Zatwierdź" />
                    </p>
                    </form>
                            <p>
                                <a  class="abutton" href=".\pracownik2.php?co=klienci">Powrót</a>
                            </p>

                    
                </fieldset>
                <?php } ?>
            </div>

            <div id="edytujpracownika">
                <?php if(isset($_POST["edytujpracownicy"])){
                            $sql="SELECT * FROM pracownicy where id_pracownika=?";
                            $zapytanie=$baza->prepare($sql);
                            $zapytanie->execute(array($_POST["edytujpracownicy"]));
                            $rzad=$zapytanie->fetch();
                            $_SESSION['haslo']=$rzad[8];
                            ?>
                        
                <form action="formularzpracownika.php" method="POST">
                    <p>
                        Imię: <input type="text" name="imie" value="<?php echo $rzad[1] ?>" placeholder="Imię" required />
                    </p>

                    <p>
                        Nazwisko: <input type="text" name="nazwisko"  value="<?php echo $rzad[2] ?>"  placeholder="Nazwisko" required />
                    </p>

                    <p>
                        PESEL bądź dowód<input type="text" name="pesel" value="<?php echo $rzad[3] ?>"  placeholder="Pesel lub nr dowodu osobistego"  />
                    </p>

                    <p>
                        E-mail:<input type="email" name="mail" value="<?php echo $rzad[4] ?>" placeholder="E-mail"/>
                    </p>
                    <p>
                        Telefon<input type="tel" name="telefon"  value="<?php echo $rzad[5] ?>"  placeholder="Telefon"/>
                    </p>
                    <p>Adres zamieszkania:
                                <input type="text" name="adres" placeholder="adres" value="<?php echo $rzad[6] ?>" required />
                    </p>
                    <hr/>
                    <p>
                        Login <input type="login" name="login"  value="<?php echo $rzad[7] ?>"  placeholder="Login" required/>
                    </p>
                    <p>
                        Hasło :<input type="password" name="haslo" value="<?php echo $rzad[8]; $_SESSION['haslo']=$rzad[8]; ?>" placeholder="Hasło" required/>
                    </p>
                    <p>Uprawnienia:<select name="upr">
                                
                                <option value="0">Zwykły pracownik</option>
                                <option value="1" <?php if($rzad[9]==1) echo "selected"; ?>>Super pracownik</option>
                                    </select>
                            </p>

                    <p>
                                <input type="hidden" name="modyf" value="pracownicy"/>
                                <input type="hidden" name="id" value="<?php echo $_POST["edytujpracownicy"]; ?>"/>
                                <input type="submit" value="Zatwierdź" />
                                </p>
                    </form>
                            <p>
                                <a class="abutton" href=".\pracownik2.php?co=pracownicy">Powrót</a>
                            </p>

                    
                </fieldset>
                <?php } ?>
            </div>
            

    </div>
</body>
</html>