<?php

const DSN='mysql:host=localhost;dbname=SiemionAirlines;charset=utf8';
const UZYTKOWNIK='root';
const HASLO='';

try{

    $baza=new PDO(DSN,UZYTKOWNIK,HASLO);

}
catch(PDOException $e){
    echo "Bląd połączenia; ".$e->getMessage();
} 


?>