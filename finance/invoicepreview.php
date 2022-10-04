<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include './operations/Mumin.php';

$mumin=new Mumin();
$userid = $_SESSION['acctusrid'];
$id=$_SESSION['dept_id'];
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['invoices']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>invoice print | Jamaat  Information System</title>
    
 
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
    
    $("#rcpcancelrint201").button({
            icons: {
                
                secondary: "ui-icon-arrowthick-1-w" 
            }
        });
        
         
      
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;background: white">   
  
   
 <?php
  
 
     $paymentdate=$_GET['paymentdate'];
     $amount=trim($_GET['amount']);
     $sabilno=trim($_GET['sabilno']);
     $invoice=trim($_GET['docno']);
     $remarks=trim($_GET['remarks']);
     $acctname=trim($_GET['acctname']);
     $sectornm=trim($_GET['sector']);
     $subacct=trim($_GET['subacct']);
        
     $debtor=$_GET['debtor'];
     
     $dispname=$_GET['dispname'];
     $telno=$_GET['tel'];
      $city=$_GET['city'];
      $reprint = trim($_GET['reprint']);
     //actn='reprint'
    if($sabilno){ 
    $ejno =$mumin->get_MuminHofEjnoFromSabilno($sabilno);
    }
    else {
        $ejno = ' ';
    }
    $q="SELECT * FROM  invoice WHERE invno LIKE '$invoice' AND estId LIKE '$id' AND isinvce = '1' LIMIT 1";
              $data=$mumin->getdbContent($q);
              $datecrtd = $data[0]['ts'];
              $crtuser =  $data[0]['us'];
     $subin = $mumin->getdbContent("SELECT accname FROM subincomeaccs WHERE id = '$subacct' ");   
     @$subincmename = $subin[0]['accname'];
  ?>
        
 <div id="estate-area_det" style="background:white;height: 430px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 1px #000 solid; border-radius: 3px ">
     
 <table style="text-align: left;margin: 0px;width:630px" cellspacing="0" cellpadding="1" >
 <tr><td style="text-align: center;font-weight: bold;font-size: 20px" colspan="2">INVOICE <span style="float: right;font-size: 12px"><b><?php echo $_SESSION['dptname'] ?></b></span></td></tr>
<tr><td style="font-size: 10px;font-family:arial narrow;width:600px"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?></td><td style="text-align:right;width: 250px" ><img width="100" height="100" src="../assets/images/gold new logo.png"></img></td></tr> 
 <tr><td style="font-size: 12px;font-weight: bold;text-align:left;line-height: 30px">Invoice No : <?php echo "<span style='border:3px solid #4f6d81;font-size:15px;border-radius:2px'>&nbsp&nbsp$invoice&nbsp&nbsp</span>" ?></td><td>Date : &nbsp;<?php echo date('d-m-Y', strtotime($paymentdate)); ?> </td><br/></tr> 
 
 <tr><td style="font-size: 12px;text-align:left;line-height: 20px"><br><fieldset style="border:1px solid #000000;width:420px;border-radius: 15px;"><span><b>&nbsp;To:</b> &nbsp;<u style="line-height: 10px;text-transform:uppercase"><?php echo $dispname; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u></span>
 <span colspan="2" style="font-size: 12px;font-weight: bold; display : <?php if($debtor){echo 'none';}else {echo 'block';}?>"> &nbsp;ITS No : <?php echo $ejno; ?></span>
 <span colspan="2" style="font-size: 12px;font-weight: bold; display : <?php if($debtor){echo 'block';}else {echo 'none';}?>"> &nbsp;Tel : <?php echo $telno; ?></span>
 <span style="font-size: 12px;font-weight: bold;display : <?php if($debtor){echo 'none';}else {echo 'block';}?>"> &nbsp;Sabil  No : <?php echo "<span style='text-transform: uppercase'>$sabilno</span>"; ?></span>
         <span colspan="2" style="font-size: 12px;font-weight: bold; display : <?php if($debtor){echo 'block';}else {echo 'none';}?>"> &nbsp;City/Mohalla : <?php echo $city; ?></span></fieldset></td></tr>
  <tr><td colspan="2" style="font-size: 12px;line-height: 30px;border-top: 0.5px dotted #000000;">Amount: <i style="font-weight: bold;font-size: 13px"><u><?php echo @ucwords($mumin->numWords($amount)); ?>&nbsp;</u></i></td></tr> 
 <tr><td  style="font-size: 12px;line-height: 30px;">Allocation Account: <b>&nbsp;<?php if($acctname) {echo "$acctname &nbsp".":&nbsp $subincmename";} else{ echo $dispname;    
 } ?></b></td></tr>
 
 <tr><td style="font-size: 12px;">being pledge for <b>&nbsp;<?php echo $remarks; ?></b></td></tr> 
 
 <tr><td style="font-size: 12px;text-align: right;border-bottom: 0.5px dotted #000000;" colspan="2">Kshs <?php echo number_format($amount,2); ?>&nbsp;<br>&nbsp;</td></tr> 
 <tr>
     <td colspan="2"><div style="margin-top: 15px;font-size: 8px;font-family: verdana"><span style="float:left;"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;&nbsp;".date('d-m-Y h:i a'); ?></span><span style="float: right;display:<?php if($reprint== '0'){echo 'none';}else { echo 'block';}?>"><?php echo "Transacted by&nbsp;".$crtuser."&nbsp;&nbsp;".date('d-m-Y h:i a',  strtotime($datecrtd)); ?></span></div>
 
</td>
 </tr>
 </table>      
              
 </div>
       
 
  
    <div id="printtoolbar" style="margin: 10px auto 0px auto;width: 400px;height: 30px;background: transparent;font-size: 10px;font-family: verdana"><button id="rcpprint201">print</button><button id="rcpcancelrint201">Go back</button></div>
</body>
</html> 