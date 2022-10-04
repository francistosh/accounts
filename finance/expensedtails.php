<?php
session_start(); 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}else{
date_default_timezone_set('Africa/Nairobi');
include 'operations/Mumin.php';
$id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  
<head runat="server">
<title>Expense Acct</title>
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>
<style>
    #ledgerh{
        border: #8F5B00 solid 1px;
        border-radius: 3px;
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
        width: 980px;
        border-bottom: #000 double 1px;
    }
    #tablet td{
        height: 25px;
    }
    #ledgerdet{
        width: 980px;
        font-size:16px;
        border: #8F5B00 solid 3px;
    border-collapse:collapse;
    }
    #ledgerdet td{
        height: 25px;
        border: #8F5B00 solid 1px;
    }
    
	
    @media print{
        #printNot {display: none;}
		#ledgerdet{
        width: 620px;
		font-size:12px;
    }
	#ledgerh{
       
        width: 620px;
           }	
	#tablet{
        width: 620px;
        border-bottom: #000 double 1px;
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
<button id ="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<br></br>
<!--<button class="sexybutton sexymedium sexyyellow" id="compose"><span><span><span class="cancel">Email</span></span></span></button> -->
 </div>
          <div id="ledgerh" >
    <?php
        $frmdatexpnse =date('d-m-Y',strtotime($_GET['fromdate']));
        $tdatexpnse = date('d-m-Y',strtotime($_GET['enddate']));
        $frmdate = date('Y-m-d', strtotime($frmdatexpnse));
        $tdate1 = date('Y-m-d', strtotime($tdatexpnse));
        $expactid =$_GET['expactid'];
        $idestate = $_SESSION['dept_id'];
        $ExpActname = $mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id = '$expactid' ");
        $expnseacttname = $ExpActname[0]['accname'];
        
       ?>
   
    <table id="tablet" >
		<tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td><b>Expense Account Details </b></td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td> &nbsp;&nbsp; For the period:&nbsp; <?php echo "$frmdatexpnse &nbsp&nbsp TO &nbsp&nbsp $tdatexpnse" ;?> </td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;' ><td> &nbsp;&nbsp;Account: <?php echo "&nbsp&nbsp<font><b>$expnseacttname</b></font>"?></td></tr>
		 <tr><td></td></tr>
	</table>
	
      <table id="ledgerdet" style='font-family:Trebuchet MS;'>
          <tr><th style="width:70px">Date</th><th></th><th>Narration</th><th>Remarks</th> <th>Cost Center</th><th></th><th>Debit</th><th></th><th>Credit</th><th></th><th>Balance</th></tr>
		

          <?php
          $totaldbt1 = 0; $totalcrdt1 = 0; $balbbf1 = 0;
       
          $expensedetails = $mumin->getdbContent("SELECT  debitamnt,bdate,narration,rmks,costcentrid  FROM(SELECT bdate,IF(isinvce='1',concat('Bill No :',' ',docno),concat('Credit Bill No :',' ',docno)) as narration,IF(isinvce='1',amount,amount*-1) as debitamnt,id,rmks,costcentrid FROM  bills WHERE expenseacc ='$expactid'  AND estate_id = '$idestate' AND bdate BETWEEN '$frmdate' AND '$tdate1' UNION
                                                                                                          SELECT jdate,CONCAT('Journal Entry No:',' ',jno) as narration,IF(dramount='0',cramount*-1,dramount)as debitamnt,tno,rmks,'-' as costcentrid FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$frmdate' AND '$tdate1' AND deptid = '$idestate' AND acc = '$expactid' UNION
                                                                                                          SELECT jdate,CONCAT('Journal Voucher No:',' ',jno) as narration,IF(dramount='0',cramount*-1,dramount)as debitamnt,tno,rmks,'-' as costcentrid FROM `bad_debtsmbrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$frmdate' AND '$tdate1' AND deptid = '$idestate' AND acc = '$expactid' UNION
                                                                                                          SELECT jdate,CONCAT('Journal Voucher No:',' ',jno) as narration,IF(dramount='0',cramount*-1,dramount)as debitamnt,tno,rmks,'-' as costcentrid FROM `bad_debtsupplrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$frmdate' AND '$tdate1' AND deptid = '$idestate' AND acc = '$expactid' UNION
                                                    SELECT dexpdate,narration,amount as debitamnt,jid,rmks,costcentrid  FROM (SELECT dexpdate,concat('Direct Expense No:',' ',dexpno) as narration,jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,rmks,costcentrid  FROM directexpense WHERE dexpdate BETWEEN '$frmdate' AND '$tdate1' AND estate_id= '$idestate' )t7 WHERE expacc = '$expactid' order by bdate )T6");
     
              for ($h=0;$h<=count($expensedetails)-1;$h++){
                  if($expensedetails[$h]['debitamnt'] < 0 ){
                  $balbbf1 +=floatval($expensedetails[$h]['debitamnt']);
                  $credtamont = floatval($expensedetails[$h]['debitamnt']) *-1;
                  $debitamot = 0;
                  } else {
                  $balbbf1 +=floatval($expensedetails[$h]['debitamnt']);
                  $credtamont =  0;
                  $debitamot = floatval($expensedetails[$h]['debitamnt']);
                  }
                  @$costcentername = $mumin->getcostcentername($expensedetails[$h]['costcentrid']);
                echo "<tr style='font-size:12px;'><td>".date('d-m-Y',  strtotime($expensedetails[$h]['bdate']))."</td><td></td><td>&nbsp;&nbsp;&nbsp;".$expensedetails[$h]['narration']."</td><td> &nbsp;&nbsp".$expensedetails[$h]['rmks']." </td><td>&nbsp;&nbsp".@$costcentername."</td><td></td><td style='text-align: right;padding-right:10px'>".number_format($debitamot,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($credtamont,2)."</td><td></td><td style='text-align: right; padding-right: 10px'>".number_format($balbbf1,2)."</td></tr>";   
                $totaldbt1 = $totaldbt1 + $debitamot;
                $totalcrdt1 = $totalcrdt1 + $credtamont;
            }                                
              
                echo "<tr style='font-size:13px;'><td colspan='6' style='text-align: center;'><b>TOTAL</b></td><td style='text-align: right;padding-right: 10px'>".number_format($totaldbt1,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($totalcrdt1,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($balbbf1,2)."</td></tr>";
          ?>
                 <tr><td colspan='11'><hr></td></tr>
         
      </table>
              
              </div>
          <div style="margin-left: 200px">
              <span  style="font-size:x-small;">Printed by:<?php echo " ".$_SESSION['jname']." &nbsp;&nbsp; ".date("d-m-Y H:i:s")."";?></span> </div> <br/>

          </div>
    </body>
    </html>
<?php }?>