<?php
require('custom/modules/Leads/fppdf/fpdf.php');
 //~ require('fpdf.php');
//~ ini_set('display_errors','1');
class PDF extends FPDF
{
// Page header
	public $method ='11';
	function Header()
	{
		// Logo
		//~ $this->Image('logo.png',10,6,30);
		// Arial bold 15
		$this->SetFont('Arial','B',28);
		// Move to the right
		//~ $this->Cell(80);
		// Title
		
		$this->Ln(6);
		//~ $this->Cell(3);
		//~ $this->Cell(30,10,'Talentedge',0,0,'L');
		$this->Cell(30,10,'Test',0,0,'L');
		// Line break
		$this->Ln(20);
	}

	// Page footer
	function Footer($method='')
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','B',10);
		// Page number
		$this->SetLineWidth(0.5);
		$this->Line(220,282,0,282);
		$leads = new Lead();
		$leads->retrieve(trim($_REQUEST['LeadID']));
		//~ echo "<pre>";
		//~ print_r($leads);
		$this->Cell(0,10,'Payment method ',0,1);
		$this->Cell(30);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,-10,$this->method,0,1);
		$this->SetFont('Arial','I',10);
		//~ $this->Ln(-10);
		$this->Cell(90);
		$this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'C');
	}
}
