<?php
session_start();
require('zalogujp.php');

if(isset($_SESSION['rej'])){
    echo '<script>alert("'.$_SESSION['rej'].'");</script>';
    unset($_SESSION['rej']);
}
if(isset($_POST['log'])==1)
    $klasa=new Zaloguj();

?>


<!DOCTYPE HTML>
<html>

<head>
    <title>Siemion Airlines</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <title>Logowanie</title>
    <meta name="description" content="Rejestracja do Siemion Airlines">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Karol Ścigała">
    <link rel="stylesheet" type="text/css" href="css/zaloguj.css" />
</head>

<body>

    <div class="kontener">
        <main>

            <fieldset>
                <legend>Logowanie</legend>
                <form action="zaloguj.php" method="POST" accept-charset="UTF-8">
                    <p>
                        <input type="text" name="login" value="<?php if(isset($_SESSION['nick'])){ echo $_SESSION['nick']; unset ($_SESSION['nick']);}?>" placeholder="Login" required/>
                    </p>

                    <p>
                        <input type="password" name="haslo" placeholder="Hasło" required/>
                    </p>
                    <p>
                        <label><input type="checkbox" name="kto" value="Pracownik" style="width:20px;" <?php if(isset($_SESSION["check"])){ echo "checked"; unset ($_SESSION["check"]);}?>>Jestem pracownikiem</input></label>
                    </p>
                    <p>
                        <input type="hidden" name="log" value="1"/>
                        <input type="submit" class="zatwierdz" value="Zaloguj" />
                    </p>
                    <p id="zle" style="margin-top:10px;">
                    <?php
                    echo "<span style='color:rgb(148, 6, 6);'>";
                    if(isset($_SESSION["blad"])) { echo $_SESSION["blad"]; unset ($_SESSION["blad"]);}
                    echo "</span>";
                    
                
                    ?>
                    </p>
                </form>
            </fieldset>
            <div class="odsylacz">
                <div class="powrot"><a href="index.php">Powrót</a></div>
                <div style="cler:both;"></div>
                <div class="rejestracja"><a href="zarejestruj.php">Rejestracja</a></div>
            </div>
</main>
    </div>

</body>

</html>