<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['jv']!=1){
   
header("location: index.php");
}
}
}
date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>J.V | Jamaat  Information System</title>
    
 
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
              $date=trim($_GET['jvdate']);
            
              $amount=trim($_GET['jvamount']);
             
              $fromjv=trim($_GET['jvfrom']);
              
              $tojv=trim($_GET['jvto']);
              
              $crdtype=trim($_GET['crdtype']);
              $dbtype=trim($_GET['dbtype']);
              $jvno=trim($_GET['jvno']);
              $ckdte = trim($_GET['ckdte']);
              $chkno = trim($_GET['chkno']);
              $chkdetails = trim($_GET['chkdetails']);
              $est_id=$_SESSION['dept_id'];
            
               $jvrmks=trim($_GET['jvrmks']);
              
              $ts=date('Y-m-d h:i:s');
              
              $us=$_SESSION['jname'];
              
               
                
             if($crdtype=='1' && $dbtype=='0' ){
        $qr1="SELECT * FROM bankaccounts WHERE bacc = '$tojv' AND deptid = '$est_id' LIMIT 1";
        $qr="SELECT incacc,accname,typ FROM incomeaccounts WHERE (typ = 'G' OR typ = 'L') AND incacc= '$fromjv'"; 
        
        $dt1=$mumin->getdbContent($qr1);
        $dt=$mumin->getdbContent($qr);
        $from=$dt[0]['accname'];
         $to=$dt1[0]['acname'].' : '.$dt1[0]['acno'];
                     }
            elseif ($crdtype=='0' && $dbtype=='1') {
            $qr="SELECT incacc,accname,typ FROM incomeaccounts WHERE (typ = 'G' OR typ = 'L') AND incacc= '$tojv'"; 
            $qr1="SELECT * FROM bankaccounts WHERE bacc = '$fromjv' AND deptid = '$est_id' LIMIT 1";
          $dt=$mumin->getdbContent($qr);
           $dt1=$mumin->getdbContent($qr1);
        $to=$dt[0]['accname']; 
        $from=$dt1[0]['acname'].' : '.$dt1[0]['acno'];
            }         
        elseif ($crdtype == $dbtype) {
            $qr="SELECT * FROM bankaccounts WHERE bacc = '$tojv' AND deptid = '$est_id' LIMIT 1"; 
            $qr1="SELECT * FROM bankaccounts WHERE bacc = '$fromjv' AND deptid = '$est_id' LIMIT 1";
          $dt=$mumin->getdbContent($qr);
           $dt1=$mumin->getdbContent($qr1);
        $to=$dt[0]['acname']; 
        $from=$dt1[0]['acname'].' : '.$dt1[0]['acno'];
            }
         
 ?>
       
<div id="estate-area_det" style="background:white;height: 440px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid;border-radius: 3px  ">
     
 <table    style="text-align: left;margin: 0px;width:630px;" cellspacing="0" cellpadding="3" >
<tr><td style="font-size: 10px;font-family:arial narrow;width:450px"><i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i>
 <?php echo $_SESSION['details'];?></td><td><span style="float: right; margin-right: 60px"><?php echo $_SESSION['dptname'] ?></span></td></tr> 
     <tr><td style="font-size: 14px;font-weight: bold;text-align:left;line-height: 40px;border: #1269ab solid 2px; border-radius: 3px;">&nbsp;&nbsp;&nbsp;Journal Voucher No : <?php echo $jvno ?></td> <td style="font-size:12px;font-weight: bold;text-align: right;">Date :<?php echo date('d-m-Y',strtotime($date)); ?></td><br/></tr> 
 <tr><td style="font-size: 12px;text-align:left;line-height: 30px">From Account&nbsp;:&nbsp;<u style="line-height: 10px;text-transform:capitalize;font-weight: bold"><?php echo $to; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
 
 <tr><td style="font-size: 12px;text-align:left;line-height: 20px">To Account&nbsp;:&nbsp;<u style="line-height: 10px;text-transform:capitalize;font-weight: bold"><?php echo $from; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></td></tr>
 
 
 <tr><td style="font-size: 12px; line-height: 18px"><br>the sum of shillings&nbsp;<i style="font-weight: bold;font-size: 12px">&nbsp;<u><?php echo ucwords($mumin->numWords($amount)); ?>&nbsp;</u>&nbsp;</i>only </td></tr>
 <?php if($chkdetails){?>
 <tr><td style="font-size: 12px;"><br><b>Chq No </b>&nbsp;:&nbsp;<?php echo $chkno.' - '.$chkdetails .'  - '.date('d-m-Y',  strtotime($ckdte)) ; ?>&nbsp;&nbsp; </td></tr>
 <?php } ?>
 <tr><td style="font-size: 12px;line-height: 30px" colspan="2">Remarks:&nbsp;<?php echo $jvrmks; ?></td></tr>
  
 <tr><td style="font-size: 12px; text-align: right;line-height: 30px" colspan="2"><b>KSHs <?php echo number_format($amount,2); ?>&nbsp;&nbsp;</b></td></tr> 
 <!--<tr><td style="font-size: 14px;text-align: right"><i>With thanks<i/></td></tr> -->
 <tr><td style="font-size: 12px;line-height: 40px"  colspan="2">Secretary:&nbsp;&nbsp;_________________ <?php echo str_repeat('&nbsp', 20); ?>Received by:&nbsp;&nbsp; ________________</td></tr>
 <tr><td style="font-size: 12px;line-height: 40px"  colspan="2">Treasurer:&nbsp;&nbsp;_________________ <?php echo str_repeat('&nbsp', 30); ?>ID No:&nbsp;&nbsp; ________________</td></tr>
 
 </table>       
    <span style="margin-top: 20px;font-size: 10px;font-family: verdana"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?></span>
</div>
     
  
    <table style="width: 100px;" class="ordinal"><tr><td><button id="bckbtn" onclick="javascript:history.back()">Back</button></td><td> <button id="jvprint201" style="margin: 10px auto 0px 400px">print</button></td></tr></table>
    
</body>
</html> 