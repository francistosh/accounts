<?php 
ob_start();
session_start();
date_default_timezone_set('Africa/Nairobi');
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
   
include './operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
  if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
} 
    
    
    }
?>    
<html>  
    <head>  
        <style>  
        body {font-family:Helvetica, Arial, sans-serif; font-size:10pt;}  
        table {width:100%; border-collapse:collapse; }  
               </style>  
    </head>  
    <body>  
      <?php
        
        $param=$_GET['param'];
        $start1=$_GET['start'];
        $start = date('Y-m-d', strtotime($start1));
        $end1=$_GET['end'];
        $end = date('Y-m-d', strtotime($end1));
        $estId=$id;
        $account=$_GET['account'];
        $emailtext = $_GET['content'];
        if($param=="sabil"){
        $sabil=$_GET['sabil'];
        
        $ej=$mumin->get_MuminHofEjnoFromSabilno($sabil);
        
        $muminSector=$mumin->getdbContent("SELECT sector,moh,email FROM mumin WHERE ejno LIKE '$ej'");
        $statementRecevee=$mumin->get_MuminHofNamesFromSabilno($sabil)."<br/>Mohalla :&nbsp;&nbsp;".$muminSector[0]['moh'];
        $display = "display: block";
        $emailaddr = $muminSector[0]['email'];
        //$toStatement= $start."&nbsp;TO&nbsp;".$end."<br/>Sabil No :<font style='text-transform:uppercase'>".$sabil."</font><br/>HOF Ejamaat No :".$mumin->get_MuminHofEjnoFromSabilno($sabil); 
        }
        else{
            $debtor=trim($_GET['debtor']);
            $invrc=$mumin->getdbContent("SELECT * FROM debtors WHERE dno = '$debtor' LIMIT 1"); 
            $sabil = $invrc[0]['sabilno'];
            $statementRecevee=$invrc[0]['debtorname']."<br/>Email :&nbsp;&nbsp;".$invrc[0]['email'];
            $emailaddr=$invrc[0]['email'];
           
            if ($invrc[0]['sabilno']){
             $display = "display: block";
        }   else{
            $display = "display: none";
        }
        
        }?>
        <h1><font size="3"> Anjuman-e-Burhani </font><br>
            <span style="font-size:12px;">P.O. Box 81766-80100, Tel: 020-2040372, Mombasa, Kenya<br>
            Mobile: 0733846571, Email: reception@msajamaat.org</span>
        </h1>  
          <div align="center" style="font-size: 20px;">STATEMENT</div>
          <hr/>
          <div>
          <table>
              <tr>
                  <td colspan="2"> ACCOUNT NAME : <?php echo $statementRecevee;?> </td>
              </tr>
              <tr>
                  <td style="<?php echo $display;?>"> SABIL NO : <?php echo strtoupper($sabil);?> </td>
                  <td style="text-align:Center"><span></span>  </td>
              </tr>
              <tr><td>Statement From:&nbsp; <b><?php echo $start1; ?></b>&nbsp; to &nbsp;<b><?php echo $end1; ?></b></td></tr>
          </table> </div>
          <hr />
          <br />
        <table style="border-collapse: collapse;">  
            <thead><tr><th> Date</th> <th> Document No</th> <th>Payment Mode</th><th style='text-align: right;'>Debit</th> <th style="text-align: right;"> Credit</th> <th style="text-align: right;"> Balance</th></tr></thead>
            <tbody><tr><td colspan="6"><hr></td></tr>
            <?php
            if($param=="sabil"){
                //opening balance-b/bf
           $qry3= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount  FROM invoice WHERE sabilno LIKE '$sabil' AND estId LIKE '$estId'  AND idate < '$start' UNION 
               SELECT (SUM(amount))*-1 as amount  FROM recptrans WHERE sabilno LIKE '$sabil' AND est_id LIKE '$estId' AND rdate < '$start') t1";
            $result3=$mumin->getdbContent($qry3);
           
           // $amountdr=intval($amountpaid[0]['amountpaid'])+intval($debitjvs1[0]['dr']);
            
          //  $amountcr=intval($amountpayable[0]['amountpayable'])+intval($creditjvs1[0]['cr']);
            
           $balance_bf=$result3[0]['bbfamnt'];
           
        $qr="SELECT idate as date,invno as docno,rmks,IF(isinvce='1',amount,'')as debitamt,IF(isinvce='0',amount,'')as creditamt,if(isinvce='1','Invoice','Credit Note') as doctype , ' ' as pmode FROM invoice WHERE sabilno LIKE '$sabil' AND estId LIKE '$estId' AND idate BETWEEN '$start' AND '$end' UNION 
            SELECT rdate as date,recpno as docno,rmks,IF(amount<0,-1*amount,'')as debitamt,IF(amount>0,amount,'')as creditamt,if(tno>0,'Receipt','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode FROM recptrans WHERE rdate BETWEEN '$start' AND '$end' AND sabilno LIKE '$sabil' AND est_id LIKE '$estId' ORDER BY date";
                 
                $q=$mumin->getdbContent($qr);  
            } 
            else{  //debtor  processing
         
      //opening balance-b/bf
            $qr4= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount  FROM invoice WHERE dno = '$debtor' AND estId LIKE '$estId'  AND idate < '$start' UNION 
               SELECT (SUM(amount))*-1 as amount  FROM recptrans WHERE dno = '$debtor' AND est_id LIKE '$estId' AND rdate < '$start' ) t1";
            $result4=$mumin->getdbContent($qr4);           
            $balance_bf= $result4[0]['bbfamnt'];
   
      //show the breakdown from recptrans table and Invoice Table  
           
             $qr="SELECT idate as date,invno as docno,rmks,IF(isinvce='1',amount,'')as debitamt,IF(isinvce='0',amount,'')as creditamt,if(isinvce='1','Invoice','Credit Note') as doctype, ' ' as pmode FROM invoice WHERE dno = '$debtor' AND estId = '$estId' AND idate BETWEEN '$start' AND '$end'  UNION 
            SELECT rdate as date,recpno as docno,rmks,IF(amount<0,-1*amount,'')as debitamt,IF(amount>0,amount,'')as creditamt,if(tno>0,'Receipt','')as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode FROM recptrans WHERE rdate BETWEEN '$start' AND '$end' AND dno = '$debtor' AND est_id LIKE '$estId'  ORDER BY date";
                 $q=$mumin->getdbContent($qr);   
               
            }
            $drbal=0;
                   
                   $crbal=0;
               ?>    
                 <tr><td colspan='4' style='text-align:center;'><b>B/F</b></td><td></td><td style='text-align: right;'><b><?php echo number_format($balance_bf,2);?></b></td></tr>
            <?php
                                   for($l=0;$l<=count($q)-1;$l++){
                  
                      
                           $doctype=$q[$l]['doctype'];
                           
                            
                           
                           if($q[$l]['creditamt']){
                             
                               $balance_bf-=intval($q[$l]['creditamt']);
                               $crbal+=intval($q[$l]['creditamt']);
                               $creditamt = number_format($q[$l]['creditamt'],2);
                               $debitamt ='';
                               
                           }
                           else if($q[$l]['debitamt']){
                               
                               $balance_bf+=intval($q[$l]['debitamt']);
                               $drbal+=intval($q[$l]['debitamt']);
                               $debitamt = number_format($q[$l]['debitamt'],2);
                               $creditamt='';
                           }
                           ?>
                     <tr style='height:20px;font-size:12px'><td><?php echo date('d-m-Y', strtotime($q[$l]['date']));?></td>
                         <td ><?php echo $doctype; ?>&nbsp;&nbsp; No: &nbsp;&nbsp;<?php echo $q[$l]['docno'];?></td><td><?php echo $q[$l]['pmode'];?></td>
                         <td style='text-align: right;'><?php echo $debitamt; ?></td>
                         <td style='text-align: right;'><?php echo $creditamt;?></td>
                         <td style='text-align: right;'><?php echo number_format($balance_bf,2); ?></td></tr>
                      <?php
                  }
            
            ?>  
                 <tr><td colspan=6><hr /></td></tr> 
                 <tr><td><b>Totals</b></td><td></td><td></td><td style="text-align: right;"><b><?php echo number_format($drbal,2);?></b></td><td style="text-align: right;"><b><?php echo number_format($crbal,2); ?></b></td><td style="text-align: right;"><b><?php echo number_format($balance_bf,2) ?></b></td></tr>
                 <tr><td colspan=6><hr /> </td></tr>
        </tbody>
        <tfoot>
            <br/><br/>
         <tr><td colspan="6">
         </td> </tr></tfoot>
        </table>  
          <p></p>
        <p>Please check your balance and bring any discrepancies within 15 days</p>  
      
    </body>  
    </html> 
     <?php
 
        $sentfrom = 'it@msajamaat.org';
      //$dir = dirname(__FILE__);
      
      //estates/sabil_statement.php?param=sabil&sabil='+$sabil+'&start='+$startdate+'&end='+$enddate+'&account='+$stataccount+'',
      
      //include_once($dir.'/pdf.php?param='.$param.'&sabil='.$sabil.'&start='.$start.'&end='.$end.'&account='.$account.'') ;
      $pdf_html = ob_get_contents();  
        ob_end_clean(); 
        // Load the dompdf files  
        require_once('./dompdf/dompdf_config.inc.php');
        $dompdf = new DOMPDF(); // Create new instance of dompdf 
        $dompdf->load_html($pdf_html); // Load the html  
        $dompdf->render(); // Parse the html, convert to PDF
        $pdf_content = $dompdf->output(); // Put contents of pdf into variable for later  
 // Load the SwiftMailer files  
        require_once('./Swift-5.1.0/lib/swift_required.php');  
        //require_once('pdf.php');
        //$mailer = new Swift_Mailer(new Swift_MailTransport()); // Create new instance of SwiftMailer  
  $transport = Swift_SmtpTransport::newInstance('mail.msajamaat.org', 25)
 ->setUsername('support@msajamaat.org')
 ->setPassword('AB_support1');
  $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance()  
                       ->setSubject('ACCOUNT STATEMENT') // Message subject  
                       ->setTo(array($emailaddr)) // Array of people to send to  
                       ->setFrom(array($sentfrom => 'Mohalla Statement')) // From:  
                       ->setBody($emailtext) // Attach that HTML message from earlier  
                       ->attach(Swift_Attachment::newInstance($pdf_content, 'Anjumane_Statement.pdf', 'application/pdf')); // Attach the generated PDF from earlier  
          
        // Send the email, and show user message  
        //if ($mailer->send($message))  
       //     $success = true;  
       // else  
       //     $error = true;  
        $result = $mailer->send($message);
if ($result)
{
echo " Email Sent Successfully\n";
}
else
{
echo "Failed\n";
}  
        
  
 
 //}
 ?>