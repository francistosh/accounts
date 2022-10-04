<?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];
//die($id);
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['directexp']!=1){
   
header("location: index.php");

}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Direct Expense | Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
?>
    
    
<script>
    
    
$(function() {
    

  
   $("#jvprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    $("#bckbtn").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-arrowthick-1-w" 
            }
        });
    $("#rcpclose201").button({
            icons: {
                
                secondary: "ui-icon-arrowthick-1-e" 
            }
        });
        
         
      
    });
 
</script>
<style type="text/css">
    @media print
{ 
#jvprint201 {display:none}
#bckbtn {display: none}
}
    
</style>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;background: white">   
  
   
 <?php
              $date=trim($_GET['dexpdate']);
            
              $amount=trim($_GET['dxamount']);
             
              $expensacc=trim($_GET['expensacc']);
              
              $crdtacc=trim($_GET['crdtacc']);
              
              //$type=trim($_GET['jvtype']);
              
              $dexpvno=trim($_GET['dexpvno']);
              
              $est_id=$_SESSION['dept_id'];
            
               $rmks=trim($_GET['remks']);
              $ckdte=trim($_GET['ckdte']);
               $chkno=trim($_GET['chkno']);
                $chkdetails= trim($_GET['chkdetails']);
                $cstcntreid = trim($_GET['cstcntreid']);
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
               
              

        $qr="SELECT * FROM bankaccounts WHERE bacc = '$crdtacc' "; 
        
        $dt=$mumin->getdbContent($qr);
        
        $qr1="SELECT * FROM expnseaccs WHERE id = '$expensacc' LIMIT 1";
        
        $dt1=$mumin->getdbContent($qr1);
        $qrcntr=$mumin->getdbContent("SELECT * FROM department2 WHERE id = '$cstcntreid' LIMIT 1");

        $crdtactname=$dt[0]['acname'];
         
        $debitacctname=$dt1[0]['accname'];
        
        if($chkno==""){
        $display = 'none';
        $display2 = 'block';
         } elseif ($chkno!=="") {
         $display = 'block';
         $display2 = 'none';
        }
 ?>
       
<div id="estate-area_det" style="background:white;height: 420px;width:630px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid;border-radius: 3px  ">
     
 <table    style="text-align: left;margin: 0px;width:600px;" cellspacing="0" cellpadding="3" >
<tr><td style="font-size: 10px;font-family:arial narrow;width:450px"> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> 
 <?php echo $_SESSION['details'];?></td><td><span style="float:right;font-size: 10px; padding-right: 30px"><b><?php echo $_SESSION['dptname'] ?></b></span></td></tr> 
     <tr><td style="font-size: 14px;font-weight: bold;text-align:left;line-height: 40px;border: 2px solid #1269ab;border-radius: 3px;" >Direct Expense Voucher : <?php echo $dexpvno ?></td> <td style="font-size:12px;font-weight: bold;text-align: right;">Date :<?php echo date('d-m-Y',strtotime($date)); ?></td><br/></tr> 
  
 <tr><td style="font-size: 12px;text-align:left;line-height: 20px">Debit Account:&nbsp;&nbsp;<u style="line-height: 10px;text-transform:capitalize;font-weight: bold"><?php echo $debitacctname; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
 
  <tr><td style="font-size: 12px;text-align:left;line-height: 30px">Credit Account :&nbsp;&nbsp;<u style="line-height: 10px;text-transform:capitalize;font-weight: bold"><?php echo $crdtactname; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
 
  <tr><td style="font-size: 12px; display: <?php echo "$display2";?>">the sum of shillings&nbsp;<i style="font-weight: bold;font-size: 13px">&nbsp;<u><?php echo ucwords($mumin->numWords($amount)); ?>&nbsp;</u>&nbsp;</i>only </td></tr>
   
  <tr><td style="font-size: 12px;height: 30px">Being payment of :&nbsp;<?php echo $rmks; ?></td></tr>
  
  <tr><td style="font-size: 12px;height: 30px">Cost Center :&nbsp;<b><?php echo $qrcntr[0]['centrename']; ?></b></td></tr>
  
  <tr><td style="font-size: 12px; border-top: dotted #000 1px; display: <?php echo "$display"; ?>" colspan="2">Chq. No &nbsp;<?php echo "$chkno";?> of &nbsp;<?php echo "$ckdte";?> </td><td style="border-top: dotted #000 1px;"></td></tr>
  
  <tr><td style="font-size: 12px; text-align: right;line-height: 30px" colspan="2"><b>Kshs <?php echo number_format($amount,2); ?>&nbsp;&nbsp;</b></td></tr> 
 <!--<tr><td style="font-size: 14px;text-align: right"><i>With thanks<i/></td></tr> -->
 <tr><td style="font-size: 12px;line-height: 40px"  colspan="2">Passed by:&nbsp;&nbsp;_________________ <?php echo str_repeat('&nbsp', 20); ?>Received by:&nbsp;&nbsp; ________________</td></tr>
 
 
 
 
  
 </table>       
    <div style="margin-top: 15px;font-size: 10px;font-family: verdana"><?php echo "Printed by&nbsp;".$us."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?></div>
</div>
     
  
    <table style="width: 100px;" class="ordinal"><tr><td><button id="bckbtn" onclick="javascript:history.back()">Back</button></td><td> <button id="jvprint201" style="margin: 10px auto 0px 400px">print</button></td></tr></table>
    
</body>
</html> 