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
}}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head runat="server">
<title>Credit Note</title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#FFCCCC; }

@media print
{ 
    footer {page-break-after: always;}
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

 
     $paymentdate=$_GET['paymentdate'];
     
     $amount=trim($_GET['amount']);
     
     $sabilno=trim($_GET['sabilno']);
     
     $docno=trim($_GET['docno']);
     
     $invoice=trim($_GET['invoice']);
      
     $remarks=trim($_GET['remarks']);
     
     $accounts=trim($_GET['accounts']);
      $sect = trim($_GET['sector']);
       
     $debtor=$_GET['debtor'];
     
     $acc=$mumin->getdbContent("SELECT * FROM incomeaccounts WHERE incacc LIKE '$accounts' LIMIT 1");
     
      
     
     if($sabilno){
      $payeename=$mumin->get_MuminHofNamesFromSabilno($sabilno);
      $ejno =$mumin->get_MuminHofEjnoFromSabilno($sabilno);
      $sabilno=$sabilno;
      //$deb='';
     }
     else{
        $deb=$mumin->getdbContent("SELECT * FROM debtors WHERE deptid LIKE '$id' AND dno LIKE '$debtor' LIMIT 1"); 
        
        $payeename=$deb[0]['debtorname'];
        $sabilno=$deb[0]['debTelephone'];
         $ejno='';
     }
     
         
    
 

 ?>



 <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print </span></span></span></button>
<a href="create_invoice.php?idaction=creditnote"><button class="sexybutton sexymedium sexyyellow"><span><span><span class="cancel">Close</span></span></span></button></a>
</div>

<br />
<div id="printableArea"  >
    <div>
<table style="margin: 0px;width:650px;height: 430px;" cellspacing="0" cellpadding="1" border="1px">
  <tr>
    <td>

	<table width="100%"  cellpadding="6"  style="padding-left:3%;">	
  <tr>
    <td align="center" colspan="2" style="font-size:20px;"><b>CREDIT NOTE</b><span style="float: right;font-size: 12px"><b><?php echo $_SESSION['dptname'] ?></b></span></td>
  </tr>
  <tr>
    <td align="left" style="font-size: 10px;font-family:arial narrow;width:600px">
	<p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?>
	</td>
    <td align="center">
	<img src="../assets/images/gold new logo.png" id="" height="100" width="100" />
	</td>
  </tr>
  <tr>
      <td align="left" colspan="2" style="padding-left: 5px"><span style='border:3px solid #4f6d81;font-size:18px;border-radius:2px;float: left'>&nbsp;&nbsp;Credit Note No:  <span style="">&nbsp;&nbsp;<b><?php echo $docno; ?> </b>&nbsp;&nbsp;</span></span>
          <span style="float:right;padding-right: 10px">Date: <?php echo date('jS-M-Y', strtotime($paymentdate)); ?></span> </td>
  </tr>
  
  <tr>
    <td align="left" colspan="2" style="font-size: 12px;text-align:left;line-height: 20px;padding-left: 5px" ><br>
        <fieldset style="border:1px solid #000000;width:400px;border-radius: 15px;">
	&nbsp;&nbsp;Account Debited :&nbsp;&nbsp;<b><?php echo " ".$payeename; ?></b><br>
            <span style="display: <?php if($debtor != 0){ echo 'none';}else {echo 'block';}?>">&nbsp;&nbsp;ITS No: <b style="text-transform: uppercase"><?php echo $ejno; ?></b></span>
            <span style="display: <?php if($debtor !=0){ echo 'none';}else {echo 'block';}?>">&nbsp;&nbsp;Sabil No: <b style="text-transform: uppercase"><?php echo $sabilno; ?></b></span>
        <span style="display: <?php if($debtor!=0){ echo 'block';}else {echo 'none';}?>">Tel: <b style="text-transform: uppercase"><?php echo $sabilno; ?></b></span>
        <span style="display: <?php if($debtor!=0){ echo 'block';}else {echo 'none';}?>">City/Mohalla: <b style="text-transform: uppercase"><?php echo $deb[0]['city']; ?></b></span></fieldset></td>
      
  </tr>
  
    <tr>
    <td align="left" style="border-top: 0.5px dotted #000;line-height: 25px" colspan="2">
        Account Credited :&nbsp;&nbsp;<b><?php echo " ".$acc[0]['accname']; ?></b>&nbsp;&nbsp;Invoice No: <?php echo $invoice;?></td>
    
  </tr>
  <tr>
<td align="left">Remarks: &nbsp;&nbsp; <?php echo $remarks; ?></td>
  </tr>
 
  <tr>
      <td align="left" colspan="2" style="text-align: right;"><b> &nbsp;&nbsp;Kshs <?php echo number_format($amount,2); ?>&nbsp;&nbsp </b></td>
    
  </tr>
  <tr>
    	<td style="font-style:italic;border-top: 0.5px dotted #000" colspan="2">
                <span style="float: left"><br>Issuer Sign :<br></br>....................................</span> 
                <span style="float: right"><br> Recipient Sign:<br></br>.................................... </span></td>
  </tr>
  <tr>
    <td align="left">
        <span style="font-size:x-small"><br></br><br>
	<?php echo $_SESSION['jname']; ?> &nbsp;&nbsp;
	<?php echo date("d/m/Y g:i:s A"); ?>
	</span>
	</td>
	<td> </td>
  </tr>
</table>
	</td>
  </tr>
</table>
</div>
    <footer></footer>
<br />

<table style="margin: 0px;width:650px;height: 430px;" cellspacing="0" cellpadding="1" border="1px">
  <tr>
    <td>

	<table width="100%"  cellpadding="5"  style="padding-left:3%;">	
  <tr>
    <td align="center" colspan="2" style="font-size:20px;"><b>CREDIT NOTE - Office Copy</b><span style="float: right;font-size: 12px"><b><?php echo $_SESSION['dptname'] ?></b></span></td>
  </tr>
  <tr>
    <td align="left" style="font-size: 10px;font-family:arial narrow;width:550px">
<p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?>
	</td>
    <td align="right">
	<img src="../assets/images/gold new logo.png" id="" height="100" width="100" />
	</td>
  </tr>
  <tr>
      <td align="left" colspan="2" style="padding-left: 5px"><span style='border:3px solid #4f6d81;font-size:18px;border-radius:2px'>&nbsp;&nbsp;Credit Note No:  <span style="">&nbsp;&nbsp;<b><?php echo $docno; ?> </b>&nbsp;&nbsp;</span></span>
    <span style="float:right;padding-right: 10px">Date: <?php echo date('jS-M-Y', strtotime($paymentdate)); ?></span> </td>
  </tr>
  
  <tr>
    <td align="left" colspan="2" style="font-size: 12px;text-align:left;line-height: 20px;padding-left: 5px"><br>
        <fieldset style="border:1px solid #000000;width:400px;border-radius: 15px;">
	&nbsp;&nbsp;Account Debited :&nbsp;&nbsp;<b><?php echo " ".$payeename; ?></b><br>
       <span style="display: <?php if($debtor != 0){ echo 'none';}else {echo 'block';}?>">&nbsp;&nbsp;ITS No: <b style="text-transform: uppercase"><?php echo $ejno; ?></b></span>
            <span style="display: <?php if($debtor !=0){ echo 'none';}else {echo 'block';}?>">&nbsp;&nbsp;Sabil No: <b style="text-transform: uppercase"><?php echo $sabilno; ?></b></span>
        <span style="display: <?php if($debtor!=0){ echo 'block';}else {echo 'none';}?>">Tel: <b style="text-transform: uppercase"><?php echo $sabilno; ?></b></span>
        <span style="display: <?php if($debtor!=0){ echo 'block';}else {echo 'none';}?>">City/Mohalla: <b style="text-transform: uppercase"><?php echo $deb[0]['city']; ?></b></span></fieldset></td>
  </tr>
  
  <tr>
<td align="left" style="border-top: 0.5px dotted #000;line-height: 25px" colspan="2">
	Account Credited :&nbsp;&nbsp;<b><?php echo " ".$acc[0]['accname']; ?></b>&nbsp;&nbsp;Invoice No: <?php echo $invoice;?></td>
    
  </tr> 

              <tr>
<td align="left">Remarks: &nbsp;&nbsp; <?php echo $remarks; ?></td>
  </tr>
              <tr>
      <td align="left" colspan="2" style="text-align: right;"><b> &nbsp;&nbsp;Kshs <?php echo number_format($amount,2); ?>&nbsp;&nbsp </b></td>
    
  </tr>
            <tr>
    	<td style="font-style:italic;border-top: 0.5px dotted #000" colspan="2"><br>
                <span style="float: left">Issuer Sign : ....................................</span>
                <span style="float: right"> Recipient Sign: .................................... </span></td>
  </tr>
  <tr>
    <td align="left">
        <span style="font-size:x-small"><br></br><br>
	<?php echo $_SESSION['jname']; ?> &nbsp;&nbsp;
	<?php echo date("d/m/Y g:i:s A"); ?>
	</span>
	</td>
	<td> </td>
  </tr>
</table>
	</td>
  </tr>
</table>

</div>	