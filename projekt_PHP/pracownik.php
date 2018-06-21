<?php
require('pracownikp.php');
wykonaj();
kontrolaDostepu();
dodajDoBazy();

function wykonaj(){
require_once('polaczenie.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Siemion Airlines-panel pracownika</title>
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
        $("#nowpra").hide();
            $("#dodajroz").click(function () {
                $("#rozklad").toggle("slow", function () {
                });
                $("#samolot").hide(function () { });
                $("#trasa").hide(function () { });
                $("#nowpra").hide(function () { });
            });
            $("#dodajsam").click(function () {
                $("#samolot").toggle("slow", function () {
                });
                $("#rozklad").hide(function () { });
                $("#trasa").hide(function () { });
                $("#nowpra").hide(function () { });
            });
            $("#dodajtrase").click(function () {
                $("#trasa").toggle("slow", function () {
                });
                $("#samolot").hide(function () { });
                $("#rozklad").hide(function () { });
                $("#nowpra").hide(function () { });
            });

            $("#nowypracownik").click(function () {
                $("#nowpra").toggle("slow", function () {
                });
                $("#samolot").hide(function () { });
                $("#rozklad").hide(function () { });
                $("#trasa").hide(function () { });
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
                    <button id="dodajsam" <?php if(!isset($_SESSION['uprawnienia'])) echo "disabled style='background-color:gray;color:red;'"; ?> >Dodaj samolot</button>
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
                    <button id="dodajtrase" <?php if(!isset($_SESSION['uprawnienia'])) echo "disabled style='background-color:gray;color:red;'"; ?>>Dodaj trasę</button>
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
                            <p>Trasa(<i>zalecana pojemność</i>):
                                <select name="trasa">
                                    <?php

                                $sql="SELECT id_trasy,skad,dokad,zalecana_pojemnosc FROM trasa";
                                $zapytanie=$baza->query($sql);
                                if($zapytanie->rowCount()>0){
                                    while($dane=$zapytanie->fetch()){
                                        echo "<option value='{$dane[0]}'>{$dane[1]}-{$dane[2]}({$dane[3]})</option>";
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
                <li>
                    <button id="nowypracownik" <?php if(!isset($_SESSION['uprawnienia'])) echo "disabled style='background-color:gray;color:red;'"; ?> >Dodaj pracownika</button>
                </li>
                <div id="nowpra">
                    <form action="pracownik.php" method="POST">
                        <fieldset>
                            <p>Imie:
                                <input type="text" name="imie" placeholder="Imie" value="<?php if(isset($_SESSION['imie'])) { echo $_SESSION["imie"]; unset ($_SESSION["imie"]);} ?>" required />
                            </p>
                            <p>Nazwisko:
                                <input type="text" name="nazwisko" placeholder="Nazwisko" value="<?php if(isset($_SESSION['nazwisko'])) { echo $_SESSION["nazwisko"]; unset ($_SESSION["nazwisko"]);} ?>" required/>
                            </p>
                            <p>Nr PESEL lub nr dowodu :
                                <input type="text" name="pesel" placeholder="pesel lub nr dowodu" minlength="9" maxlength="11" value="<?php if(isset($_SESSION['pesel'])) { echo $_SESSION["pesel"]; unset ($_SESSION["pesel"]);} ?>" required/>
                            </p>

                            <p>E-mail:
                                <input type="mail" name="mail" placeholder="mail" value="<?php if(isset($_SESSION['mail'])) { echo $_SESSION["mail"]; unset ($_SESSION["mail"]);} ?>" required/>
                            </p>
                            <p>Telefon:
                                <input type="tel" name="telefon" placeholder="telefon" minlength="9" value="<?php if(isset($_SESSION['telefon'])) { echo $_SESSION["telefon"]; unset ($_SESSION["telefon"]);} ?>" required/>
                            </p>
                            <p>Adres zamieszkania:
                                <input type="text" name="adres" placeholder="adres" value="<?php if(isset($_SESSION['adres'])) { echo $_SESSION["adres"]; unset ($_SESSION["adres"]);} ?>" />
                            </p>
                            <p>Login:
                                <input type="text" name="login" placeholder="login" value="<?php if(isset($_SESSION["login"])) { echo $_SESSION["login"]; unset ($_SESSION["login"]);} ?>" required/>
                            </p>
                            <p>Hasło:
                                <input type="password" name="haslo" placeholder="hasło" required/>
                            </p>
                            <p>Uprawnienia:<select name="upr">
                                
                                <option value="0" <?php if(isset($_SESSION['upr'])==0) {echo "selected"; unset ($_SESSION['upr']);} ?>>Zwykły pracownik</option>
                                <option value="1" <?php if(isset($_SESSION['upr'])==1) {echo "selected"; unset ($_SESSION['upr']);} ?>>Super pracownik</option>
                                    </select>
                            </p>

                            <p>
                                <input type="hidden" name="operacja" value="pracownik"/>
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
<?php
}
?>