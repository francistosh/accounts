<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
    $us=$_SESSION['jname'];
    $level=$_SESSION['jmsacc'];
    $userid = $_SESSION['acctusrid'];
    $id=$_SESSION['dept_id'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
    require_once './operations/Mumin.php';

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
    
<title>Reconciliation Reprint</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
?>

<style type="text/css">
<!--
#totaldep{
    width:900px;
    font-size:11px;
	margin-right:auto;
	margin-left:auto;
}
.font{font-size:14px;}
#totaldep td {height: 20px;}
@media print
{ 
#printNot {display:none}
}
-->
</style>
<script>
$(function() {
    $("#prntbldgr").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-print"
            },
            text: true
             
});
   $("#closebldgr").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-close"
            },
            text: true
             
});
});
</script>
</head>
    <body style="background:#FFF; overflow-x: visible!important;" >
           <div align="center" id="printNot">
<button id ="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php 
 $edate2=trim($_GET['brend']);
          $edate11 = date('Y-m-d', strtotime($edate2));
          $bnktid =trim($_GET['bnktid']);
       $bankqry=$mumin->getdbContent("SELECT acname,acno FROM bankaccounts WHERE bacc = '$bnktid'");  
       $qr0=$mumin->getdbContent("SELECT * FROM bankrecon WHERE bacc = '$bnktid' AND recondate = '$edate11'");
       $cashbookbal = $qr0[0]['bnkclsbal'];
       $reconuser = $qr0[0]['user'];
       $daterecondone = $qr0[0]['ts'];
       $reconnumber = $qr0[0]['reconid'];
   echo '<div id="printableArea" >';
echo '<div class="container">';
echo '<table border="0">';   
echo '<tr>';
echo '<td><img id="logo" src="images/gold.png"></td>';
echo '<td> <p> <i><font style="font-size:30px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p><font style="font-size:10px;">'.$_SESSION['details'].'</font>';
echo '</td>';
echo '</tr> ';
echo '</table>';
echo '<br><br><div align="center"><font size="8"><b>Bank Reconciliation</font></b> </div>';
echo '<br><hr />';
echo '<div><table id="report">';
echo '<tr><td class="font" style="text-align:center;">&nbsp; Account Name:  <b>'.$bankqry[0]['acname'].'</b></td></tr>';
echo '<tr><td class="font">&nbsp; Bank Reconciliation as at:&nbsp; &nbsp;<b>'.$edate2.'</b> </td></tr>'; 
echo '</table></div>';
echo '<hr />';
?>
<table class="table" id="totaldep" > 
     <?php
      $qeury = $mumin->getdbContent("SELECT DATE_FORMAT('$edate11','%Y-%m-01') as recondate FROM bankrecon WHERE  bacc = '$bnktid' AND recondate = '$edate11' ");
         //$tomorrow = date('m-d-Y',strtotime($date1 . "+1 days"));
     $qtery = "SELECT sum(bbfamt) as brfamnt,tno FROM (SELECT sum(amount) as bbfamt,tno FROM recptrans WHERE bacc=$bnktid AND est_id = '$id' AND date(depots) < '".$qeury[0]['recondate']."' UNION
                                                       SELECT sum(amount) as bbfamt,jid FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate < '".$qeury[0]['recondate']."'  and estate_id ='$id')t7 WHERE bankacct = $bnktid UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt,tno FROM paytrans WHERE bacc='$bnktid' AND estId = '$id' AND pdate < '".$qeury[0]['recondate']."' UNION
                                                       SELECT sum(amount) as bbfamt,tno FROM (SELECT IF(crdtacc= '$bnktid' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$bnktid' or dbtacc = '$bnktid') AND  estId = '$id' AND jdate < '".$qeury[0]['recondate']."')T1) t6 ";
           
     $balanceldgr=$mumin->getdbContent($qtery);                                                                                                                                                        
           $balbbf = $balanceldgr[0]['brfamnt'];
           $balncebbf = number_format($balbbf,2);
     
     ?>
<br><br><br><tr><td style="width:400px;font-weight:bold"> Opening Cashbook Balance</td><td style="text-align: right;font-weight:bold"><?php echo $balncebbf; ?></td></tr>
<?php
$totaldbt = 0; $totalcrdt = 0;
       
          $qry = "SELECT * FROM (SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,sum(-1*amount),'')as creditamt,IF(amount>0,sum(amount),'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,depots as ts FROM recptrans WHERE date(depots) BETWEEN '".$qeury[0]['recondate']."' AND '$edate11' AND bacc = $bnktid  AND est_id LIKE '$id' AND pmode = 'CASH' GROUP BY isdeposited UNION
                  SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,-1*amount,'')as creditamt,IF(amount>0,amount,'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,depots as ts FROM recptrans WHERE date(depots) BETWEEN '".$qeury[0]['recondate']."' AND '$edate11' AND bacc = $bnktid  AND est_id LIKE '$id' AND pmode = 'CHEQUE' UNION
                  SELECT pdate as date,payno as docno,rmks,IF(amount>0,amount,'')as creditamt,IF(amount<0,-1*amount,'')as debitamt,'Payment V.' as doctype,IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,ts FROM paytrans WHERE pdate BETWEEN '".$qeury[0]['recondate']."' AND '$edate11' AND estId = '$id' AND bacc='$bnktid' UNION
                  SELECT jdate as date,jvno as docno,rmks,IF(crdtacc='".$bnktid."' AND cbacc = '1' ,amount,'')as creditamt,IF(dbtacc='".$bnktid."' AND dbacc = '1',amount,'')as debitamt,'Journal Voucher' as doctype, rmks AS pmode,ts FROM jentry where jdate  BETWEEN '".$qeury[0]['recondate']."' AND '$edate11' AND estId = '$id' AND (dbtacc = '$bnktid' or crdtacc = '$bnktid') UNION
                  SELECT date,docno,rmks,creditamt,debitamt,doctype,pmode,ts FROM (SELECT dexpdate as date,dexpno docno,rmks,IF(cacc='$bnktid' ,amount,'')as creditamt, IF(dacc='$bnktid',amount,'')as debitamt,'Direct Expense' as doctype,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate BETWEEN  '".$qeury[0]['recondate']."' and '$edate11'  and estate_id ='$id')t7 WHERE bankacct = '$bnktid')t5 order by date,ts";
              
        
          $bankledgerdet=$mumin->getdbContent($qry);
for($r=0;$r<count($bankledgerdet);$r++){
    $totaldbt = $totaldbt + $bankledgerdet[$r]['debitamt'];
                    $totalcrdt = $totalcrdt + $bankledgerdet[$r]['creditamt'];
}
        $cashbkclsingbal = $balbbf +$totaldbt-$totalcrdt;
?>
 <tr><td><b>Receipts</b></td><td style="text-align: right;font-weight:bold"><?php echo number_format($totaldbt,2); ?></td></tr>
<tr><td><b>Payments</b></td><td style="text-align: right;font-weight:bold"><?php echo number_format($totalcrdt,2); ?></td></tr>
 <tr><td><b>Cash Book Closing Balance</b></td><td style="text-align: right;font-weight:bold"><b><?php echo number_format($cashbkclsingbal,2);  ?></b></td></tr>
 <tr><td colspan="4">&nbsp;</td></tr>
 

  <table class="table table-condensed" id="totaldep">
       <div class="pagebreak"></div>
<thead><tr><th colspan="3" style="background-color: #ffd9ae !important; text-align: left;height: 20px">Uncleared Deposits</th></tr></thead>
    <tr style="font-weight: bold;"><td>Date</td><td>Narration</td><td class="right">Amount</td></tr>
<?php
 $unclrdepositamnt = 0;
      
             
  
                   $qrlw = "SELECT * FROM (SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'recp' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans WHERE rdate <= '$edate11' AND est_id LIKE '$id' AND recon > '$reconnumber' AND bacc = $bnktid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'recp' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans WHERE rdate <= '$edate11' AND est_id LIKE '$id' AND recon = '0' AND bacc = $bnktid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,sum(amount),'Deposit No' as doctype,'depo' as doc,isdeposited, pmode FROM recptrans WHERE rdate <= '$edate11' AND est_id LIKE '$id' AND recon > '$reconnumber' AND bacc = $bnktid AND pmode = 'CASH' GROUP BY isdeposited UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,sum(amount),'Deposit No' as doctype,'depo' as doc,isdeposited, pmode FROM recptrans WHERE rdate <= '$edate11' AND est_id LIKE '$id' AND recon = '0' AND bacc = $bnktid AND pmode = 'CASH' GROUP BY isdeposited UNION
                       SELECT jdate as date,jvno as docno,IF(dbtacc='$bnktid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc,jvno, rmks AS pmode FROM jentry where jdate  <= '$edate11' AND estId = '$id' AND (dbtacc = '$bnktid') AND recon = '0' UNION     
                        SELECT jdate as date,jvno as docno,IF(dbtacc='$bnktid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc,jvno, rmks AS pmode FROM jentry where jdate  <= '$edate11' AND estId = '$id' AND (dbtacc = '$bnktid') AND recon > '$reconnumber' ORDER BY rdate,pmode,isdeposited) t7 order by rdate,pmode,isdeposited";
                         //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $data46=$mumin->getdbContent($qrlw);
              for($i=0;$i<=count($data46)-1;$i++){
          echo '<tr><td>&nbsp;&nbsp;'.date('d-m-Y', strtotime($data46[$i]['rdate'])).'</td><td>&nbsp;&nbsp;'.$data46[$i]['doctype'].':&nbsp;'.$data46[$i]['isdeposited'].' - '.$data46[$i]['pmode'].'</td><td style="text-align: right;">'.number_format($data46[$i]['amount'],2).'</td></tr>';
            $unclrdepositamnt = $unclrdepositamnt  + $data46[$i]['amount'];
          }
          echo '<tr><td colspan="5" style="border-bottom: #000 solid 1px; height: 5px"></td></tr>';   
          echo '<tr><td></td><td>Uncleared Deposits</td><td style="text-align: right;height:20px"><b>'.number_format($unclrdepositamnt,2).'</b></td></tr>';
          
?>
<tr><td colspan="7" style="border-top: #000 solid 1px; border-bottom: #000 solid 1px; height: 5px"></td></tr>     
  </table> 
    <table class="table table-condensed" id="totaldep" >
        <thead><tr><th colspan="5" style="background-color: #ffd9ae !important; text-align: left;height: 20px">Uncleared Payments</th></tr></thead>
   <tr style="font-weight: bold;"><th>Date</td><th>Narration</td><th class="right">Amount</td></tr>
<?php
 $unclrwthdrwlamnt = 0;
         
             
            //$qrlz="SELECT pdate,payno,amount,IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM estate_paytrans WHERE payno = '$withdocnotrecon[$i]' AND estId LIKE '$est_id' AND bacc = '$bnkacctid' order by pdate ";
            $qrlz="SELECT * FROM (SELECT pdate,payno,amount,'Payment V. No' as doctype ,'pv' as doc, IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE pdate <= '$edate11' AND estId LIKE '$id' AND bacc = $bnktid AND recon > '$reconnumber' UNION
                 SELECT pdate,payno,amount,'Payment V. No' as doctype ,'pv' as doc, IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE pdate <= '$edate11' AND estId LIKE '$id' AND bacc = $bnktid AND recon = '0' UNION
                   SELECT jdate as date,jvno as docno,IF(crdtacc='".$bnktid."' AND cbacc = '1' ,amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode FROM jentry where jdate <= '$edate11'  AND estId = '$id' AND (crdtacc = '$bnktid') AND crdtaccrecon > '$reconnumber' UNION
                  SELECT jdate as date,jvno as docno,IF(crdtacc='".$bnktid."' AND cbacc = '1' ,amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode FROM jentry where jdate <= '$edate11'  AND estId = '$id' AND (crdtacc = '$bnktid') AND crdtaccrecon = '0' UNION
                SELECT date,docno,amount,doctype,doc,pmode FROM (SELECT dexpdate as date,dexpno as docno,IF(cacc='$bnktid' ,amount,amount*-1)as amount,'Direct Expense' as doctype ,'de' as doc,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate <= '$edate11'  and estate_id ='$id' AND recon = '0')t7 WHERE bankacct = '$bnktid'  UNION
                SELECT date,docno,amount,doctype,doc,pmode FROM (SELECT dexpdate as date,dexpno as docno,IF(cacc='$bnktid' ,amount,amount*-1)as amount,'Direct Expense' as doctype ,'de' as doc,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate <= '$edate11'  and estate_id ='$id' AND recon > '$reconnumber')t7 WHERE bankacct = '$bnktid' ORDER by pdate,payno)t9 ";


                                       //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $dat=$mumin->getdbContent($qrlz);
           for($t=0;$t<=count($dat)-1;$t++){
          echo '<tr><td >&nbsp;&nbsp;'.date('d-m-Y', strtotime($dat[$t]['pdate'])).'</td><td>&nbsp;&nbsp;'.$dat[$t]['doctype'].':&nbsp;'.$dat[$t]['payno'].' - '.$dat[$t]['pmode'].'</td><td style="text-align: right;">'.number_format($dat[$t]['amount'],2).'</td></tr>';
            $unclrwthdrwlamnt = $unclrwthdrwlamnt  + $dat[$t]['amount'];
          }
          echo '<tr><td colspan="3" style="border-bottom: #000 solid 1px; height: 5px"></td></tr>';
          echo '<tr><td colspan="2">Uncleared Payments</td><td style="text-align: right;padding-right:10px;height:20px"><b>'.number_format($unclrwthdrwlamnt,2).'</b></td></tr>';
          
?>
      <tr><td colspan="7" style="border-top: #000 solid 1px; border-bottom: #000 solid 1px; height: 5px"></td></tr>  
  </table>
 <tr><td>&nbsp;</td></tr>
 <table class="table table-condensed" id="totaldep" > 
     <?php
     $balanceaspercashbk = $cashbkclsingbal - $unclrdepositamnt + $unclrwthdrwlamnt;
     ?>
 <tr style="font-weight: bold;"><td style="width:400px;" >Balance as per Cashbook</td><td style="width:3px"></td><td style="text-align: right"><?php echo number_format($balanceaspercashbk,2); ?></td></tr>
<tr style="font-weight: bold;"><td >Balance as per Bank Statement</td><td style="width:3px"></td><td style="text-align: right"><?php echo number_format($cashbookbal,2); ?></td></tr>
<tr style="font-weight: bold;"><td >Difference</td><td style="width:3px"></td><td style="text-align: right"><?php $diff = floatval($balanceaspercashbk) - floatval($cashbookbal); echo number_format(round($diff,2),2); ?></td></tr>
<tr><td style="font-size: 11px;text-align: left" colspan="5"><br><span style="float: left"><?php echo "Recon done by&nbsp;".$reconuser."&nbsp;on&nbsp;".date('d-m-Y H:i:s', strtotime($daterecondone)); ?></span><span style="float: right"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;on&nbsp;".date('d-m-Y H:i:s'); ?></span></br> </td></tr> 
   
     </table>
</div>
</body>
</html>