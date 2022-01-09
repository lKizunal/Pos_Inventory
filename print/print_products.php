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
        $this->Cell(200,5,'Product List',0,0,'C'); //x,y
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
        $this->Cell(25,10,'SKU',1,0,'C');
        $this->Cell(45,10,'Product name',1,0,'C');
        $this->Cell(30,10,'Price',1,0,'C');
        $this->Cell(30,10,'Status',1,0,'C');
        $this->Cell(30,10,'Critical level',1,0,'C');
        $this->Cell(30,10,'Stock Available',1,0,'C');
        
       
        $this->Ln();
	  
    }
    function viewTable($conn){
        $this->SetFont('Times','',10);
        $query= $conn->query("SELECT pL.id, pL.category_id, pL.sku, pL.price, pL.name, pL.description, pL.supplier_id, pL.status, pL.critlvl, CASE WHEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) THEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM receive_list rL WHERE rL.item_id = pL.id) ELSE 0 END)- (CASE WHEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) > 0 THEN (SELECT SUM(quantity) FROM sales_list sL WHERE sL.item_id = pL.id) ELSE 0 END) ELSE 0 END AS stock_available FROM product_list pL GROUP BY pL.id;");
		while($row=$query->fetch_assoc())
{
        $this->Cell(25,10,$row['sku'],1,0,'C');
        $this->Cell(45,10,$row['name'],1,0,'C');
        $this->Cell(30,10,$row['price'],1,0,'C');
        $this->Cell(30,10,$row['status'],1,0,'C');
        $this->Cell(30,10,$row['critlvl'],1,0,'C');
        $this->Cell(30,10,$row['stock_available'],1,0,'C');
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
