  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  include 'operations/Mumin.php';

$mumin=new Mumin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>JIMS 2 | Receipts</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" id="invcelstoxcel"><span><span><span class="cancel">Excel</span></span></span></button>
           </div>
<br />
<?php
        
  
          $sdate1=trim($_GET['sdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $edate1=trim($_GET['edate']);
          $edate = date('Y-m-d', strtotime($edate1));
          
          
          
          
          
          $numbering=1;
          
          $sum=0;
          $sum1=0;
                       
    
              $deptname="All";
   
    
      $disp = 'none';

            
          echo '<div id="printableArea">';

echo '<table width="100%"  border="0">';   
echo '<tr>';
echo '<td colspan="2"> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:10px">'.@$_SESSION['details'].'</span> </td>';
echo '</tr> ';
echo '</table>';
echo '<div align="right"><font size="3"><b>Banking Monies List From:&nbsp; <b>'.$sdate1.'</b>&nbsp; to &nbsp;<b>'.$edate1.'</font></b> </div>';

echo '<br />';

echo '<table id="treport" style="width:100%" cellpading=4 class="exporttable">';
echo '<thead><tr><th colspan="2" style="width:70px"> Date</th> <th colspan="2" style="width:70px">Recp. No.</th><th colspan="2">Name</th><th colspan="2" style="width:70px"> Sabil No</th><th colspan="2">Mode</th><th colspan="2">Chq No.</th><th>Chq date</th><th>Remarks</th><th style="text-align:right">Amount&nbsp;&nbsp;</th></tr></thead>';
//echo '<tbody><tr><td colspan="16"><hr></td></tr>';
           $qr="SELECT recptrans.incacc,accname FROM recptrans,incomeaccounts WHERE recptrans.incacc = incomeaccounts.incacc AND rdate  BETWEEN '$sdate' AND '$edate' GROUP BY accname";  

                $data=$mumin->getdbContent($qr);
                
                     for($i=0;$i<=count($data)-1;$i++){
              $dept1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '".$data[$i]['incacc']."'");
              $deptname=$dept1[0]['accname'];
            
              echo"<tr style='font-size:13px'><td colspan='15'><b>".$deptname."</b></td></tr>";
              $qrty=$mumin->getdbContent("SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND incacc = '".$data[$i]['incacc']."' AND amount > 0 AND pmode = 'CHEQUE' UNION
                       SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND incacc = '".$data[$i]['incacc']."'  AND pmode = 'CASH' ORDER BY rdate,pmode,recpno");
              $totalincme = 0;
              for($u=0;$u<=count($qrty)-1;$u++){
                                if($qrty[$u]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($qrty[$u]['hofej']);
                  
              }
              else{
                 
                  $debid=$qrty[$u]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' ");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              } 
                    if($qrty[$u]['chequedate'] == '0000-00-00'){
                        $showchdate = '';
                    }else{
                        $showchdate = date('d-m-Y',strtotime($qrty[$u]['chequedate']));
                    }
                   
                    echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($qrty[$u]['rdate']))."</td><td colspan='2'>".$qrty[$u]['recpno']."</td><td colspan='2'>".$payer."</td><td colspan='2'>".strtoupper($qrty[$u]['sabilno'])."</td><td colspan='2'>".$qrty[$u]['pmode']."</td><td colspan='2'>".$qrty[$u]['chqno']." - ".$qrty[$u]['chqdet']."</td><td>".$showchdate."</td><td>".$qrty[$u]['rmks']."</td><td style='text-align:right;padding-right:10px'>".  number_format($qrty[$u]['amount'],2)."</td></tr>";
              $totalincme = $totalincme + $qrty[$u]['amount'];
                  
              }
              echo"<tr style='text-align: right'><td colspan='14' style='font-size:14px'><b>$deptname Total:</b></td><td style='text-align:right;padding-right:10px'><b>".number_format($totalincme,2)."</b></td></tr>";
              $sum = $sum+$totalincme;
              
                    }
              
       echo "<td colspan=16></td>";
 
echo'<tr><td colspan=10></td><td colspan=4><b>GRAND TOTALS</b></td><td style="text-align:right;padding-right:10px"><b>'. number_format($sum,2).'</b></td></tr>';
echo '<tr><td colspan=16></td></tr>';
echo'</tbody></table>';
echo '<table  class="exporttable" id="lists" style="width:450px;margin-left: auto;margin-right:auto">';
echo '<thead><tr><br /><td colspan=4 style="text-align:center"> SUMMARY FROM '.$sdate1.'&nbsp; TO &nbsp;'.$edate1.' </td></tr>';
echo '<tr><th>Account</th><th style="text-align:center">Cash</th><th style="text-align:center">Cheque</th><th style="text-align:center">Total</th></tr></thead>';
$cashamnt = 0; $chqamnt = 0;
for($t=0;$t<=count($data)-1;$t++){
              $dep1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '".$data[$t]['incacc']."'");
              $deptnme=$dep1[0]['accname'];
            $qrp=$mumin->getdbContent("SELECT sum(amount) AS amount FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND incacc = '".$data[$t]['incacc']."' AND pmode = 'CASH'");
            $qrc=$mumin->getdbContent("SELECT sum(amount) AS amount FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND incacc = '".$data[$t]['incacc']."' AND amount > 0 AND pmode = 'CHEQUE'");
echo"<tr style='font-size:13px'><td><b>".$deptnme."</b></td><td class='right'>".number_format($qrp[0]['amount'],2)."</td><td class='right'>".number_format($qrc[0]['amount'],2)."</td><td class='right'>".number_format($qrc[0]['amount']+$qrp[0]['amount'],2)."</td></tr>";
$cashamnt = $cashamnt +$qrp[0]['amount'];
$chqamnt = $chqamnt + $qrc[0]['amount'];
}

echo '<tr><td colspan=4></td></tr>';
echo"<tr style='font-size:13px'><td><b>Total</b></td><td class='right'>".number_format($cashamnt,2)."</td><td class='right'>".number_format($chqamnt,2)."</td><td class='right'>".number_format($chqamnt+$cashamnt,2)."</td></tr>";
echo'</table><br />';




echo '<span style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
         
         
          
         
         
         
         
         
         
         
  echo"</table>";
          
?>
    </body>
</html>
<?php }?>