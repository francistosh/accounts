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

if($priviledges[0]['receipts']!=1){
   
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
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
    
    
<script>
    
    
$(function() {
    

  
   $("#rcpprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    $("#rcptcancelrint201").button({
            icons: {
                
               primary: "ui-icon-gear"
            }
        });
    
     $("#backbtn").button({
            icons: {
                
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
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 <style type='text/css'>
     @media print
{ 
#rcptcancelrint201  {display:none}
#backbtn {display:none}
}
 </style>
</head>
   
<body style="overflow-x: hidden;background: white">   
  
   
 <?php
  
     $paymentdate=trim($_GET['paymentdate']);
     
     
     $mode=trim($_GET['mode']);
     $amount=trim($_GET['amount']);
     
     $sabilno=trim($_GET['ejno']);
     $recpno=trim($_GET['recpno']);
     $expacc=trim($_GET['incmeacts']);
     //$acc=trim($_GET['acc']);
     $payment=trim($_GET['payment']);
          
     $debtor=trim($_GET['debtor']);
     $reprint=trim($_GET['reprint']);
     $rcpts = trim($_GET['rcpts']);
     $rcptus = trim($_GET['rcptus']);
    // $recpno=$mumin->refnos("recpno");  
     if ($sabilno != 'null' && $sabilno){
     $ejno=$mumin->get_MuminHofEjnoFromSabilno($sabilno);
     $debt=$ejno;
     $names=$mumin->get_MuminNames($ejno);
     } 
     else{
         $ejno=' ';
         $debt=$debtor;  
   
         $n="SELECT * FROM debtors WHERE dno LIKE '$debtor' AND deptid LIKE '$id' LIMIT 1";
         
         $data=$mumin->getdbContent($n);
        
         $names= $data[0]['debtorname'];
    }
        //$n1="SELECT accname FROM income_accounts WHERE incacc IN ($expacc)";
         
         //$data1=$mumin->getdbContent($n1);
        
        // $accname= $data1[0]['accname'];

        $dispi = 'none'; 
 
    if($mode=='CASH'){
 ?>
    
 
        
<div id="estate-area_det" style="background:white;height: 440px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid; border-radius: 3px; ">
     
 <table    style="text-align: left;margin: 0px; width: 600px; " cellspacing="0" cellpadding="3" >
     <tr><td style="font-size: 10px;font-family:arial narrow;width:600px"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> <span style="float: right; margin-right: 60px"><b><?php echo $_SESSION['dptname'] ?></b></span></p> 
 <?php echo $_SESSION['details'];?></td><td style="text-align:right;width: 200px" ><img width="100" height="100" src="../assets/images/gold new logo.png"></img></td></tr> 
     <tr><td style="font-size: 13px;font-weight: bold;text-align:left;line-height: 30px">Receipt No : <?php echo sprintf('%06d',intval($recpno)); ?></td> <td style="font-size:12px;font-weight: bold;text-align:right">Date :<?php echo date('d-m-Y', strtotime($paymentdate)); ?></td><br/></tr> 

 <tr><td style="font-size: 12px;text-align:left;line-height: 20px">Receipt from <u style="line-height: 10px;text-transform:uppercase;font-weight: bold"><?php echo $names; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u>
 the sum of shillings&nbsp;<i style="font-weight: bold;font-size: 13px"><u><?php echo @ucwords($mumin->numWords($amount)); ?>&nbsp;</u></i>only </td></p></tr>
 <tr><td style="font-size:12px;line-height: 30px">Income Account : <b>&nbsp&nbsp;<?php echo  $expacc;?></b></td></tr>
 <tr><td style="font-size: 12px; line-height: 30px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?>" colspan="2" > Ejamaat No : <?php echo $ejno; ?></td></tr>
 <tr><td style="font-size: 12px; line-height: 30px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?> " colspan="2">  Sabil  No : <?php echo strtoupper($sabilno); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
 <tr><td style="font-size: 12px; line-height: 30px" cellpadding="3">being payment of :&nbsp;<?php echo $payment;?></td></tr>
 <tr><td style="font-size: 12px; line-height: 30px;font-weight: bold">CASH PAYMENT : &nbsp;&nbsp;Kshs <?php echo number_format($amount,2); ?> </td></tr> 
  
 <tr><td style="font-size: 11px;text-align: right" colspan="2"><i>With thanks<i/>&nbsp;_________________________</td></tr> 
 <tr><td style="font-size: 11px;text-align: right;line-height: 40px"> </td><td> <div class="signature"></div></td></tr>

 </table>       
    <div style="margin-top: 30px;font-size: 10px;font-family: verdana"><span style="float:right"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;&nbsp;".date('d-m-Y H:i:s'); ?></span><span style="float: left;display:<?php if($reprint== '0'){echo 'none';}else { echo 'block';}?>"><?php echo "Created by&nbsp;".$rcptus."&nbsp;&nbsp;".date('d-m-Y',  strtotime($rcpts)); ?></span></div>
</div>
     
  <?php
    }
    else{
        $chequedetails=trim($_GET['chequedetails']);
        $chequeno=trim($_GET['chequeno']);
        $chequedate=trim($_GET['chequedate']);
      ?>
        
    <div id="estate-area_det" style="background:white;height: 440px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid; border-radius: 3px; ">
   
 <table    style="text-align: left;margin: 0px; width: 600px;" cellspacing="0" cellpadding="3" >
<tr><td style="font-size: 10px;font-family:arial narrow;width:600px"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?></td><td style="text-align:right;width: 200px" ><img width="100" height="100" src="../assets/images/gold new logo.png"></img></td></tr>
 
 <tr><td style="font-size: 13px;font-weight: bold;text-align:left;line-height: 30px">Receipt No : <?php echo sprintf('%06d',intval($recpno)); ?></td> <td style="font-size:12px;font-weight: bold;text-align:right">Date :<?php echo date('d-m-Y', strtotime($paymentdate)); ?></td><br/></tr> 
 <tr><td style="font-size: 12px;text-align:left;line-height: 20px">Receipt from <u style="line-height: 10px;text-transform:uppercase;font-weight: bold"><?php echo $names; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u>
  the sum of shillings&nbsp;<i style="font-weight: bold;font-size: 13px;"><u><?php echo @ucwords($mumin->numWords($amount)); ?>&nbsp;</u></i>only</td></p></tr>
 <tr><td style="font-size:12px;line-height: 30px">Income Account : <b>&nbsp&nbsp;<?php echo  $expacc;?></b></td></tr>
 <tr><td style="font-size: 12px; line-height: 20px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?>" colspan="2" > Ejamaat No : <?php echo $ejno; ?></td></tr>
 <tr><td style="font-size: 12px; line-height: 20px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?> " colspan="2">  Sabil  No : <?php echo strtoupper($sabilno); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
 <tr><td style="font-size: 12px; line-height: 30px" colspan="2">being payment of <b>&nbsp&nbsp;<?php echo $payment; ?></b></td></tr> 
 <tr><td style="font-size: 12px;line-height: 20px">Chq Details:&nbsp;<?php echo $chequedetails; ?></td></tr>
 <tr><td style="font-size: 12px;line-height: 20px">Chq. No :&nbsp;<?php echo $chequeno ;?> of &nbsp;KSHs <?php echo number_format($amount,2); ?></td></tr> 
 <tr><td style="font-size: 12px;line-height: 20px">Chq dated: &nbsp;<?php echo date('d-m-Y',  strtotime($chequedate)); ?></td></tr> 
 <tr><td style="font-size: 11px;text-align: right" colspan="2"><i>With thanks</i> &nbsp;_________________________</td></tr> 
  
 <tr><td style="font-size: 11px;text-align: left" colspan="2"><br></br><span style="float:right"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?> </span><span style="float: left;display:<?php if($reprint== '0'){echo 'none';}else { echo 'block';}?>"><?php echo "Created by&nbsp;".$rcptus."&nbsp;on&nbsp;".date('d-m-Y',  strtotime($rcpts)); ?></span></td></tr> 
 </table>      
        
</div>
    
    
 <?php
    }
  ?>
    <table style="width: 600px;" class="ordinal"><tr><td>&nbsp;&nbsp;<button id="rcptcancelrint201" style="margin: 10px auto 0px 150px;display: <?php if($reprint== '1'){echo 'none';}else{'block';}?>">Close</button><button style="margin: 10px auto 0px 50px" id="backbtn">Back</button> <button id="rcpprint201" style="margin: 10px auto 0px 150px">print</button></td></tr></table>
</body>
</html> 