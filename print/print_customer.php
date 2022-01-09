<?php
ob_start();
include('../db_connect.php');
require('../fpdf/fpdf.php');

class PDF extends FPDF {
	function Header(){
		$this->SetFont('Arial','B',15);
		
		//dummy cell to put logo
		//$this->Cell(12,0,'',0,0);
		//is equivalent to:
		$this->Cell(12);
		
		//put logo
		
		
		$this->Cell(100,10,'Customer',0,1);
		
		//dummy cell to give line spacing
		//$this->Cell(0,5,'',0,1);
		//is equivalent to:
		$this->Ln(5);
		
		$this->SetFont('Arial','B',11);
		
		$this->SetFillColor(180,180,255);
		$this->SetDrawColor(180,180,255);
		$this->Cell(20,5,'ID#',0,0,'',true);
		$this->Cell(35,5,'Name',0,0,'',true);
        $this->Cell(40,5,'Cel/Tel No.',0,0,'',true);
        $this->Cell(50,5,'Address',0,0,'',true);
        $this->Cell(50,5,'Email',0,0,'',true);
	}
	function Footer(){
		//add table's bottom line
		$this->Cell(190,0,'','T',1,'',true);
		
		//Go to 1.5 cm from bottom
		$this->SetY(-15);
				
		$this->SetFont('Arial','',8);
		
		//width = 0 means the cell is extended up to the right margin
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
	}
}


//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

$pdf = new PDF('P','mm','A4'); //use new class

//define new alias for total page numbers
$pdf->AliasNbPages('{pages}');

$pdf->SetAutoPageBreak(true,15);
$pdf->AddPage();

$pdf->SetFont('Arial','',9);
$pdf->SetDrawColor(180,180,255);

$query = $conn->query("SELECT * FROM customer_list ");
while($row=$query->fetch_assoc())
{   $pdf->Cell(20,5,$row['id'],'LR',0);
    $pdf->Cell(35,5,$row['name'],'LR',0);
    $pdf->Cell(40,5,$row['contact'],'LR',0); 
    $pdf->Cell(50,5,$row['address'],'LR',0);
    $pdf->Cell(50,5,$row['email'],'LR',1);
   
}


$pdf->Output();
?>
<script>
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
</script>
