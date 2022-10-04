<?php
session_start(); 
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
<title>Depreciation Accts</title>
 
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
        $frmdatexpnse =date('d-m-Y',  strtotime($_GET['startdate']));
        $tdatexpnse = date('d-m-Y', strtotime($_GET['enddate']));
        $frmdate = date('Y-m-d', strtotime($_GET['startdate']));
        $tdate1 = date('Y-m-d', strtotime($_GET['enddate']));
        $deprecid =$_GET['depreciationid'];
        $idestate = $_SESSION['dept_id'];
        $deprecname = $mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$deprecid' ");
        $depreciationacct = $deprecname[0]['accname'];
        
       ?>
   
    <table id="tablet" >
		<tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td><b>Account Details </b></td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td> &nbsp;&nbsp; For the period:&nbsp; <?php echo "$frmdatexpnse &nbsp&nbsp TO &nbsp&nbsp $tdatexpnse" ;?> </td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;' ><td> &nbsp;&nbsp;Account: <?php echo "&nbsp&nbsp<font><b>$depreciationacct</b></font>"?></td></tr>
		 <tr><td></td></tr>
	</table>
	
      <table id="ledgerdet" style='font-family:Trebuchet MS;'>
          <tr><th style="width:70px">Date</th><th></th><th>Doc No</th><th>Remarks</th><th></th><th>Debit</th><th></th><th>Credit</th><th></th><th>Balance</th></tr>
		          <?php
          $totalbalance = 0; 
          $deprincme =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname,opbal FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'D' AND incomeactmgnt.deptid = '$idestate' AND incomeaccounts.incacc = '$deprecid' GROUP BY incomeaccounts.incacc "); //Income accounts
          $depreciationqry = $mumin->getdbContent("SELECT SUM(dramount) as debitamount , sum(cramount) as cramount  FROM `journals` WHERE tbl = 'I' and type = 'D' AND acc = '$deprecid' AND jdate  < '$frmdate' AND deptid = '$idestate'");
          $depreciationop = $depreciationqry[0]['cramount'] - $depreciationqry[0]['debitamount'];
         
                     $opbal = $deprincme[0]['opbal'];
                    
                     $balbbf = $opbal + $depreciationop;
           $balncebbf = number_format($balbbf,2);
          
           
          ?>
                  <tr style='font-size:12px;'><td colspan="8" style="text-align: center"><b>Opening Balance</b></td><td colspan="2" style="text-align: right;padding-right:10px"><?php echo $balncebbf; ?></td></tr>

          <?php
          $totaldbt = 0; $totalcrdt = 0;  
       
            $depreciationlist = $mumin->getdbContent("SELECT jdate,jno,dramount as debitamount , cramount as cramount,rmks,tno  FROM `journals` WHERE tbl = 'I' and type = 'D' AND acc = '$deprecid' AND jdate  BETWEEN '$frmdate' and '$tdate1' AND deptid = '$idestate'");

          
          
              for ($h=0;$h<=count($depreciationlist)-1;$h++){
                    $totaldbt = $totaldbt + $depreciationlist[$h]['debitamount'];
                    $totalcrdt = $totalcrdt + $depreciationlist[$h]['cramount'];
                    if($depreciationlist[$h]['cramount']!=" "){
                             
                               $balbbf+=floatval($depreciationlist[$h]['cramount']);
                                  $debtamnt = '0';
                                  $crdtamt = $depreciationlist[$h]['cramount'];
                           }
                           else if($depreciationlist[$h]['debitamount']!=" "){
                               
                               $balbbf-=floatval($depreciationlist[$h]['debitamount']);
                               $debtamnt =$depreciationlist[$h]['debitamount'];
                               $crdtamt = '0';
                               }
                               else if($depreciationlist[$h]['debitamount'] ==" " || $depreciationlist[$h]['cramount'] ==" "){
                               
                               $balbbf-=floatval($depreciationlist[$h]['debitamount']);
                               $debtamnt = '0';
                               $crdtamt = '0';
                               //$bankledgerdet[$r]['doctype'] = '';
                              // $bankledgerdet[$r]['docno'] ='';
                               }
                echo "<tr style='font-size:12px;'><td>".date('d-m-Y',  strtotime($depreciationlist[$h]['jdate']))."</td><td></td><td>&nbsp;&nbsp;".$depreciationlist[$h]['jno']."&nbsp;</td><td> &nbsp;&nbsp".$depreciationlist[$h]['rmks']." </td><td></td><td style='text-align: right;padding-right:10px'>".number_format($debtamnt,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($crdtamt,2)."</td><td></td><td style='text-align: right; padding-right: 10px'>".number_format($balbbf,2)."</td></tr>";   
                
            }                                
              
                echo "<tr style='font-size:13px;'><td colspan='5' style='text-align: center;'><b>TOTAL</b></td><td style='text-align: right;padding-right: 10px'>".number_format($totaldbt,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($totalcrdt,2)."</td><td></td><td style='text-align: right;padding-right: 10px'>".number_format($balbbf,2)."</td></tr>";
          ?>
                 <tr><td colspan='10'><hr></td></tr>
         
      </table>
              
              </div>
          <div style="margin-left: 200px">
              <span  style="font-size:x-small;">Printed by:<?php echo " ".$_SESSION['jname']." &nbsp;&nbsp; ".date("d-m-Y H:i:s")."";?></span> </div> <br/>

          </div>
    </body>
    </html>