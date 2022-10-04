<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level!=999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

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
<title>receipt print | Mombasa Jamaat  Information System</title>
    
 
<?php

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
                primary: "ui-icon-arrowreturnthick-1-e"
                 
            }
        });
    
      
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;background: white">   
  
   
 <?php
  
  
     
     $paymentdate=trim($_GET['paymentdate']);
     $chequedate=trim($_GET['chequedate']);
     $chequeno=trim($_GET['chequeno']);
     $amount=trim($_GET['amount']);
     $narration=trim($_GET['narration']);
     $supplier=trim($_GET['supplier']);
     $expacc=trim($_GET['expacc']);
     $acc=trim($_GET['acc']);
     $payno=trim($_GET['payno']);
     $docnumbers=$_GET['docnumbers'];
     $est_id=$_SESSION['est_prop'];
     
     $allocationacc=$mumin->getdbContent("SELECT * FROM  estate_expaccs WHERE id LIKE '$expacc' LIMIT 1");
     
    $bankacc=$mumin->getdbContent("SELECT * FROM  estate_bankaccounts WHERE acno LIKE '$expacc' AND estate_id LIKE '$est_id' LIMIT 1");
   
   
    $supplierName=$mumin->getdbContent("SELECT * FROM  estate_suppliers WHERE supplier = '$supplier' AND estId LIKE '$est_id' LIMIT 1");
     
      
 
 ?>
    
  
        
 
   
    
    
 <table style="text-align: left;padding:1px;border:none;width:700px;height:500px;margin: 1px auto 0px auto" cellspacing="1" cellpadding="2" id="chequePaymentVoucher">
     <tr><td><div id="sxx3" style="width: 700px;border:0px;height: 40px;"><i><font style="font-size:14px;text-align: left;font-weight:bold;text-transform: uppercase"><?php echo  $_SESSION['estatefullname'].",". $_SESSION['mohalla']; ?></font></i></div> </td></tr>
  
     <tr><td><div id="sxx3" style="width: 700px;border:0px;height: 20px"><font style="font-weight: bold;float: left;font-family: verdana">Payment Voucher NO : <?php echo sprintf('%06d',intval( $payno)); ?></font><font style="float: right;margin-right: 100px;font-family: verdana;font-size: 12px"> Date : <?php echo $paymentdate ?></font></div></td></tr> 
 
     <tr><td><div id="sxx3" style="width: 700px;border:0px;height: 50px;font-family: verdana;font-size: 12px">PETTY CASH PAYMENTS:&nbsp;&nbsp;<font style="margin-left:27px"><?php ?><?php  ?></font></div></td></tr>
     <tr><td><div id="sxx1" style="width: 700px;border-bottom:1px #000 solid;height: 30px;font-family: verdana;font-size: 12px">Being payment of&nbsp;<?php  ?>&nbsp;Invoice.Nos :&nbsp-;<?php echo $docnumbers ?>&nbsp;&nbsp;&nbsp;</div></td></tr>
     <tr><td><div id="sxx2" style="width: 700px;border:none;height: 20px;font-family: verdana;font-size: 12px">CASH&nbsp; &nbsp;<?php echo "-&nbsp;Kshs".$amount; ?></div></td></tr>
 
     <tr><td><div id="sxx2" style="width: 700px;border:none;height: 30px;font-family: verdana;font-size: 12px">Allocation Account&nbsp;&nbsp;<?php echo $allocationacc[0]['accname']; ?></div></td></tr>
     
     <tr><td><div id="sxx2" style="width: 700px;border:none;height: 30px;font-family: verdana;font-size: 12px">Remarks&nbsp;&nbsp;<font style="font-weight: bold;font-style: italic;font-size: 15px"><?php echo $narration; ?></font></div></td></tr>
     <tr><td><div id="sxx2" style="width: 700px;border:none;height: 30px;font-family: verdana;font-size: 12px"><font style="float: left"><div style="height: 30px;width: 80px;float: left">Treasurer:</div><div style="width: 240px;float: right;border-bottom: 1px #000 solid;height: 30px"></div></font><font style="float: right"><div style="height: 30px;width: 100px;float: left">Collected By:</div><div style="width: 240px;float: right;border-bottom: 1px #000 solid;height: 30px"></div></font></div></td></tr>
     <tr><td><div id="sxx2" style="width: 700px;border:none;height: 30px;font-family: verdana;font-size: 12px"><font style="float: left"><div style="height: 30px;width: 80px;float: left">Secretary:</div><div style="width: 240px;float: right;border-bottom: 1px #000 solid;height: 30px"></div></font><font style="float: right"><div style="height: 30px;width: 100px;float: left">ID No:</div><div style="width: 240px;float: right;border-bottom: 1px #000 solid;height: 30px"></div></font></div></td></tr>
  <tr class="payconf"></tr> 
  <tr><td><div id="sxx2" style="width: 700px;border-top: 1px #000 solid;height: 20px;font-family: verdana;font-size: 10px"><?php echo "Printed by&nbsp;".$_SESSION['uname']."&nbsp;at&nbsp;".date('Y-m-d h:i:s'); ?></div> </td></tr> 
   
 </table>   
    
 
     
       
 
  
    <button id="vchrprint201" style="margin: 10px auto 0px 400px">print</button><button id="b_home" style="margin: 10px auto 0px 400px">return</button>
</body>
</html> 