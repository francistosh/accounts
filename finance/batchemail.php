<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
$level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';
date_default_timezone_set('Africa/Nairobi');
$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
$getuseremail = $mumin->getdbContent("SELECT email FROM pword WHERE userid = '$userid'");
$sendviathsmail = $getuseremail[0]['email'];
if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
}
}
require_once('./Swift-5.1.0/lib/swift_required.php');
require_once('./Swift-5.1.0/lib/swift_init.php');  
require_once('./tcpdf/config/tcpdf_config.php');
require_once('./tcpdf/tcpdf.php');
$rootpath = "jimsaccounts";
$sendmail="TRUE";
$fromaddress=$sendviathsmail;
$estId=$id;
if (isset($_POST['batchmailsabno'])) {
    $from_date = $_POST['batchmailfrmdate'];
    $frdate = date('Y-m-d',  strtotime($_POST['batchmailfrmdate']));
    $to_date = $_POST['batchmailtodate'];
    $todate = date('Y-m-d',  strtotime($_POST['batchmailtodate']));

    $user = $_SESSION['jname'];
    $sabil = $_POST['batchmailsabno'];
    $account =  $_POST['batchmailincmeacc'];
   $transport = Swift_SmtpTransport::newInstance('mail.techsavanna.technology', 465,'ssl')
 ->setUsername('francis@techsavanna.technology')
 ->setPassword('Qwerty789#');

          $message = Swift_Message::newInstance();
          $mailer = Swift_Mailer::newInstance($transport);
         $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100, 30));
// retreiving each posted accno in the array

    //foreach ($acnos as $key => $val) {

       
        for($s=0;$s<=count($sabil)-1;$s++){
             $rand = rand(100, 1000000);
        //send email function

        $pdf = getPdfSettings();

// create tmp stmt table
//$query = "DELETE FROM statmtmp";
        $tbno = rand();
        $ej=$mumin->get_MuminHofEjnoFromSabilno($sabil[$s]);
        
        $muminSector=$mumin->getdbContent("SELECT sector, moh, email, hseno FROM mumin WHERE ejno LIKE '$ej'");
        $statementRecevee=$mumin->get_MuminHofNamesFromSabilno($sabil[$s])."<br/>Mohalla :".$muminSector[0]['moh'];
        $email= 'frankmutura@gmail.com';
		$hseno= $muminSector[0]['hseno'];
        $display = "display: block";
        @$msector= $muminSector[0]['sector']; $debtelno ='';
        //$toStatement= $start."&nbsp;TO&nbsp;".$end."<br/>Sabil No :<font style='text-transform:uppercase'>".$sabil."</font><br/>HOF Ejamaat No :".$mumin->get_MuminHofEjnoFromSabilno($sabil); 
        if($account== 'all'){
        $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.estId LIKE '$estId' AND sabilno = '$sabil[$s]' 
               UNION SELECT  bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptid = '$estId' AND acc = '$sabil[$s]' AND tbl = 'M' GROUP BY incacc ";
        }else{
          $qryies = "SELECT invoice.incacc as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND invoice.incacc = '$account' AND invoice.estId LIKE '$estId' AND sabilno = '$sabil[$s]'
               UNION SELECT  bad_debtsmbrs.incacc , accname FROM bad_debtsmbrs,incomeaccounts WHERE bad_debtsmbrs.incacc = incomeaccounts.incacc AND deptid = '$estId' AND acc = '$sabil[$s]' AND bad_debtsmbrs.incacc = '$account' AND tbl = 'M'   GROUP BY incacc ";  
        }
        
    
     
     
        
       $indata = $mumin->getdbContent($qryies);
        
      $disp = 'none';
 $mydata = '
     <table><tr><td><p><b><i> Anjuman-e-Burhani</i></b> </p> <span style="font-size:10px">'.$_SESSION['details'].'</span> </td>
         <td><span style="float:right;font-size: 8px;"><b>'.$_SESSION['dptname'].'</b></span><img src="../assets/images/gold new logo.jpg" style="float:right" height="80" width="80" /></td></tr> 
</table>
<div align="right"><b>Statement</b> </div>
<hr />
<div>

<table style="font-size:12px;padding:10px;">
<tr><td>Account Name: &nbsp; <b>'.$statementRecevee.' </b>&nbsp;&nbsp;&nbsp; Tel No : '.$debtelno.'</td></tr>
<tr><td style="'.$display.'">Sabil No: &nbsp; '.strtoupper($sabil[$s]).'&nbsp;&nbsp; House No.&nbsp;'.ucfirst($hseno).'</td><td style="text-align:Center">  </td></tr>
<tr><td style="text-align: right">From:&nbsp; <b>'.$from_date.'</b>&nbsp; to &nbsp;<b>'.$to_date.'</b></td></tr>
</table></div>
<table style="font-size:12px;" cellpadding="5" border="0.5" >
<thead><tr><th> <b>Date</b></th><th><b>Narration</b></th><th align="center"><b>Debit</b></th> <th align="center"><b>Credit</b></th> <th align="center"><b>Balance</b></th></tr></thead>
';
       
                $dbtotal = 0;  $crdtotal = 0; $balancebbf = 0; $balnce=0;
         for($k=0;$k<=count($indata)-1;$k++){
                 $incmesum = 0;
                  
          $mydata.= '<tr><th colspan="5" ><b>'.$indata[$k]['accname'].'</b></th></tr>';
           //opening balance-b/bf
           if($todate > '2016-12-31' ){ //opening balance-b/bf
           $qry56= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE sabilno LIKE '$sabil[$s]' AND estId LIKE '$estId'  AND incacc = '".$indata[$k]['incacc']."' AND opb = '1'  ) t1");
            $result36=$qry56[0]['bbfamnt'];
            }else{
                $result36 = '0';
            }
            //balance-b/bf
           $qry3= "SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE sabilno LIKE '$sabil[$s]' AND estId LIKE '$estId'  AND idate < '$frdate' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
               SELECT (SUM(amount))*-1 as amount,tno  FROM recptrans WHERE sabilno LIKE '$sabil[$s]' AND est_id LIKE '$estId' AND rdate < '$frdate' AND incacc = '".$indata[$k]['incacc']."'  UNION
               SELECT (sum(dramount) - sum(cramount)) as amount,tno FROM bad_debtsmbrs WHERE acc = '$sabil[$s]' AND deptid = '$estId' AND jdate < '$frdate' AND incacc = '".$indata[$k]['incacc']."' and tbl = 'M' ) t1";
            $result3=$mumin->getdbContent($qry3);
           
           // $amountdr=intval($amountpaid[0]['amountpaid'])+intval($debitjvs1[0]['dr']);
            
          //  $amountcr=intval($amountpayable[0]['amountpayable'])+intval($creditjvs1[0]['cr']);
            
           $balance_bf=$result3[0]['bbfamnt']+ $result36;
           $origbbf = $result3[0]['bbfamnt'];
        $qr="SELECT idate as date,invno as docno,incacc,rmks,ts,IF(isinvce='1',amount,'')as debitamt,IF(isinvce='0',amount,'')as creditamt,if(isinvce='1','Invoice','Credit Note') as doctype , ' ' as pmode, subacc FROM invoice WHERE sabilno LIKE '$sabil[$s]' AND estId LIKE '$estId' AND idate BETWEEN '$frdate' AND '$todate' AND incacc = '".$indata[$k]['incacc']."' AND opb = '0' UNION 
            SELECT rdate as date,recpno as docno,'0' as incacc,rmks,ts,IF(amount<0,-1*amount,'')as debitamt,IF(amount>0,amount,'')as creditamt,if(tno>0,'Receipt','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,'' as subacc FROM recptrans WHERE rdate BETWEEN '$frdate' AND '$todate' AND sabilno LIKE '$sabil[$s]' AND est_id LIKE '$estId' AND incacc = '".$indata[$k]['incacc']."' UNION 
             SELECT jdate as date, jno as docno,incacc,rmks,ts,if(dramount <> '0.00',dramount,'') as debitamt,if(cramount <> '0.00',cramount, '') as creditamt,'Journal Entry' as doctype,' ' as pmode,'' as subacc  FROM bad_debtsmbrs WHERE acc = '$sabil[$s]' AND deptid = '$estId' AND jdate BETWEEN '$frdate' AND '$todate' AND  incacc = '".$indata[$k]['incacc']."' AND tbl = 'M'  ORDER BY date,ts ASC ";
                 $q=$mumin->getdbContent($qr);    
       
       //$q=$mumin->getdbContent("SELECT * FROM $tbname ORDER BY docdate ASC");style=";
                   
                   $drbal=0;
                   
                   $crbal=0;
                   if($result36 != 0 && $origbbf == 0 || $frdate < '2017-01-01' ){
                       $mydata.= '<tr><td colspan="4" align="center"><b>Opening Bal</b></td><td align="right">'.number_format($balance_bf,2).'</td></tr>';  
                   }else{
                       $mydata.= '<tr><td colspan="4" align="center"><b>B/F</b></td><td align="right">'.number_format($balance_bf,2).'</td></tr>'; 
                   }
                  for($l=0;$l<=count($q)-1;$l++){
                  
                      
                           $doctype=$q[$l]['doctype'];
                           
                            
                           
                           if($q[$l]['creditamt']){
                             
                               $balance_bf-=$q[$l]['creditamt'];
                               $crbal+=$q[$l]['creditamt'];
                               $creditamt = number_format($q[$l]['creditamt'],2);
                               $debitamt ='';
                               
                           }
                           else if($q[$l]['debitamt']){
                               
                               $balance_bf+=$q[$l]['debitamt'];
                               $drbal+=$q[$l]['debitamt'];
                               $debitamt = number_format($q[$l]['debitamt'],2);
                               $creditamt='';
                           }else{
                               $creditamt = number_format(0,2);
                                $debitamt = number_format(0,2);
                           }
                           if($q[$l]['incacc']!=='0'){
                               $qer="SELECT accname FROM incomeaccounts WHERE incacc='".$q[$l]['incacc']."'"; 
                                     $dat=$mumin->getdbContent($qer);
                                     $accnmed = $dat[0]['accname'];
                                     if($accnmed == 'Sabil Account'){
                               $ty=$mumin->getdbContent("SELECT accname FROM subincomeaccs WHERE id='".$q[$l]['subacc']."'"); 
                                      if(count($ty)>0){
                                          $accnme =   $ty[0]['accname'];
                                      }else{
                                          $accnme =  $accnmed;
                                      }
                               
                                     }else {
                                        $accnme =  $accnmed;
                                     }
                           }
                           else{
                               $accnme = "";
                           }
                           //&nbsp:&nbsp;&nbsp;".$q[$l]['pmode']."
                           //$start = date('Y-m-d', strtotime($start1));
                           $mydata.='<tr><td>'.date('d-m-Y', strtotime($q[$l]['date'])).'</td><td>'.$doctype.' No : '.$q[$l]['docno'].' -'.$accnme.'  '.$q[$l]['pmode'].'</td><td align="right">'.$debitamt.'</td><td align="right">'.$creditamt.'</td><td align="right">'.number_format($balance_bf,2).'</td></tr>';
                      
                  }
              $mydata.='<tr><td></td><td style="text-align: center"><b>'.$indata[$k]['accname'].' Balance</b></td><td align="right"><b>'.number_format($drbal,2).'</b></td><td align="right"><b>'.number_format($crbal,2).'</b></td><td align="right"><b>'.number_format($balance_bf,2).'</b></td></tr>';
              $dbtotal = $dbtotal +$drbal;
              $crdtotal = $crdtotal + $crbal;
              $balancebbf = $balancebbf + $balance_bf;
              $balnce = $balancebbf;
              $accountname = $indata[$k]['accname'];
         }
 //$empty_temp=$mumin->updatedbContent("DROP TABLE $tbname"); //delete contents  of temp table  in readness for next  operation
$mydata.='<tr><td colspan="7"><br></td></tr>';
$mydata.='<tr><td></td><td><b>Totals</b></td><td align="right"><b>'.number_format($dbtotal,2).'</b></td><td align="right"><b>'.number_format($crdtotal,2).'</b></td><td align="right"><b>'.number_format($balnce,2).'</b></td></tr>';
 $mydata.=' <tfoot>
         <tr><td style="border-top: 3px solid #000" colspan="7"><h7>Please check your balance and bring any discrepancies within 15 days</h7>
         <span align="left" style="font-size:x-small;"><br>Printed by: '.$_SESSION['jname'].'   '.date("d-m-Y H:i:s"). '</span></td> </tr></tfoot></table><br />';

?>
          
     <?php
     

        //}
   
// -----------------------------------------------------------------------------

        $pdf->AddPage("L");
        $pdf->SetFont('helvetica', '', 10);
        $tbl = <<<EOD
        
   $mydata
        
EOD;



        $pdf->writeHTML($tbl, true, false, false, false, '');
        echo "Processing transaction...".$sabil[$s]."<br>";
        $pdf->SetProtection(array(), $sabil[$s], null, 0, null);


// -----------------------------------------------------------------------------
//Close and output PDF document or email
        if (strtolower($sendmail) == "true") {
           //write to directory first
            
             $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $rootpath . "/pdfs/" . $rand . "ej" . $sabil[$s] . '.pdf', 'F');
             $url = "http://" . $_SERVER["HTTP_HOST"] . '/' . $rootpath . '/pdfs/' . $rand . "ej" . $sabil[$s] . ".pdf";
 echo "Writing ".$url."<br>";
           
 $message = Swift_Message::newInstance()
                ->setFrom($fromaddress)
                ->setTo($email)
         ->setBody("Dear Member,find attached ".$accountname."  statement from ".$from_date." to ".$to_date.". When Prompted for pasword enter your Sabil No in CAPS:")
                ->setSubject("".$accountname." Statement for $sabil[$s] For Period ".$from_date." to ".$to_date.' ');
                   $message->attach(
Swift_Attachment::fromPath($_SERVER['DOCUMENT_ROOT'].$rootpath."/pdfs/".$rand."ej" .$sabil[$s] .".pdf")->setFilename($rand . "ej" . $sabil[$s] . ".pdf"));    

     
        if($mailer->send($message)){
            echo "Successfully sent email";
        } else{
                 echo "Could not send email";
        }
        } else {

            $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $rootpath . "/pdfs/" . $rand . "ej" . $sabil[$s] . '.pdf', 'F');

            $url = "http://" . $_SERVER["HTTP_HOST"] . '/' . $rootpath . '/pdfs/' . $rand . "ej" . $sabil[$s] . ".pdf";

            echo $url;
        }
}} else {
    die("Missing parameters:Ac/No");
}

function getPdfSettings() {



// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // always load alternative config file for examples
// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Audit MQHT');
    $pdf->SetTitle('Report');
    $pdf->SetSubject('Custom Report');
    $pdf->SetKeywords('TCPDF, PDF, report, test, guide');
    $pdf->setPrintHeader(FALSE);
    
    
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO,"", PDF_HEADER_TITLE.': REPORT #'.$rand, "");
// set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, "", PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->setPageOrientation('P');
    return $pdf;
}


