<?php
session_start(); 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
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
<title>Acct Details</title>
 
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
    }#ledgerh{
        
        width: 620px;
               
    }
		
	#tablet{
        width: 620px;
        border-bottom: #000 double 1px;
    }
    #tablet td{
        height: 25px;
    }
	thead {display: table-header-group;}	
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
      <body>
    <div align="center" id="printNot">
        <br>
<button id ="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<br></br>
<!--<button class="sexybutton sexymedium sexyyellow" id="compose"><span><span><span class="cancel">Email</span></span></span></button> -->
 </div>
          <div id="ledgerh" >
    <?php
        $frmdateincme =date('d-m-Y',  strtotime($_GET['fromdate']));
        $tdateincme = date('d-m-Y',  strtotime($_GET['todate']));
        $frmdate = date('Y-m-d', strtotime($frmdateincme));
        $tdate1 = date('Y-m-d', strtotime($tdateincme));
        $incmgact =$_GET['incmgact'];
        $idestate = $id;
        $incmActname = $mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$incmgact' ");
        $incmeacttname = $incmActname[0]['accname'];
        
       ?>
   
    <table id="tablet" >
		<tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td><b>INCOME ACCOUNT DETAILS </b></td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;'><td> &nbsp;&nbsp; For the period:&nbsp; <?php echo "$frmdateincme &nbsp&nbsp TO &nbsp&nbsp $tdateincme" ;?> </td></tr>
        <tr align="center" style='font-family:Trebuchet MS;font-size:20px;' ><td> &nbsp;&nbsp;Account: <?php echo "&nbsp&nbsp<font><b>$incmeacttname</b></font>"?></td></tr>
		 <tr><td></td></tr>
	</table>
	
      <table id="ledgerdet" style='font-family:Trebuchet MS;'>
          <thead><tr><th style="width:70px">Date</th><th></th><th>Narration</th><th></th><th>Debit</th><th></th><th>Credit</th><th></th><th>Balance</th></tr></thead>
          <?php
          $totaldbt1 = 0; $totalcrdt1 = 0; $balbbf1 = 0;
          $incmamnt5 = $mumin->getdbContent("SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,jdate,jvno,rmks,tno FROM jentry WHERE jdate BETWEEN '$frmdate' AND '$tdate1' AND estId = '$idestate' AND crdtacc = '$incmgact'");      

              for ($h=0;$h<=count($incmamnt5)-1;$h++){
                  if($incmamnt5[$h]['dbtamnt'] == '0'){
                  $balbbf1+=floatval($incmamnt5[$h]['crdtamnt']);
                  } else {
                  $balbbf1-=floatval($incmamnt5[$h]['dbtamnt']);    
                  }
                echo "<tr style='font-size:12px;'><td>".date('d-m-Y',  strtotime($incmamnt5[$h]['jdate']))."</td><td></td><td>&nbsp;&nbsp;&nbsp;J.V No:&nbsp;&nbsp;".$incmamnt5[$h]['jvno']."&nbsp - &nbsp".$incmamnt5[$h]['rmks']." </td><td></td><td style='text-align: right;'>".number_format($incmamnt5[$h]['dbtamnt'],2)."&nbsp;&nbsp;&nbsp;</td><td></td><td style='text-align: right;'>".number_format($incmamnt5[$h]['crdtamnt'],2)."&nbsp;&nbsp;&nbsp;</td><td></td><td style='text-align: right;'>".number_format($balbbf1,2)."&nbsp;&nbsp;&nbsp;</td></tr>";   
                $totaldbt1 = $totaldbt1 + $incmamnt5[$h]['dbtamnt'];
                $totalcrdt1 = $totalcrdt1 + $incmamnt5[$h]['crdtamnt'];
            }                                
               echo "<tr><td colspan='9'><hr></td></tr>";
                echo "<tr style='font-size:13px;'><td colspan='4' style='text-align: center;'><b>TOTAL</b></td><td style='text-align: right;'>".number_format($totaldbt1,2)."&nbsp&nbsp&nbsp</td><td></td><td style='text-align: right;'>".number_format($totalcrdt1,2)."&nbsp&nbsp</td><td></td><td style='text-align: right;'>".number_format($balbbf1,2)."&nbsp;&nbsp;&nbsp;</td></tr>";
          ?>
                
          <tr><td colspan="9"><hr></hr></td></tr>
      </table>
              
              </div>
          <div style="margin-left: 200px">
              <span  style="font-size:x-small;">Printed by:<?php echo " ".$_SESSION['jname']." &nbsp;&nbsp; ".date("d-m-Y H:i:s")."";?></span> </div> <br/>

          </div>
    </body>
    </html>
<?php }?>