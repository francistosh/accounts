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

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>payment voucher print | Mombasa Jamaat  Information System</title>
    
 
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
    
    
<script>
    
    
$(function() {
    

  
   $("#vchrprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    
    
   $("#b_home").button({
            icons: {
                primary: "ui-icon-arrowreturnthick-1-e",
                 secondary: "ui-icon-closethick"
                 
            }
        });
    
      $("#butnback").button({
            icons: {
                primary: "ui-icon-arrowthick-1-w",
                 secondary: "ui-icon-closethick"
                 
            }
        });
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="background: white;overflow-x: visible!important;">   

   
 <?php
  
  
     
     $paymentdate=trim($_GET['paymentdate']);
     $remarks =trim($_GET['rmks']);
     //$chequeno=trim($_GET['chequeno']);
     $amount= explode(",",$_GET['amount']);
     //$narration=trim($_GET['narration']);
     $supplier=trim($_GET['supplier']);
     $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $payno= explode(",",$_GET['payno']);
     $docnumbers=$_GET['docnumbers'];
     $costcid = explode(",",$_GET['costcid']);
    for($t=0;$t<=count($payno)-1;$t++){
    
   
     //$allocationacc=$mumin->getdbContent("SELECT * FROM  expaccs WHERE id LIKE '4' LIMIT 1");
     $displaypayno = sprintf('%06d',intval( $payno[$t]));
    $expenseact=$mumin->getdbContent("SELECT * FROM  expnseaccs WHERE id = '$expacc' LIMIT 1");
    $cntrname = $mumin->getdbContent("SELECT centrename FROM department2 WHERE id = '$costcid[$t]'");
   
    $supplierName=$mumin->getdbContent("SELECT * FROM  suppliers WHERE supplier = '$supplier' AND estId LIKE '$id' LIMIT 1");
     $bills = $mumin->getdbContent("SELECT bills FROM paytrans WHERE payno = '$displaypayno'");
    
 ?>
     
 <table style="text-align: left;padding:1px;border: #000 solid; border-radius: 3px;width:600px;height:460px;margin: 10px auto 0px auto" cellspacing="1" cellpadding="2" id="cashPaymentVoucher">
     <tr><td style="font-size: 10px;font-family:arial narrow;"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i><span style="float: right;font-size: 12px"><b><?php echo $_SESSION['dptname'] ?></b></span> </p> 
 <?php echo $_SESSION['details'];?></td><td style="text-align:right;" ></td></tr>   
     <tr><td><div id="sxx3" style="width: 650px;border:0px;height: 20px"><font style="font-weight: bold;float: left;font-family: verdana;border: 2px solid #155FB0;padding: 7px; border-radius: 3px;">Payment Voucher NO : <?php echo $displaypayno; ?></font><font style="float: right;margin-right: 10px;font-family: verdana;font-size: 12px"> Date : <?php echo date('d-m-Y', strtotime($paymentdate)) ?></font></div></td></tr> 
 
     <tr><td><div id="sxx3" style="width: 650px;border:0px;height: 50px;font-family: verdana;font-size: 13px">Payment To:&nbsp;&nbsp;<font style="margin-left:27px"><?php echo $supplierName[0]['suppName']."</font></br><font style='margin-left:115px'>&nbsp;P.o. Box&nbsp;".$supplierName[0]['postal']."</font><br/><font style='margin-left:115px'>&nbsp;".$supplierName[0]['city'] ."</font>";?><?php  ?></font></div></td></tr>
     <tr><td><div id="sxx1" style="width: 650px;height: 20px;font-family: verdana;font-size: 13px">Being payment of&nbsp;<?php echo $remarks; ?> &nbsp;&nbsp;Bill.Nos :&nbsp;<?php echo $bills[0]['bills']; ?>&nbsp;&nbsp;&nbsp;</div></td></tr>
     <tr><td><div id="sxx1" style="width: 650px;border-bottom:1px #000 solid;height: 30px;font-family: verdana;font-size: 13px">the sum of shillings&nbsp;<b><?php echo @ucwords($mumin->numWords($amount[$t])); ?>&nbsp;&nbsp;</b>Only.</div></td></tr>
     <tr><td><div id="sxx2" style="width: 650px;border:none;height: 20px;font-family: verdana;font-size: 13px;text-align: right;margin-right: 10px;"><b>CASH</b>&nbsp;&nbsp;<?php echo "&nbsp;&nbsp;&nbsp;- &nbsp;<font style='float:right;margin-right: 10px'><b>Kshs &nbsp;".number_format($amount[$t],2)."</font>";?></b></div></td></tr>
 
     <!--<tr><td><div id="sxx2" style="width: 700px;border:none;height: 30px;font-family: verdana;font-size: 12px">Allocation Account&nbsp;&nbsp;</div></td></tr>-->
     
     <tr><td><div id="sxx2" style="width: 650px;border:none;height: 30px;font-family: verdana;font-size: 12px">Allocation Account:&nbsp;&nbsp;<?php echo $expenseact[0]['accname']  ?><br>Cost Center: &nbsp;&nbsp;<?php echo $cntrname[0]['centrename'];  ?></div></td></tr>
     <tr style="border-top: 1px solid"><td><div id="sxx2" style="width: 650px;border:none;height: 30px;font-family: verdana;font-size: 12px"><font style="float: left"><div style="height: 30px;width: 80px;float: left">Treasurer:</div><div style="width: 200px;float: right;border-bottom: 1px #000 dotted;height: 30px"></div></font><font style="float: right"><div style="height: 30px;width: 100px;float: left">Collected By:</div><div style="width: 200px;float: right;border-bottom: 1px #000 dotted;height: 30px"></div></font></div></td></tr>
     <tr><td><div id="sxx2" style="width: 650px;border:none;height: 30px;font-family: verdana;font-size: 12px"><font style="float: left"><div style="height: 30px;width: 80px;float: left">Secretary:</div><div style="width: 200px;float: right;border-bottom: 1px #000 dotted;height: 30px"></div></font><font style="float: right"><div style="height: 30px;width: 100px;float: left">ID No:</div><div style="width: 200px;float: right;border-bottom: 1px #000 dotted;height: 30px"></div></font></div></td></tr>
  <tr class="payconf"></tr> 
  <tr><td><div id="sxx2" style="width: 650px;border-top: 1px #000 solid;height: 20px;font-family: verdana;font-size: 10px"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?></div></td></tr> 
  </table>
    <div style="page-break-after:always"> </div>
    <?php
     }
    ?>
      <button id="vchrprint201" style="margin: 10px auto 0px 350px">print</button><button onclick="history.back()" id="butnback" style="margin: 10px auto 0px 150px">Back</button><button onclick="window.close();" id="b_home" style="margin: 10px auto 0px 100px">Close</button>
   </body>
</html> 