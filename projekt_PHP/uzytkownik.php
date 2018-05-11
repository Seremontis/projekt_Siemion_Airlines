<?php
include ('polaczenie.php');
try{
    $PDO=new PDO=(LOGIN,UZYTKOWNIK,HASLO);
}
catch(PDOException $e){
    echo $e->getMessage();
}
?>
<!DOCTYPE html>

<html class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="panel użytkownika">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="uzytkownik.css">
</head>

<body>
    <div id="wyszukiwarka">
        <form action="uzytkownik.php" method="GET">
            <fieldset>
                <legend>
                    <h1>Wyszukiwarka</h1>
                </legend>
                <p>Skąd:
                    <select name="skad" id="skad">
                        <?php
                        $sql="SELECT ";
                        ?>
                    </select>
                </p>
                </select>
                <p>
                    Dokąd:

                    <select name="dokad" id="dokad">
                        <option>test1</option>
                        <option>test2</option>
                    </select>
                </p>
                <p>
                <input type="submit" content="Wyszukaj">
                <input type="reset" content="Wyczyść">
                </p>

            </fieldset>
        </form>
    </div>

</body>

</html>