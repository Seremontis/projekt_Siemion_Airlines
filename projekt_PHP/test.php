<?php

include('polaczenie.php');

$id=5;

$sql="SELECT count(*) FROM rezerwacje WHERE id_rozklad=?";
$zapytanie1=$baza->prepare($sql);
$zapytanie1->execute(array($id));
$rzad=$zapytanie1->fetch();
$ile=$rzad[0];
echo $ile;

?>