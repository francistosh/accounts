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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Reconciliation</title> 
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
    margin-left: auto;
    margin-right: auto;
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
    $.modaldialog.prompt('<b><br></br>Bank Reconciliation Successful</b>', {
             timeout: 4,
             width:500,
             showClose: true,
             title:"SUCCESS"
            });
    
    
});
</script>
</head>
    <body style="background:#FFF; overflow-x: visible!important;" >
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closepg" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php
          $docnumbers=  explode(",",$_GET['docunumbers']);
          $doctypsclrd=  explode(",",$_GET['doctypsclrd']);
          $recpnotrecon=  explode(",",$_GET['recpnotrecon']);
          $withdocnotrecon=  explode(",",$_GET['withdocnotrecon']);
           $doctypesnotclrd=  explode(",",$_GET['doctypesnotclrd']);
         $withdrwalrecon=  explode(",",$_GET['withdrwalrecon']);
          $clrdwitdrawaldoc=  explode(",",$_GET['clrdwitdrawaldoc']);
          $notclrdwitdrawaldoc=  explode(",",$_GET['notclrdwitdrawaldoc']);
         $cashbkbal = trim($_GET['cashbkbal']);
          $cashbkbal2 = trim($_GET['cashbkbal2']);
         isset($_GET['incmejv']) ? $incmejv = trim($_GET['incmejv']) : $incmejv = 0; //if reconcilliation done via pop up screen
         isset($_GET['directexp']) ? $directexp = trim($_GET['directexp']) : $directexp = 0;
         $clsingbalance = trim($_GET['clsingbalance']);
          $bnkacctid =trim($_GET['bnkacctid']);
          $reconcidate1 = trim($_GET['reconcidate']);
          $reconcidate = date('Y-m-d', strtotime($reconcidate1));
          $diffrnce =trim($_GET['diffrnce']);
          $oppenblnce2 =trim($_GET['oppenblnce2']);
          $est_id=$_SESSION['dept_id'];
          $ts=date('Y-m-d h:i:s');
          
        $bankqry="SELECT acname FROM bankaccounts WHERE bacc = '$bnkacctid'";       
            $databank=$mumin->getdbContent($bankqry);  

      $disp = 'none';
 
            $recono=intval($mumin->refnos("recon"));
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
echo '<tr><td class="font"style="text-align:center;">&nbsp; Account Name:  <b>'.$databank[0]['acname'].'</b></td></tr>';
echo '<tr><td class="font">&nbsp; Bank Reconciliation as at:&nbsp; &nbsp;<b>'.$reconcidate1.'</b> </td></tr>'; 
echo '</table></div>
    <hr/>';
     ?>
   <!--<table id="totaldep"> 
      <!-- remove begining balance
      <tr style="font-weight: bold;"><td style="width:400px" colspan="2">Beginning Balance</td><td style="width:3px"></td><td ></td><td style="text-align: right;width: 200px;padding-right:10px"><?php echo number_format($oppenblnce2,2); ?></td></tr>    
     </table>-->
      <!--
          <table id="totaldep" >
      
<thead><tr><th colspan="7" style="background-color: #00AA88;text-align: left;height:20px">Deposits Cleared</th></tr></thead>
    <tr style="font-weight: bold;"><td style="width:100px">Date</td><td style="width:3px"></td><td style="width:400px">Narration</td><td style="width:3px"></td><td style="width:100px">Amount</td><td></td></tr>
<?php
 $dpamount = 0;
 //if reconcilliation done via pop up screen

            if($incmejv != 0){
         $b=$mumin->getdbContent("SELECT jdate as date,jvno as docno,rmks,amount,'Journal Voucher' as doctype, rmks AS pmode,ts FROM jentry WHERE estId = '$est_id' AND (dbtacc = '$bnkacctid' or crdtacc = '$bnkacctid') AND jvno = '$incmejv'");       
             }
            
             
         for($i=0;$i<=count($docnumbers)-2;$i++){
          
            //$qrry4="SELECT rdate,recpno,amount,IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM estates_recptrans WHERE recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id'  AND bacc = '$bnkacctid' ORDER BY rdate";
            $qrry4 = "SELECT * FROM (SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'recp' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'uncleared' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans_temp WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,sum(amount),'Deposit No' as doctype,'depo' as doc,isdeposited, pmode FROM recptrans WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CASH' GROUP BY isdeposited UNION
                        SELECT jdate as date,jvno as docno,IF(dbtacc='$bnkacctid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc,jvno, rmks AS pmode FROM jentry where jdate  <= '$reconcidate' AND estId = '$est_id' AND (dbtacc = '$bnkacctid') AND recon = '0' ORDER BY rdate) t7 WHERE recpno = '$docnumbers[$i]' and  doc = '$doctypsclrd[$i]'";
                if($doctypsclrd[$i]== 'depo' ){
            $qrry42 ="UPDATE recptrans SET recon = '$recono' WHERE isdeposited = '$docnumbers[$i]' AND est_id LIKE '$est_id'  AND bacc = $bnkacctid ";
                }
                else if($doctypsclrd[$i]== 'recp'){
                 $qrry42 ="UPDATE recptrans SET recon = '$recono' WHERE recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id'  AND bacc = $bnkacctid ";   
                }
                else if($doctypsclrd[$i]== 'jv'){
             $qrry42 ="UPDATE jentry SET recon = '$recono' WHERE jvno = '$docnumbers[$i]' AND estId = '$est_id' ";       
                }else if($doctypsclrd[$i]== 'uncleared'){
                $qrry42 ="UPDATE recptrans_temp SET recon = '$recono' WHERE recpno = '$docnumbers[$i]' AND estId = '$est_id' ";     
                }
    
          //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $data43=$mumin->getdbContent($qrry4);
        @$updateq = $mumin->getdbContent($qrry42);
         // echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($data43[0]['rdate'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$data43[0]['doctype'].':&nbsp;'.$data43[0]['isdeposited'].' - '.$data43[0]['pmode'].'</td><td></td><td style="width:100px; text-align: right;padding-right:10px">'.number_format($data43[0]['amount'],2).'</td><td></td></tr>';
            $dpamount = $dpamount  + $data43[0]['amount'];
          }
          //if reconcilliation done via pop up screen
          if($incmejv != 0){
          //echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($b[0]['date'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$b[0]['doctype'].':&nbsp;'.$b[0]['docno'].' - '.$b[0]['pmode'].'</td><td></td><td style="width:100px; text-align: right;padding-right:10px">'.number_format($b[0]['amount'],2).'</td><td></td></tr>';
          $incmejvamnt = $b[0]['amount'];
          
          }else{
              $incmejvamnt = 0;
          }
          $sumdpamount = $dpamount + $incmejvamnt;
         // echo '<tr><td></td><td colspan="2">Total Deposits Cleared</td><td></td><td style="text-align: right;padding-right:10px;height:20px"><b>'.number_format($sumdpamount,2).'</b></td></tr>';
         
?>
        
  </table>-->
   <!--  <table id="totaldep" >
      
<thead><tr><th colspan="7" style="background-color: #00AA88;text-align: left;height: 20px">Payments Cleared</th></tr></thead>
<tr style="font-weight: bold;"><td style="width:100px"></td><td style="width:3px"></td><td style="width:400px"></td><td style="width:3px"></td><td style="width:100px"></td><td></td></tr>   
 <?php
 $wthdamount = 0;
  if($directexp != 0){
             $dexp=$mumin->getdbContent("SELECT dexpno,dexpdate,ts,'Direct Expense' as doctype,chqno,dacc,'-' AS supplier,costcentrid,rmks,amount FROM directexpense WHERE dexpno = '$directexp' AND estate_id = '$est_id'");       
    
             }
          for($i=0;$i<=count($withdrwalrecon)-2;$i++){
             
            //$qrly="SELECT pdate,payno,amount,IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM estate_paytrans WHERE payno = '$withdrwalrecon[$i]' AND estId LIKE '$est_id' AND bacc = '$bnkacctid' order by pdate ";
            $qrly="SELECT * FROM (SELECT pdate,payno,amount,'Payment V. No' as doctype ,'pv' as doc, IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE pdate <= '$reconcidate' AND estId LIKE '$est_id' AND bacc = $bnkacctid AND recon = '0' UNION
                  SELECT jdate as date,jvno as docno,IF(crdtacc='".$bnkacctid."' AND cbacc = '1' ,amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode FROM jentry where jdate <= '$reconcidate'  AND estId = '$est_id' AND (crdtacc = '$bnkacctid') AND crdtaccrecon = '0' UNION 
                  SELECT date,docno,amount,doctype,doc,pmode FROM (SELECT dexpdate as date,dexpno as docno,IF(cacc='$bnkacctid' ,amount,amount*-1)as amount,'Direct Expense' as doctype ,'de' as doc,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate <= '$reconcidate'  and estate_id ='$est_id' AND recon = '0')t7 WHERE bankacct = '$bnkacctid'    ORDER by pdate)t9 WHERE payno = '$withdrwalrecon[$i]' AND doc = '$clrdwitdrawaldoc[$i]' ";
            if($clrdwitdrawaldoc[$i]=='pv'){
            $qrly2 = "UPDATE paytrans SET recon = '$recono' WHERE payno = '$withdrwalrecon[$i]' AND estId LIKE '$est_id' AND bacc = $bnkacctid";
            }
            else if($clrdwitdrawaldoc[$i]=='jv'){
             $qrly2 = "UPDATE jentry SET crdtaccrecon = '$recono' WHERE jvno = '$withdrwalrecon[$i]' AND estId LIKE '$est_id' ";   
                }
                else if($clrdwitdrawaldoc[$i]=='de'){
             $qrly2 = "UPDATE directexpense SET recon = '$recono' WHERE dexpno = '$withdrwalrecon[$i]' AND estate_id LIKE '$est_id' ";   
                }
    
                
          //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $data36=$mumin->getdbContent($qrly);
          @$updatedata = $mumin->getdbContent($qrly2);
         // echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($data36[0]['pdate'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$data36[0]['doctype'].':&nbsp;'.$data36[0]['payno'].' - '.$data36[0]['pmode'].'</td><td></td><td style="width:100px; text-align: right;padding-right:10px">'.number_format($data36[0]['amount'],2).'</td><td></td></tr>';
            $wthdamount = $wthdamount  + $data36[0]['amount'];
          }
          if($directexp != 0){
            //  echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($dexp[0]['dexpdate'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$dexp[0]['doctype'].':&nbsp;'.$dexp[0]['dexpno'].' - '.$dexp[0]['rmks'].' </td><td></td><td style="width:100px; text-align: right;padding-right:10px">'.number_format($dexp[0]['amount'],2).'</td><td></td></tr>';
          
              $directexpamnt = $dexp[0]['amount'];
          }else{
              $directexpamnt = 0;
          }
          $sumpaymnts = $wthdamount + $directexpamnt;
         // echo '<tr><td></td><td colspan="2">Total Payments Cleared</td><td></td><td style="text-align: right;padding-right: 10px;height:20px;height:20px"><b>'.number_format($sumpaymnts,2).'</b></td></tr>';
     $cashbookbal = $sumdpamount - $sumpaymnts + $oppenblnce2;
?>
<tr><td colspan="7" style="border-top: #000 solid 1px; border-bottom: #000 solid 1px; height: 5px"></td></tr>
  </table>  -->

<br>
 <table id="totaldep" class="table"> 
     <?php
     $qeury = $mumin->getdbContent("SELECT IFNULL(MIN(DATE_ADD( recondate, INTERVAL 1 DAY )), '2010-01-01') as recondate FROM bankrecon WHERE  bacc = '$bnkacctid' and id = (select max(id) from bankrecon WHERE  bacc = '$bnkacctid') AND est_id = '$est_id' ");    
     //$tomorrow = date('m-d-Y',strtotime($date1 . "+1 days"));
     $qtery = "SELECT sum(bbfamt) as brfamnt,tno FROM (SELECT sum(amount) as bbfamt,tno FROM recptrans WHERE bacc=$bnkacctid AND est_id = '$est_id' AND date(depots) < '".$qeury[0]['recondate']."' UNION
                                                       SELECT sum(amount) as bbfamt,jid FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate < '".$qeury[0]['recondate']."'  and estate_id ='$est_id')t7 WHERE bankacct = $bnkacctid UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt,tno FROM paytrans WHERE bacc='$bnkacctid' AND estId = '$est_id' AND pdate < '".$qeury[0]['recondate']."' UNION
                                                       SELECT sum(amount) as bbfamt,tno FROM (SELECT IF(crdtacc= '$bnkacctid' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$bnkacctid' or dbtacc = '$bnkacctid') AND  estId = '$est_id' AND jdate < '".$qeury[0]['recondate']."')T1) t6 ";
           $balanceldgr=$mumin->getdbContent($qtery);                                                                                                                                                        
           $balbbf = $balanceldgr[0]['brfamnt'];
           $balncebbf = number_format($balbbf,2);
     
     ?>
 <br><br><br><tr><td style="width:100px;"></td><td style="width:400px;font-weight:bold"> Opening Cashbook Balance</td><td style="width:3px"></td><td style="text-align: right;font-weight:bold"><?php echo $balncebbf; ?></td></tr>
<?php
$totaldbt = 0; $totalcrdt = 0;
       
          $qry = "SELECT * FROM (SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,sum(-1*amount),'')as creditamt,IF(amount>0,sum(amount),'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,depots as ts FROM recptrans WHERE date(depots) BETWEEN '".$qeury[0]['recondate']."' AND '$reconcidate' AND bacc = $bnkacctid  AND est_id LIKE '$est_id' AND pmode = 'CASH' GROUP BY isdeposited UNION
                  SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,-1*amount,'')as creditamt,IF(amount>0,amount,'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,depots as ts FROM recptrans WHERE date(depots) BETWEEN '".$qeury[0]['recondate']."' AND '$reconcidate' AND bacc = $bnkacctid  AND est_id LIKE '$est_id' AND pmode = 'CHEQUE' UNION
                  SELECT pdate as date,payno as docno,rmks,IF(amount>0,amount,'')as creditamt,IF(amount<0,-1*amount,'')as debitamt,'Payment V.' as doctype,IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode,ts FROM paytrans WHERE pdate BETWEEN '".$qeury[0]['recondate']."' AND '$reconcidate' AND estId = '$est_id' AND bacc='$bnkacctid' UNION
                  SELECT jdate as date,jvno as docno,rmks,IF(crdtacc='".$bnkacctid."' AND cbacc = '1' ,amount,'')as creditamt,IF(dbtacc='".$bnkacctid."' AND dbacc = '1',amount,'')as debitamt,'Journal Voucher' as doctype, rmks AS pmode,ts FROM jentry where jdate  BETWEEN '".$qeury[0]['recondate']."' AND '$reconcidate' AND estId = '$est_id' AND (dbtacc = '$bnkacctid' or crdtacc = '$bnkacctid') UNION
                  SELECT date,docno,rmks,creditamt,debitamt,doctype,pmode,ts FROM (SELECT dexpdate as date,dexpno docno,rmks,IF(cacc='$bnkacctid' ,amount,'')as creditamt, IF(dacc='$bnkacctid',amount,'')as debitamt,'Direct Expense' as doctype,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate BETWEEN  '".$qeury[0]['recondate']."' and '$reconcidate'  and estate_id ='$est_id')t7 WHERE bankacct = '$bnkacctid')t5 order by date,ts";
              
        
          $bankledgerdet=$mumin->getdbContent($qry);
for($r=0;$r<count($bankledgerdet);$r++){
    $totaldbt = $totaldbt + $bankledgerdet[$r]['debitamt'];
                    $totalcrdt = $totalcrdt + $bankledgerdet[$r]['creditamt'];
}
        $cashbkclsingbal = $balbbf +$totaldbt-$totalcrdt;
?>
 <tr><td></td><td><b>Receipts</b></td><td style="width:3px"></td><td style="text-align: right;font-weight:bold"><?php echo number_format($totaldbt,2); ?></td></tr>
<tr><td></td><td><b>Payments</b></td><td style="width:3px"></td><td style="text-align: right;font-weight:bold"><?php echo number_format($totalcrdt,2); ?></td></tr>
 <tr><td></td><td><b>Cash Book Closing Balance</b></td><td style="width:3px"></td><td style="text-align: right;font-weight:bold"><b><?php echo number_format($cashbkclsingbal,2);  ?></b></td></tr>
 <tr><td colspan="4">&nbsp;</td></tr>
  <table id="totaldep" class="table table-condensed">
      <div class="pagebreak"></div>
<thead><tr><th colspan="7" style="background-color: #ffd9ae !important; text-align: left;height: 20px">Uncleared Deposits</th></tr></thead>
    <tr style="font-weight: bold;"><td style="width:100px">Date</td><td style="width:3px"></td><td style="width:400px">Narration</td><td style="width:3px"></td><td style="width:100px">Amount</td><td></td></tr>
<?php
 $unclrdepositamnt = 0;
          for($i=0;$i<=count($recpnotrecon)-2;$i++){
             
  
                   $qrlw = "SELECT * FROM (SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'recp' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,recpno,amount,'Deposit No' as doctype,'uncleared' as doc,isdeposited,concat(pmode,' ','No:',' ',chqno,' ',chqdet) AS pmode FROM recptrans_temp WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CHEQUE' UNION
                        SELECT DATE_FORMAT(depots, '%Y-%m-%d') as rdate ,isdeposited as recpno,sum(amount),'Deposit No' as doctype,'depo' as doc,isdeposited, pmode FROM recptrans WHERE rdate <= '$reconcidate' AND est_id LIKE '$est_id' AND recon = '0' AND bacc = $bnkacctid AND pmode = 'CASH' GROUP BY isdeposited UNION
                        SELECT jdate as date,jvno as docno,IF(dbtacc='$bnkacctid' AND dbacc = '1',amount,'0')as amount,'J.V No' as doctype ,'jv' as doc,jvno, rmks AS pmode FROM jentry where jdate  <= '$reconcidate' AND estId = '$est_id' AND (dbtacc = '$bnkacctid') AND recon = '0' ORDER BY rdate) t7 WHERE recpno = '$recpnotrecon[$i]' and  doc = '$doctypesnotclrd[$i]'";
                         //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $data46=$mumin->getdbContent($qrlw);
          echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($data46[0]['rdate'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$data46[0]['doctype'].':&nbsp;'.$data46[0]['isdeposited'].' - '.$data46[0]['pmode'].'</td><td></td><td style="width:100px; text-align: right;padding-right:10px">'.number_format($data46[0]['amount'],2).'</td><td></td></tr>';
            $unclrdepositamnt = $unclrdepositamnt  + $data46[0]['amount'];
          }
          echo '<tr><td colspan="7" style="border-bottom: #000 solid 1px; height: 5px"></td></tr>';   
          echo '<tr><td></td><td colspan="2">Uncleared Deposits</td><td></td><td style="text-align: right;padding-right:10px;height:20px"><b>'.number_format($unclrdepositamnt,2).'</b></td></tr>';
          
?>
     <tr><td colspan="7" style="border-top: #000 solid 1px; border-bottom: #000 solid 1px; height: 5px"></td></tr>     
  </table> 
    <table id="totaldep" class="table table-condensed">
      
<thead><tr><th colspan="7" style="background-color: #ffd9ae !important; text-align: left;height: 20px">Uncleared Payments</th></tr></thead>
   <tr style="font-weight: bold;"><td style="width:100px">Date</td><td style="width:3px"></td><td style="width:400px">Narration</td><td style="width:3px"></td><td style="width:100px">Amount</td><td></td></tr>
<?php
 $unclrwthdrwlamnt = 0;
          for($i=0;$i<=count($withdocnotrecon)-2;$i++){
             
            //$qrlz="SELECT pdate,payno,amount,IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM estate_paytrans WHERE payno = '$withdocnotrecon[$i]' AND estId LIKE '$est_id' AND bacc = '$bnkacctid' order by pdate ";
            $qrlz="SELECT * FROM (SELECT pdate,payno,amount,'Payment V. No' as doctype ,'pv' as doc, IF(pmode='CASH',pmode,concat(pmode,' ','No:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE pdate <= '$reconcidate' AND estId LIKE '$est_id' AND bacc = $bnkacctid AND recon = '0' UNION
                  SELECT jdate as date,jvno as docno,IF(crdtacc='".$bnkacctid."' AND cbacc = '1' ,amount,'0')as amount,'J.V No' as doctype ,'jv' as doc, rmks AS pmode FROM jentry where jdate <= '$reconcidate'  AND estId = '$est_id' AND (crdtacc = '$bnkacctid') AND recon = '0' UNION 
                  SELECT date,docno,amount,doctype,doc,pmode FROM (SELECT dexpdate as date,dexpno as docno,IF(cacc='$bnkacctid' ,amount,amount*-1)as amount,'Direct Expense' as doctype ,'de' as doc,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts FROM directexpense WHERE dexpdate <= '$reconcidate'  and estate_id ='$est_id' AND recon = '0')t7 WHERE bankacct = '$bnkacctid'    ORDER by pdate)t9 WHERE payno = '$withdocnotrecon[$i]' AND doc = '$notclrdwitdrawaldoc[$i]' ";


                                       //$reconqry = $mumin->getdbContent("UPDATE estates_recptrans SET recon = '1' where recpno = '$docnumbers[$i]' AND est_id LIKE '$est_id' AND bacc = '$bnkacctid' ");
          $dat=$mumin->getdbContent($qrlz);
          echo '<tr><td style="width:100px">&nbsp;&nbsp;'.date('d-m-Y', strtotime($dat[0]['pdate'])).'</td><td></td><td style="width:200px">&nbsp;&nbsp;'.$dat[0]['doctype'].':&nbsp;'.$dat[0]['payno'].' - '.$dat[0]['pmode'].'</td><td></td><td style="width:100px; text-align: right;padding-right: 10px">'.number_format($dat[0]['amount'],2).'</td><td></td></tr>';
            $unclrwthdrwlamnt = $unclrwthdrwlamnt  + $dat[0]['amount'];
          }
          echo '<tr><td colspan="7" style="border-bottom: #000 solid 1px; height: 5px"></td></tr>';
          echo '<tr><td></td><td colspan="2">Uncleared Payments</td><td></td><td style="text-align: right;padding-right:10px;height:20px"><b>'.number_format($unclrwthdrwlamnt,2).'</b></td></tr>';
          
?>
      <tr><td colspan="7" style="border-top: #000 solid 1px; border-bottom: #000 solid 1px; height: 5px"></td></tr>  
  </table>
  <tr><td>&nbsp;</td></tr>
 <table id="totaldep" class="table table-condensed"> 
     <?php
     $balanceaspercashbk = $cashbkclsingbal - $unclrdepositamnt + $unclrwthdrwlamnt;
     ?>
 <tr style="font-weight: bold;"><td style="width:100px;"></td><td style="width:400px;" >Balance as per Cashbook</td><td style="width:3px"></td><td style="text-align: right"><?php echo number_format($balanceaspercashbk,2); ?></td></tr>
<tr style="font-weight: bold;"><td></td><td >Balance as per Bank Statement</td><td style="width:3px"></td><td style="text-align: right"><?php echo number_format($cashbookbal,2); ?></td></tr>
 <tr style="font-weight: bold;"><td></td><td >Difference</td><td style="width:3px"></td><td style="text-align: right"><?php $diff = $balanceaspercashbk - $cashbookbal; echo number_format($diff,2); ?></td></tr>
  <tr><td style="font-size: 11px;text-align: left" colspan="5"><br><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?></br> </td></tr> 
   
     </table>
    
<?php
$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING);
$insrtqry = "INSERT INTO bankrecon (recondate,ts,user,bacc,cshbkbal,bnkclsbal,clearedbal2,diff,est_id,reconid) VALUES ('$reconcidate','$ts','$us','$bnkacctid','$cashbookbal','$clsingbalance', '$cashbkbal2' ,'$diff','$est_id','$recono')";
$insert = $mumin->insertdbContent($insrtqry);
$closingprd = $mumin->insertdbContent("INSERT INTO closing_period (deptid,cdate,us,ts,ip,allow) VALUES ('$est_id','$reconcidate','$us','$ts','$localIP','1')");
?>
    
    </body>
</html>