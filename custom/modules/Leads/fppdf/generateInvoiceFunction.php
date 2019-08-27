<?php

function generatePdf($params=array(),$saveFile='No'){ 
	//~ ini_set("display_errors",1);
	require('custom/modules/Leads/fppdf/invoiceClass.php');
	$to = $params['invoice_to'];
	$mobile = $params['mobile'];
	$invoiceNumber = $params['invoiceNumber'];
	$cost = $params['cost'];
	$total = $params['total'];
	$subtotal = $params['subtotal'];
	$tax = $params['tax'];
	$gross = $params['gross'];
	$program_name = $params['program_name'];
	$payment_source = $params['payment_source'];
	if(isset($params['payment_made'])&&$params['payment_made']!=""){
		$payment_made = $params['payment_made'];	
	}else{
		$payment_made = "";	
	}
	
	
// Instanciation of inherited class
	$pdf = new PDF();
	 //~ $pdf->SetLineWidth(0.5);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->method =$payment_source;
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
	$pdf->Cell(0,-10,$mobile,0,1);	


// Invoice Number
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',20);
	$pdf->SetTextColor(128);
	$pdf->Cell(0,10,'Invoice',0,1);
	$pdf->SetFont('Times','',13);	
	
	$pdf->Cell(0,10,$invoiceNumber,0,1);
	$pdf->Cell(80);
	
	
	
	
	//~ $gross = '10';
// Set Amount	
	$title = "  ".number_format($gross,2);
	$pdf->SetFont('Arial','B',20);
	$w = $pdf->GetStringWidth($title)+100;
	
    //~ $pdf->SetX((295-$w)/2);
    $pdf->SetX(-125);
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
    
    $pdf->SetX(-124);
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
	$pdf->Ln(15);
	//~ $pdf->SetFont('Times','B',13);
	$pdf->SetFont('Times','',12);		
	$pdf->MultiCell(75,5,$program_name,0,1);
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
	
	
	if($saveFile=='Yes'){
		if($payment_made=="Yes"){	# If making payment for student
			$path = "upload/student_payment/";
			$filename=$path.date('Y-m-d')."_".rand()."_Payment-Invoice.pdf";
		}else{
			$path = "upload/";
			$filename=$path.date('Y-m-d-H-i-s')."-Student-Invoice.pdf";
		}
		$pdf->Output($filename,'F');
		return $filename;
	}
	else{	
		$pdf->Output();
	}
}
