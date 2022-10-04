<?php
session_start(); 

if(!isset($_SESSION['jmsloggedIn'])){
  
    echo  "You must Login to see this page : <a href='../index.php'>Click to Login</a>";
       
}else{
date_default_timezone_set('Africa/Nairobi');
include 'operations/Mumin.php';

$mumin=new Mumin();

$id=$_SESSION['dept_id'];
$userid = $_SESSION['acctusrid'];

$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  
<head runat="server">
<title>Bank Ledger</title>
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>
<style>
    #ledgerh{
        background: #FFF;;
        width: 980px;
        margin-right:  auto;
        margin-left: auto;
        border-radius: 5px;
    }
    #titlel{
        text-align: center;
        font-weight: bold;
        margin-top: 10px;
    }
    #tablet{
        width: 100%;
    }
    #tablet td{
        height: 25px;
    }
    #ledgerdet{
        width: 980px;
		font-size:16px;
    }
    #ledgerdet td{
        height: 25px;
    }
    
	
    @media print{
        #printNot {display: none;}
		#ledgerdet{
        width: 660px;
		font-size:12px;
    }
	 #ledgerh{
        
        width: 660px;
	        
    }	
	#tablet{
        width: 660px;
        
    }
    #tablet td{
        height: 25px;
    }
	
    }
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
    <body style="overflow-x: visible!important;">
    <div align="center" id="printNot">
        <br>
<button id ="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Ledger</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<br></br>
<!--<button class="sexybutton sexymedium sexyyellow" id="compose"><span><span><span class="cancel">Email</span></span></span></button> -->
 </div>
          <div id="ledgerh" class="container">
    <?php
        $frmdate1 =$_GET['fromdate'];
        $tdate =$_GET['todate'];
        $frmdate = date('Y-m-d', strtotime($frmdate1));
        $tdate1 = date('Y-m-d', strtotime($tdate));
        $bnkact=$_GET['bnkact'];
        $eid = $id;
        $Actname = $mumin->getdbContent("SELECT CONCAT(acname,' : ',acno) AS acname FROM bankaccounts WHERE bacc = '$bnkact' ");
        $acttname = $Actname[0]['acname'];
        
       ?>
	<?php
		echo '<table id="style" border="0">';   
		echo '<tr>';
		echo '<td><img id="logo1" src="images/gold.png"></td>';
		echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p><font style="font-size:8px;">'.$_SESSION['details'].'</font></tr>';
		echo '</td></table>';
	?>
	
    <table id="tablet" >
		<tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td><b>Cash Book </b></td></tr>
                <tr align="center" style='font-family:Trebuchet MS;font-size:14px;'><td> &nbsp;&nbsp; Ledger for the period:&nbsp; <?php echo " ".date('d-m-Y',  strtotime($frmdate1))." &nbsp&nbsp To &nbsp&nbsp ".date('d-m-Y',strtotime($tdate))."" ;?> </td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:14px;'><td> &nbsp;&nbsp;Account: <?php echo "&nbsp&nbsp<font><b>$acttname</b></font>"?></td></tr>
		 
	</table>
	<br>
      <table id="ledgerdet" class="table table-condensed" style='font-family:Trebuchet MS;'>
          <tr><th style="border-top:1px solid black;width:70px">Date</th><th style="border-top:1px solid black;" colspan="3">Narration</th><th style="border-top:1px solid black;" class="right">Debit</th><th style="border-top:1px solid black;" class="right">Credit</th><th style="border-top:1px solid black;" class="right" style="padding-right:10px">Balance</th></tr>
		  
          <?php
          $totalbalance = 0;
          
          $qtery = "SELECT sum(bbfamt) as brfamnt,tno FROM (SELECT sum(amount) as bbfamt,tno FROM recptrans WHERE bacc=$bnkact AND est_id = '$eid' AND date(depots) < '$frmdate' UNION
                                                       SELECT sum(amount) as bbfamt,jid FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate < '$frmdate'  and estate_id ='$eid')t7 WHERE bankacct = $bnkact UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt,tno FROM paytrans WHERE bacc='$bnkact' AND estId = '$eid' AND pdate < '$frmdate' UNION
                                                       SELECT sum(amount) as bbfamt,tno FROM (SELECT IF(crdtacc= '$bnkact' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$bnkact' or dbtacc = '$bnkact') AND  estId = '$eid' AND jdate < '$frmdate')T1) t6 ";
           $balanceldgr=$mumin->getdbContent($qtery);                                                                                                                                                        
           $balbbf = $balanceldgr[0]['brfamnt'];
           $balncebbf = number_format($balbbf,2);
          
           
          ?>
                  <tr style='font-size:14px'><td colspan="4" style="text-align: right"><b>Balance B.F</b></td><td></td><td></td><td colspan="2" style="text-align: right;padding-right:10px;font-size:11px"><?php echo $balncebbf; ?></td></tr>
          <?php
          $totaldbt = 0; $totalcrdt = 0;
       
          $qry = "SELECT * FROM (SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,sum(-1*amount),'')as creditamt,IF(amount>0,sum(amount),'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,depots as ts,tno FROM recptrans WHERE date(depots) BETWEEN '$frmdate' AND '$tdate1' AND bacc = $bnkact  AND est_id LIKE '$eid' AND pmode = 'CASH' GROUP BY isdeposited UNION
                  SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,-1*amount,'')as creditamt,IF(amount>0,amount,'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,depots as ts,tno FROM recptrans WHERE date(depots) BETWEEN '$frmdate' AND '$tdate1' AND bacc = $bnkact  AND est_id LIKE '$eid' AND pmode = 'CHEQUE' UNION
                  SELECT pdate as date,payno as docno,rmks,IF(amount>0,amount,'')as creditamt,IF(amount<0,-1*amount,'')as debitamt,'Payment V.' as doctype,IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,ts,tno FROM paytrans WHERE pdate BETWEEN '$frmdate' AND '$tdate1' AND estId = '$eid' AND bacc='$bnkact' UNION
                  SELECT jdate as date,jvno as docno,rmks,IF(crdtacc='".$bnkact."' AND cbacc = '1' ,amount,'')as creditamt,IF(dbtacc='".$bnkact."' AND dbacc = '1',amount,'')as debitamt,'Journal Voucher' as doctype, rmks AS pmode,ts,tno FROM jentry where jdate  BETWEEN '$frmdate' AND '$tdate1' AND estId = '$eid' AND (dbtacc = '$bnkact' or crdtacc = '$bnkact') UNION
                  SELECT date,docno,rmks,creditamt,debitamt,doctype,pmode,ts,jid FROM (SELECT dexpdate as date,dexpno docno,rmks,IF(cacc='$bnkact' ,amount,'')as creditamt, IF(dacc='$bnkact',amount,'')as debitamt,'Direct Expense' as doctype,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts,jid FROM directexpense WHERE dexpdate BETWEEN  '$frmdate' and '$tdate1'  and estate_id ='$eid')t7 WHERE bankacct = '$bnkact')t5 order by date,ts";
              
        
          $bankledgerdet=$mumin->getdbContent($qry);
                for($r=0;$r<count($bankledgerdet);$r++){
                    //$totalbalance = $totalbalance + $bankledgerdet[$r]['debitamt'] - $bankledgerdet[$r]['creditamt'] +$balanceldgr[0]['brfamnt'] ;
                    $totaldbt = $totaldbt + $bankledgerdet[$r]['debitamt'];
                    $totalcrdt = $totalcrdt + $bankledgerdet[$r]['creditamt'];
                    if($bankledgerdet[$r]['creditamt']!==""){
                             
                               $balbbf-=floatval($bankledgerdet[$r]['creditamt']);
                                  $debtamnt = '0';
                                  $crdtamt = $bankledgerdet[$r]['creditamt'];
                           }
                           else if($bankledgerdet[$r]['debitamt']!==""){
                               
                               $balbbf+=floatval($bankledgerdet[$r]['debitamt']);
                               $debtamnt = $bankledgerdet[$r]['debitamt'];
                               $crdtamt = '0';
                               }
                               else if($bankledgerdet[$r]['debitamt'] =="" || $bankledgerdet[$r]['creditamt'] ==""){
                               
                               $balbbf+=floatval($bankledgerdet[$r]['debitamt']);
                               $debtamnt = '0';
                               $crdtamt = '0';
                               $bankledgerdet[$r]['doctype'] = '';
                               $bankledgerdet[$r]['docno'] ='';
                               }
                               if($bankledgerdet[$r]['doctype']=='Deposit'){
                                   $docnumb = '<a href="depositnoreprint.php?depsitno='.$bankledgerdet[$r]['docno'].'" target="_blank">'.$bankledgerdet[$r]['docno'].'</a>';
                               }else{
                                   $docnumb = $bankledgerdet[$r]['docno'];
                               }
                    echo "<tr style='font-size:11px'><td>".date('d-m-Y',  strtotime($bankledgerdet[$r]['date']))."</td><td >".$bankledgerdet[$r]['doctype']."&nbspNo:</td><td>".$docnumb."</td><td>&nbsp - &nbsp".$bankledgerdet[$r]['pmode']."</td><td style='text-align: right;padding-right:10px'>".number_format($debtamnt,2)."</td><td style='text-align: right;padding-right:10px'>".number_format($crdtamt,2)."</td><td style='text-align: right;padding-right:10px'>".number_format($balbbf,2)." </td></tr>";   
                }
               echo "<tr><td colspan='7'></td></tr>";
                echo "<tr style='font-size:12px'><td colspan='4' style='border-top:1px solid black;border-bottom-style:double;text-align: center;'><b>TOTAL</b></td><td style='border-top:1px solid black;border-bottom-style:double;text-align: right;padding-right:10px'>".number_format($totaldbt,2)."</td><td style='border-top:1px solid black;border-bottom-style:double;text-align: right;padding-right:10px'>".number_format($totalcrdt,2)."</td><td style='border-top:1px solid black;border-bottom-style:double;text-align: right;padding-right:10px'>".number_format($balbbf,2)."</td></tr>";
		  ?>
                
          <tr>
              <td colspan="2"><span  style="font-size:x-small;">Printed by:<?php echo " ".$_SESSION['jname']." &nbsp;&nbsp; ".date("d-m-Y H:i:s")."";?></span> </td>
		</tr>
      </table>
</div>
         <br />

          
    </body>
    </html>
<?php
}?>