<?php

include('../db_connect.php');
require('../fpdf/fpdf.php');
date_default_timezone_set("Asia/Manila");
$date =date("m-d-Y");
class PDF extends FPDF {

    function header(){
		global $date;
       // $this->Image('logo.png',10,6);
        $this->SetFont('Arial','B',14); //font-style,bold,font-size
        $this->Cell(200,5,'Inventory Report',0,0,'C'); //x,y
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
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(40,10,'Product Name',1,0,'C');
        $this->Cell(40,10,'Stock In',1,0,'C');
        $this->Cell(20,10,'Stock Out',1,0,'C');
        $this->Cell(40,10,'Stock Available',1,0,'C');
        $this->Cell(35,10,'Status',1,0,'C');
       
        $this->Ln();
	  
    }
    function viewTable($conn){
        $this->SetFont('Times','',12);
        $query = $conn->query("SELECT pL.id as item_id, pL.name as item_name, CASE WHEN(SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END AS stock_in, CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END AS stock_out, CASE WHEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END) - (CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END) > 0 THEN (CASE WHEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM receive_list WHERE item_id = id) ELSE 0 END) - (CASE WHEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) > 0 THEN (SELECT SUM(quantity) FROM sales_list WHERE item_id = id) ELSE 0 END) ELSE 0 END AS stock_available FROM product_list pL GROUP BY pL.id");
        while($row=$query->fetch_assoc()){
            $status = $row['stock_in'] - $row['stock_out'];
            if($status > 0){
                $statusName = "Available";
            }else{
                $statusName = "Unavailable";
            }
            {
                $this->Cell(20,10,$row['item_id'],1,0,'C');
                $this->Cell(40,10,$row['item_name'],1,0,'C');
                $this->Cell(40,10,$row['stock_in'],1,0,'C');
                $this->Cell(20,10,$row['stock_out'],1,0,'C');
                $this->Cell(40,10,$row['stock_available'],1,0,'C');
                $this->Cell(35,10,$statusName,1,0,'C');
				$this->Ln();
            }
        }
    }
}
$pdf = new PDF(); 
$pdf->AliasNbPages('{pages}');
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($conn);
$pdf->Output();
