<?php 

error_reporting(E_ALL);
require_once('./Swift-5.1.0/lib/swift_required.php');
require_once('./Swift-5.1.0/lib/swift_init.php');  
require_once('./tcpdf/config/tcpdf_config.php');
require_once('./tcpdf/tcpdf.php');
$document="quotation";
$propid="8";
$user="Alpha Muendo";



$l=15;
$text='frankmutura@gmail';

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
		$logoFileName = "./images/s2.png";
		$logoWidth = 130; // 15mm
		$logoY = 80;
		$logo = $this->PageNo() . ' | '. $this->Image($logoFileName, $logoX, $logoY, $logoWidth);

		@$this->SetX($this->w - $this->documentRightMargin - $logoWidth); // documentRightMargin = 18
		$this->Cell(10,10, $logo, 0, 0, 'C');
	}
}

	
	 $pdf = getPdfSettings();

   $tenantdetails="3456789" ;
  $invdata = '<table class="tftable printable" width="90%"  style="font-family:Arial,sans-serif;letter-spacing:2px;" > 
        <tr><td><b> NO: </b></td><td></td><td align="right"> Date </td></tr>
        <tr><td colspan="3"></td></tr>
        <tr><td>TO :</td><td colspan="2"> <b>OF </b></td></tr><tr><td colspan="3"></td></tr></table>';

    $pdf->AddPage("P");
    $pdf->SetFont('dejavusans', '', 10);
	

$tbl = <<<EOD
       $invdata 
EOD;

	$filename = "Quotation.pdf";

	$pdf->Ln(60);   
    $pdf->writeHTML($tbl, true, true, true, true, '');

        
        //$pdfdoc = $pdf->Output($filename, "S");
       //save and email
	
	
	
	
	
	
$invoicedate = '2021-02-03 02:05:54';
$text = "Test Body";

$emails="alpha.muendo@gmail.com";
$name = "Alpha Muendo";
$to ='frankmutura@gmail.com';
$from ="sales@techlinklimited.co.ke";
$cc ="alpha.muendo@gmail.com";
$subject = "QUOTATION [ ".date("d-m-Y",strtotime($invoicedate))." ]";
$message1 = $text;
// a random hash will be necessary to send mixed content
//$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
//$eol = PHP_EOL;
// attachment name
//$filename = rand(1000,10000).".pdf";
// encode data (puts attachment in proper format)
//$pdfdoc = $pdf->Output($filename, "S");
//$attachment = chunk_split(base64_encode($pdfdoc));
// main header (multipart mandatory)

$transport = Swift_SmtpTransport::newInstance('mail.techlinklimited.co.ke', 465,'ssl')->setUsername('helpdesk@techlinklimited.co.ke')->setPassword('tuliptechlink');
          $message = Swift_Message::newInstance();
          $mailer = Swift_Mailer::newInstance($transport);
         $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
         
 $message = Swift_Message::newInstance()
              ->setFrom('helpdesk@techlinklimited.co.ke')
			  //->setFrom(array($_SESSION['email'] => 'TECHLINK LIMITED')) // From: 
              ->setTo($to)
			 // ->setReplyTo("alpha.gyl@gmail.com")
               //->setTo('frankmutura@gmail.com')
         ->setBody($message1)
                ->setSubject($subject);
//$message->attach(Swift_Attachment::newInstance($pdfdoc, 'Quotation.pdf','application/pdf'));
     
        if($mailer->send($message)){
			
			echo "Send";
        }else{
                 echo "Could not send email";
        }
         
// send message







function getPdfSettings() {

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Alpha Muendo');
$pdf->SetTitle('QUOTATION #');
$pdf->SetSubject('QUOTATION - #');
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