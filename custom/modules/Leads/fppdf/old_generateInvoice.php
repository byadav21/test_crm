<?php
require('custom/modules/Leads/fppdf/fpdf.php');
 //~ require('fpdf.php');
//~ ini_set('display_errors','1');
class PDF extends FPDF
{
// Page header
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
	function Footer()
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
		$this->Cell(0,-10,$leads->payment_source,0,1);
		$this->SetFont('Arial','I',10);
		//~ $this->Ln(-10);
		$this->Cell(90);
		$this->Cell(0,10,'Page '.$this->PageNo().' of {nb}',0,0,'C');
	}
}
if(isset($_REQUEST['LeadID']) && !empty($_REQUEST['LeadID'])){
	$lead_id = trim($_REQUEST['LeadID']);
	$lead = new Lead();
	$lead->retrieve($lead_id);
	$to = $lead->first_name." ".$lead->last_name;
// Instanciation of inherited class
	$pdf = new PDF();
	 //~ $pdf->SetLineWidth(0.5);
	$pdf->AliasNbPages();
	$pdf->AddPage();

// Invoice To and Phone	
	$pdf->SetFont('Times','',12);
	$pdf->SetTextColor(128);
	$pdf->Cell(0,10,'Invoice to ',0,1);
	$pdf->Ln(-3);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(0,10,$to,0,1);	
	$pdf->SetFont('Times','',12);
	$pdf->Cell(0,10,'Phone ',0,1);
	//~ $pdf->Ln(-3);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15);
	$pdf->Cell(0,-10,$lead->phone_mobile,0,1);	


// Invoice Number
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetTextColor(128);
	$pdf->Cell(0,10,'Invoice',0,1);
	$pdf->SetFont('Times','',13);	
	$invoiceNumber = $lead->invoice_number;
	if($invoiceNumber==0){
		$inv = "SELECT max(invoice_number) as invoice_number from leads";
		$re = $GLOBALS['db']->query($inv);
		$xx = $GLOBALS['db']->fetchByAssoc($re);
		$invoiceNumber = $xx['invoice_number']+1;
		$re = $GLOBALS['db']->query("UPDATE leads SET invoice_number = {$invoiceNumber} WHERE id = '".$lead->id."'" ); 
	}
	$pdf->Cell(0,10,$invoiceNumber,0,1);
	$pdf->Cell(80);
	
	
	$sqlB = "SELECT fees_inr FROM te_ba_batch  WHERE id = '".$lead->te_ba_batch_id_c."'";
	$reB = $GLOBALS['db']->query($sqlB);
	$xxB = $GLOBALS['db']->fetchByAssoc($reB);
	$cost = $xxB['fees_inr'];
	$total = $cost;
	$subtotal = $cost;
	$tax = ($subtotal * $GLOBALS['sugar_config']['tax']['service'])/100;
	$gross = $total + $tax;
	
	
	
// Set Amount	
	$title = "  ".number_format($gross,2);
	$pdf->SetFont('Arial','B',20);
	$w = $pdf->GetStringWidth($title)+90;
	
    $pdf->SetX((295-$w)/2);
    // Colors of frame, background and text
    //~ $pdf->SetDrawColor(0,80,180);
    $pdf->SetFillColor(0,0,0);
    $pdf->SetTextColor(255,255,255);
    // Thickness of frame (1 mm)
    //~ $pdf->SetLineWidth(1);
    // Title
    $pdf->Cell($w,-22,$title,1,1,'',true);
    $cont = "    Thank you for your purchase!";
    //~ $pdf->SetX((302-$w)/2);
    
    $pdf->SetX(-($pdf->GetStringWidth(number_format(11500,2))+93));
	$pdf->Image('custom/modules/Leads/fppdf/download.png',$pdf->GetX(),80,4);
	
    $pdf->SetY(85);
    $pdf->Cell(75);
    $pdf->SetFont('Arial','',10);
	$pdf->Cell($w,5,$cont,1,1,'L',true);
	$pdf->SetTextColor(128);
	//~ 
	
	
	//~ $pdf->Cell(120,-30,'Title',1,0,'L');

// Item Header	
	$pdf->Ln(22);
	$pdf->SetFont('Times','B',13);	
	$pdf->Cell(0,10,'Description',0,1);
	$pdf->Cell(80);
	$pdf->Cell(0,-10,'Cost',0,1);	
	$pdf->Cell(110);
	$pdf->Cell(0,10,'Qty',0,1);	
	$pdf->Cell(178);
	$pdf->Cell(0,-10,'Total',0,1);
	$pdf->Line(200,120,10,120);
	
// item Details
	$sql_pro = "SELECT te_pr_programs_te_ba_batch_1te_pr_programs_ida,name FROM te_pr_programs p INNER JOIN te_pr_programs_te_ba_batch_1_c  pb ON p.id = pb.te_pr_programs_te_ba_batch_1te_pr_programs_ida WHERE te_pr_programs_te_ba_batch_1te_ba_batch_idb = '".$lead->te_ba_batch_id_c."' AND pb.deleted = 0 AND p.deleted=0";
	$res_pro = $GLOBALS['db']->query($sql_pro);
	$pro = $GLOBALS['db']->fetchByAssoc($res_pro);
	$pdf->Ln(10);
	//~ $pdf->SetFont('Times','B',13);
	$pdf->SetFont('Times','',12);		
	$pdf->MultiCell(75,5,$pro['name'],0,1);
	$pdf->Cell(80);
	
	$pdf->Cell(0,-10,number_format($cost,2),0,1);	
	$pdf->SetX(89);
	$pdf->Image('custom/modules/Leads/fppdf/rs.png',$pdf->GetX(),126,1.8);
	$pdf->Cell(110);
	$pdf->SetX(122);
	$pdf->Cell(0,10,'1',0,1);	
	$pdf->Cell(165);
	
	$pdf->Cell(0,-10,number_format($total,2),'',0,'R');
	$pdf->SetX(-($pdf->GetStringWidth(number_format($total,2))+13));
	$pdf->Image('custom/modules/Leads/fppdf/rs.png',$pdf->GetX(),126,1.8);
	$pdf->Line(200,136,10,136);
	
// Totals 
	$pdf->Ln(10);
	$pdf->Cell(80);
	$pdf->Cell(0,10,'Subtotal',0,1);
	$pdf->Cell(165);
	
	$pdf->Cell(0,-10,number_format($subtotal,2),'',0,'R');
	$pdf->SetX(-($pdf->GetStringWidth(number_format($subtotal,2))+13));
	
	$pdf->Image('custom/modules/Leads/fppdf/rs.png',$pdf->GetX(),146,1.8);
	$pdf->Ln(1);
	$pdf->Cell(80);
	$pdf->Cell(0,10,'Tax',0,1);
	$pdf->Cell(165);
	
	
	$pdf->Cell(0,-10,number_format($tax,2),'',0,'R');
	$pdf->SetX(-($pdf->GetStringWidth(number_format($tax,2))+13));
	$pdf->Image('custom/modules/Leads/fppdf/rs.png',$pdf->GetX(),157,1.8);
	$pdf->Line(91,162,200,162);
	$pdf->Ln(1);
	$pdf->Cell(80);
	$pdf->Cell(0,10,'Total',0,1);
	$pdf->Cell(165);
	
	
	$pdf->Cell(0,-10,number_format($gross,2),'',0,'R');
	$pdf->SetX(-($pdf->GetStringWidth(number_format($gross,2))+13));
	$pdf->Image('custom/modules/Leads/fppdf/rs.png',$pdf->GetX(),168,1.8);
	$pdf->Ln(15);
	$pdf->SetFont('Arial','',12);	
	$pdf->Cell(0,10,'Items will be shipped within 2 days.',0,1);
	
	
	$pdf->Output();
}
else{
		die("Error");
}
