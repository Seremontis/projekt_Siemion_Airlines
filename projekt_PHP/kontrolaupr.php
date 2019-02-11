<?php 
function kontrolaDostepu(){
    if(isset($_SESSION["zalogowany"])==false || empty($_SESSION["zalogowany"])==true || $_SESSION["zalogowany"]!="Pracownik"){
        echo "<script>alert('Nie ma uprawnień do tego miejsca, zaloguj się');
        window.location.href = 'index.php';</script>";
        exit;
    
    }
}

?>