<?php

include('../db_connect.php');
require('../fpdf/fpdf.php');
date_default_timezone_set("Asia/Manila");
$date =date("d-m-Y");
class PDF extends FPDF {

    function header(){
        global $date;
       // $this->Image('logo.png',10,6);
        $this->SetFont('Arial','B',14); //font-style,bold,font-size
        $this->Cell(200,5,'Sales Report',0,0,'C'); //x,y
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(200,10,$date,0,0,'C');
        $this->Ln(20);
    }

    function footer(){
        $this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page '.$this->PageNo()." / {pages}",0,0,'C');
    }
    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(40,10,'Transact ID',1,0,'C');
        $this->Cell(55,10,'Date of transaction',1,0,'C');
        $this->Cell(55,10,'Customer Name',1,0,'C');
        
       
        $this->Ln();
	  
    }
    function viewTable($conn){
        $this->SetFont('Times','',12);
        $query = $conn->query("SELECT cL.id, cL.name, sT.date_transact, sT.transact_id FROM sales_transaction sT INNER JOIN customer_list cL ON sT.customer_id=cL.id");
        while($row=$query->fetch_assoc())
{
        $this->Cell(40,10,$row['transact_id'],1,0,'C');
        $this->Cell(55,10,$row['date_transact'],1,0,'C');
        $this->Cell(55,10,$row['name'],1,0,'C');
        $this->Ln();
	    
}
    }
}
$pdf = new PDF(); 
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($conn);
$pdf->Output();
