<?php
session_start();

require_once('../scripts/swift/lib/swift_required.php');
require_once('../scripts/swift/lib/swift_init.php');  
require_once('../tcpdf/config/tcpdf_config.php');
require_once('../tcpdf/tcpdf.php');
$document="quotation";
$propid="8";
$user="Alpha Muendo";



$l=$_POST['l'];
if(!$l){ $l=$_GET['l']; }
$text=$_POST['email'];

$invoiceno = $l;

class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		// Logo
		//$image_file = K_PATH_IMAGES.'logo.png';
	//$this->Image($image_file, 0, 0, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetFont('helvetica', 'B', 20);
		// Title
	//	$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}
	// Page footer
	public function Footer() {
		
		$logoX = 40; // 
		$logoFileName = "../img/footer.png";
		$logoWidth = 130; // 15mm
		$logoY = 80;
		$logo = $this->PageNo() . ' | '. $this->Image($logoFileName, $logoX, $logoY, $logoWidth);

		@$this->SetX($this->w - $this->documentRightMargin - $logoWidth); // documentRightMargin = 18
		$this->Cell(10,10, $logo, 0, 0, 'C');
	}
}

	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	

include 'dbcon.php';
$l=$invoiceno;


		$fetc = $mysqli->prepare("select id, date_format(create_date ,'%D %b, %Y') dat, buyer, email, postal, contact_person cp, physical, phone, pmodes  from raw_trx where id =?");
		$fetc->bind_param("s", $l);
		$fetc->execute();
		$result = $fetc->get_result();
		while ($rowsz = $result->fetch_assoc()) {
			$id = $rowsz['id'];
			$dat = $rowsz['dat'];
			$c = $rowsz['buyer'];
			$email = $rowsz['email'];
			$postal = $rowsz['postal'];
			$cp = $rowsz['cp'];
			$physical = $rowsz['physical'];
			$phone = $rowsz['phone'];
			$pmode = $rowsz['pmodes'];
		
		 
			@$invdata .= '<table style="width:100%; ">
									<tr style="border:1px solid red;">
										<td style="width:40%"></td>
										<td style="text-align:center;width:20%;"> <img src="../logo.png" style="width:200px;">  </td>
										<td  style="width:40%"></td>
									</tr>
									<tr>
										<td><br /><br /><h5>TL/QT/000'.$id.'</h5></td>
										<td  style="text-align:center;"><br /><b>QUOTATION</b> </td>
										<td><br /><br /><h5 style="float:right;">DATE: '.date("d M, Y").'</h5></td>
									</tr>
									';
								
								$fetc = $mysqli->prepare("select buyer b, phone p, email e, postal po,physical phy, contact_person cp, pmodes m from raw_trx where id= ? ");
								$fetc->bind_param("s", $l);
								$fetc->execute();
								$result = $fetc->get_result();
								while ($rowsz = $result->fetch_assoc()) {
										$b = $rowsz['b'];
										$p = $rowsz['p'];
										$e = $rowsz['e'];
										$po = $rowsz['po'];
										$phy = $rowsz['phy'];
										$cp = $rowsz['cp'];
										$m = $rowsz['m'];
										
								$invdata .= '<tr>
												<td>
													<small>
													'.$b.'<br />
													phone: '.$p.'<br />
													email: '.$e.'<br />
													Address: '.$po.' <br />
													'.$phy.'<br />
													Contact Person : '.$cp.'</small>
													
												</td>
												<td valign="bottom" style="width:33.3333%;text-align:center;"></td> 
												<td>
													<small>
													TECHLINK LIMITED<br />
													P.O Box 397-00623. Nairobi	<br />
													3RD&nbsp;Floor,&nbsp;Tulip&nbsp;Tower,&nbsp;Mpaka Rd,&nbsp;Westlands.<br />
													Phone +254 (20) 4343500 | +254 777434354<br />
													</small>
												</td>
												
											</tr>
										</table>';
											}	
								

            $invdata .= '<div class="card table-responsive mb-12pt">
                                 

                                    <table class="table table-flush">
                                        <tfoot>
                                            <tr>
                                                <td class="text-right text-70"><strong></strong></td>
                                                <td  class="text-right"><strong>.</strong></td>
                                            </tr>
                                      
                                        </tfoot>
                                    </table>
									
									
									
									
									<table style="width:100%;">
                                        <thead>
                                            <tr style="background-color:red;">
												<th  class="text-left">ITEM</th>
												<th >DESCRIPTION</th>
												<th  class="text-left" style=" width:20px;">QTY</th>
												<th class="text-right" style="text-align:right;">UNIT PRICE</th>
												<th class="text-right" style="text-align:right;">TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
										
										
										
										
										
										
										
										
											
					$fetc = $mysqli->prepare("select p.product pr, p.specs de, date_format(s.create_date ,'%D %b, %Y') dat, s.price p, sub_total st, qty q, pmodes pm from sell as s left join products as p  on (s.item = p.id) where r_id = ? ");
									$fetc->bind_param("s", $l);
									$fetc->execute();
									$result = $fetc->get_result();
									while ($rowsz = $result->fetch_assoc()) {
											$pr = $rowsz['pr'];
											$p = $rowsz['p'];
											$st = $rowsz['st'];
											$qs = $rowsz['q'];
											$pm = $rowsz['pm'];
											$desc = $rowsz['de'];
											$dat = $rowsz['dat'];
										
					$invdata .= '<tr>
									<td><small>'.$pr.'</small></td>
									<td style="text-align:left;"><small>'.$desc.'</small></td>
									<td style="text-align:right;"><small>'.$qs.'</small></td>
									<td class="text-right"  style="text-align:right; width:20px;"> <small>'.number_format($p,2).'</small> </td>
									<td class="text-right" style="text-align:right;"><small>'.number_format($st,2).'</small></td>
								</tr>';
								}
										
					$invdata .= '</tbody>  </table>';	
								
									

					$invdata .= '
                                    <table class="table table-flush">
                                        <tfoot>
                                            <tr>
                                                <td class="text-right text-70"><strong></strong></td>
                                                <td  class="text-right"><strong></strong></td>
                                            </tr>
                                      
                                        </tfoot>
                                    </table>						
									  <table class="table table-flush table--elevated" style="width:100%;">
                                    
                                        <tbody>';
										
								$fetcr = $mysqli->prepare("select  sum(price) sp, sum(sub_total) sst from sell  where r_id = ? ");
								$fetcr->bind_param("s", $l);
								$fetcr->execute();
								$resultr = $fetcr->get_result();
								while ($rowszr = $resultr->fetch_assoc()) {
	
										$sst = $rowszr['sst'];
										$sps = (0.14*$sst);
										$tt = $sst+$sps;
										
         	
				$invdata .= '
		         <tr  style="background:#cebede;"> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td class="text-right"  style="padding:0px !important;"><small><strong>SUBTOTAL</strong></small></td>  
					<td class="text-right"  style="padding:0px !important; text-align:right;"><small><strong>'.number_format($sst,2).'</strong>&emsp;</small></td>
				</tr>
				 <tr  style="background:#cebede;"> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td class="text-right"  style="padding:0px !important;"><small><strong>TAX (0.14%)</strong></small></td>  
					<td class="text-right"  style="padding:0px !important; text-align:right;"><small><strong>'.number_format($sps,2).'</strong>&emsp;</small></td>
				</tr>				 
				<tr  style="background:#cebede;"> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td class="text-right"  style="padding:0px !important;"><small><strong>.</strong></small></td>  
					<td class="text-right"  style="padding:0px !important;"><small><strong></strong>&emsp;</small></td>
				</tr>
				<tr  style="background:#52ceca;"> 
					<td style="padding:5px !important;"><small><strong>Thank You For You Business </strong></small></td> 
					<td style="padding:5px !important;"><small><strong> </strong></small></td> 
					<td class="text-right"  style="padding:0px !important;"><small><strong>Total Due</strong></small></td>  
					<td class="text-right"  style="padding:0px !important; text-align:right;"><small><strong>'.number_format($tt,2).'</strong>&emsp;</small></td>
				</tr>
				

		';
	}
									
			$invdata .= '
                                        </tbody>
                                    </table>
                                </div>
								<br />  <br />  <br /> 
								<p style="text-align:center;"><small>3rd FLOOR, TULIP TOWER, MPAKA ROAD WESTLANDS 
								P.O BOX 397-00623 NAIROBI, KENYA <br /> Tel: +254 20 4343500
								Email: info@techlinklimited.co.ke   </small></p>
								<img src="../img/footer.png" style="width:100%;">';
				
				//	echo $invdata;		
				}

											


	
	
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	 $pdf = getPdfSettings();

   $tenantdetails="3456789" ;
 
    $pdf->AddPage("P");
    $pdf->SetFont('dejavusans', '', 10);
	
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(0);
	$pdf->SetFooterMargin(0);
        
		
$tbl = <<<EOD
        $invdata
EOD;

	$filename = "rerer.pdf";

	$pdf->Ln(60);   
    $pdf->writeHTML($tbl, true, true, true, true, '');

        
        $pdfdoc = $pdf->Output($filename, "S");
       //save and email
$invoicedate = $dat;
$emails="alpha.muendo@gmail.com";
$name = $b;
$to =$e;
$from ="sales@techlinklimited.co.ke";
$cc ="alpha.muendo@gmail.com";
$subject = "QUOTATION [ ".date("d-m-Y",strtotime($invoicedate))." ]";
$message1 = $text;
// a random hash will be necessary to send mixed content
//$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
//$eol = PHP_EOL;
// attachment name
$filename = rand(1000,10000).".pdf";
// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output($filename, "S");
$attachment = chunk_split(base64_encode($pdfdoc));
// main header (multipart mandatory)


  $transport = Swift_SmtpTransport::newInstance('mail.techlinklimited.co.ke', 465,'ssl')->setUsername('helpdesk@techlinklimited.co.ke')->setPassword('tuliptechlink');
          $message = Swift_Message::newInstance();
          $mailer = Swift_Mailer::newInstance($transport);
         $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
         
 $message = Swift_Message::newInstance()
			  ->setFrom(array('helpdesk@techlinklimited.co.ke' => 'TECHLINK LIMITED')) // From: 
			  ->setReplyTo('helpdesk@techlinklimited.co.ke')
               //->setTo('frankmutura@gmail.com')
			  ->setTo('alpha.gyl@gmail.com')

         ->setBody($message1)
                ->setSubject($subject);
$message->attach(Swift_Attachment::newInstance($pdfdoc, 'Quotation.pdf','application/pdf'));
     
        if($mailer->send($message)){
			
			$insert_login = $mysqli->prepare("UPDATE raw_trx set status = 1 where id = ?");
			$insert_login->bind_param("s",$l);
			if($insert_login->execute()){
											header('location:../transactions.php');
										}
        }else{
                 echo "Could not send email";
        }
         
// send message






/////////////////////////////////////////////////////////////////////////////

function getPdfSettings() {

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alpha Muendo');
$pdf->SetTitle('QUOTATION #'.$l);
$pdf->SetSubject('QUOTATION - #'.$l);
$pdf->SetKeywords('TCPDF, PDF, quotation, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    $pdf->setPageOrientation('P');
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
    return $pdf;
}


?>


