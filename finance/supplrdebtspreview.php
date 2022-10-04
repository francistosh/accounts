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
 //if (isset($_POST['create'])) 
 //{ 
$ledgertype=  explode(",",$_GET['ledgertype']);
      $ledgeraccts=  explode(",",$_GET['ledgeraccts']);
      $dramount=  explode(",",$_GET['dramount']);
      $cramount=  explode(",",$_GET['cramount']);
      $ledgeraccts2 = $_GET['ledgeraccts'];
     $journaldate1=trim($_GET['journaldate']); 
     $journaldate= date('Y-m-d', strtotime($journaldate1));
     $journalrmks=trim($_GET['journalrmks']); 
	 $journaleno = trim($_GET['journalno']);
  $phptimedate = date("Y-m-d H:i:s");
   
  
  ?>
<div id="estate-area_det" style="background:white;height: 400px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid;border-radius: 3px  ">
     
 <table    style="text-align: left;margin: 0px;width:630px;" cellspacing="0" cellpadding="3" >
     <tr><td style="font-size: 10px;font-family:arial narrow;width:450px" colspan="2"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?></td></tr> 
     <tr><td style="font-size: 16px;font-weight: bold;text-align:left;line-height: 40px;border: #1269ab solid 2px; border-radius: 3px;">&nbsp;&nbsp;&nbsp;Ledger Journal No : <?php echo $journaleno ?></td> <td style="font-size:12px;font-weight: bold;text-align: right;" colspan="2">Date :    <?php echo date('d-m-Y',strtotime($journaldate1)); ?></td><br/></tr> 
  
 <tr><td style="height: 25px"><b>Ledger Account</b></td><td style="text-align: center;width: 100px"><b>Dr Amount</b></td><td style="text-align: center"><b>Cr Amount</b></td></tr>
         <?php
          $totalcr = 0; $totaldr = 0;
     for($t=0;$t<=count($ledgertype)-2;$t++){
         $ledgeracctsval = explode('|',$ledgeraccts[$t]);
          $accntid = $ledgeracctsval[0]; //get value of account id
         $tableid  = $ledgeracctsval[1];
          $typeid = $ledgeracctsval[2];
         $dramnt = $dramount[$t];
          $cramnt = $cramount[$t];
                 if($tableid == 'M'){
          $qr = $mumin->get_MuminHofNamesFromSabilno($accntid);  
          $accname = $accntid.' - '.$qr;
          
                 }else if ($tableid == 'E'){
            $qr = $mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id = '$accntid'"); 
          $accname =  $qr[0]['accname'];
        } elseif ($tableid == 'S') {
        $qr = $mumin->get_suplierName($accntid);  
          $accname = $qr; 
    }
                
          
          if($dramount[$t] != 0){
              $dramnt = number_format($dramount[$t],2);
          }else{
              $dramnt = '-';
          }
          if($cramount[$t] != 0){
              $cramnt = number_format($cramount[$t],2);
          }else{
              $cramnt = '-';
          }
         echo   "<tr><td >".$accname."</td><td style='padding-right: 30px; height:25px; text-align: center;'>".$dramnt."</td><td style='padding-right: 70px; text-align: center'>".$cramnt."</td></tr>"; 
     $totalcr = $cramount[$t] + $totalcr;
      $totaldr = $totaldr + $dramount[$t]   ;
          } 
     echo "<tr><td style='height:25px'><b>Total</b></td><td style='padding-right: 30px; text-align: center'><b>".number_format($totaldr,2)."</b></td><td style='padding-right: 70px; text-align: right'><b>".number_format($totalcr,2)."</b></td></tr>";

     echo "<tr><td style='height:30px'>Remarks: ".$journalrmks."</td></tr>";
     
     
     ?>
    

 </table>       
    <div style="margin-top: 20px;font-size: 10px;font-family: verdana"><?php echo "Printed by&nbsp;".$_SESSION['jname']."&nbsp;at&nbsp;".date('d-m-Y H:i:s'); ?></div>
</div>
     
  
    <table style="width: 100px;" class="ordinal"><tr><td><button id="bckbtn" onclick="javascript:history.back()">Back</button></td><td> <button id="jvprint201" style="margin: 10px auto 0px 400px">print</button></td></tr></table>
    
</body>
</html> 