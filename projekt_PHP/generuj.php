<?php
pdf();

function pdf(){
require_once('.\fpdf\fpdf.php');
include ('polaczenie.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Courier','BIU',30);
$pdf->SetTextColor(0, 102, 255);
//$pdf->Cell(190,260,'Hello World!',0,1,'R',TRUE);
$pdf->SetFillColor(153, 255, 51);
$pdf->Cell(80,50,'','LTB',0,'R',true);
$pdf->Image('.\img\airplane-shape.png',20,15,40);
$pdf->Cell(100,50,'Siemion Airlines','TB',0,'R',TRUE);
$pdf->Cell(10,50,'','RTB',1,'C',TRUE);
$pdf->SetFont('Arial','BU',20);
$pdf->SetTextColor(0, 0, 0);
$str="Rozkład jazdy:";
$str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
$pdf->Cell(190,50,$str,0,1,'C');
$pdf->SetFont('Arial','',12);

$linia="SELECT r.Data,r.godzina,t.Skad,t.dokad,concat(s.marka,' ',s.model) FROM rozklad r,trasa t,samolot s WHERE r.id_trasy=t.id_trasy and r.id_samolotu=s.id_samolotu";
$wyk=$baza->query($linia);
$ilosc=$wyk->rowCount();
if($ilosc==0)
    $pdf->Cell(190,50,"Brak lotów",1,1);
else{
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(10,10,"L.p.",1,0,'C');
    $pdf->Cell(36,10,"Data",1,0,'C');
    $pdf->Cell(36,10,"Godzina",1,0,'C');
    $pdf->Cell(36,10,"Odlot",1,0,'C');
    $pdf->Cell(36,10,"Przylot",1,0,'C');
    $pdf->Cell(36,10,"Samolot",1,1,'C');
    $pdf->SetFont('Arial','',12);
$y=1;
while($dane=$wyk->fetch()){
        $pdf->Cell(10,15,"{$y}.",1,0,'C');
    for($i=0;$i<5;$i++){
        $dane[$i] = iconv('UTF-8', 'ASCII//TRANSLIT', $dane[$i]);
        if($i==4)
            $pdf->Cell(36,15,"$dane[$i]",1,1,'C');
        else
            $pdf->Cell(36,15,"$dane[$i]",1,0,'C');          
    }
    $y++;
}
}


$pdf->Output();
}

?>