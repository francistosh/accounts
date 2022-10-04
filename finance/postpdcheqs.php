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
if($priviledges[0]['receipts']!=1){
   
header("location: index.php");
}
    }
}
?>
<html>
   
<head>
<title>receipt print | Mombasa Jamaat  Information System</title>
    
 
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 <style type='text/css'>
     @media print
{ 
#rcptprintpd201  {display:none}
#bbutton {display:none}
}
 </style>
</head>
   
<body style="overflow-x: hidden;background: white">   
    <?php
if(isset($_POST['bankslctdpds']))
{
    $id=$_SESSION['dept_id'];
  $phptimedate = date("Y-m-d H:i:s"); //today's date and time
  $recp_date = date("Y-m-d");         //today's date 
 
 $user = $_SESSION['jname'];
 $localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); 
// For each checked cheque in the list, insert into receipt table
while(list($key, $val) = each($_POST['chqtobank'])) 
{
$recpno=sprintf('%06d',intval($mumin->refnos("recpno")));
//$recpno = '000012';
     $insertquery = $mumin->insertdbContent("INSERT INTO recptrans(est_id, rdate, amount, pmode, recpno, chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, sector, incacc, dno, ts, us, rev,invoicesettled,invoices,invceamnt)  
                                        SELECT est_id,'$recp_date' as rctdate,amount,pmode,'$recpno' as recpno,chqdet, chqno,chequedate, rmks, hofej, '', sabilno, '$localIP', incacc, dno, '$phptimedate', '$user', rev,invoicesettled,invoices,invceamnt FROM pdchqs WHERE tno = '$val'");
    
		if (!$insertquery) 
		{
		echo('<br />Error!: ' . mysql_error() . '<br />');
		die("<br /><a href='index.php'> Cancel </a><br />");
		}
                $sql = $mumin->updatedbContent("UPDATE pdchqs SET banked = '1' WHERE  tno = '$val'");
     $selectqry = $mumin->getdbContent("SELECT est_id,rdate,amount,pmode,'pd$recpno' as recpno,chqdet, chqno,chequedate, rmks, hofej, tno, sabilno, sector, incacc, dno, ts, us, rev,invoicesettled,invoices,invceamnt FROM pdchqs WHERE tno = '$val'");           
     for($j=0;$j<=count($selectqry)-1;$j++){ 
         $sabilno = $selectqry[$j]['sabilno'];
         $paymentdate = $selectqry[$j]['rdate'];
         $amount = $selectqry[$j]['amount'];
         $payment = $selectqry[$j]['rmks'];
         $chequedetails = $selectqry[$j]['chqdet'];
         $chequeno = $selectqry[$j]['chqno'];
         $chequedate = $selectqry[$j]['chequedate'];
         $incacc = $mumin->getincmename($selectqry[$j]['incacc']);
         
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
    }
?>
     <div id="estate-area_det" style="background:white;height: 440px;width:650px;padding:0px 10px 10px 10px;font-family: verdana;margin: 5px auto 5px auto;border: 2px #000 solid; border-radius: 3px; ">
   
 <table    style="text-align: left;margin: 0px; width: 600px;" cellspacing="0" cellpadding="3" >
<tr><td style="font-size: 10px;font-family:arial narrow;width:600px"><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> 
 <?php echo $_SESSION['details'];?></td><td style="text-align:right;width: 200px" ><img width="100" height="100" src="../assets/images/gold new logo.png"></img></td></tr>
 
 <tr><td style="font-size: 13px;font-weight: bold;text-align:left;line-height: 30px">Receipt No : <?php echo sprintf('%06d',intval($recpno)); ?></td> <td style="font-size:12px;font-weight: bold;text-align:right">Date :<?php echo date('d-m-Y', strtotime($recp_date)); ?></td><br/></tr> 
 <tr><td style="font-size: 12px;text-align:left;line-height: 20px">Receipt from <u style="line-height: 10px;text-transform:uppercase;font-weight: bold"><?php echo $names; ?>&nbsp;&nbsp;&nbsp;&nbsp;</u>
  the sum of shillings&nbsp;<i style="font-weight: bold;font-size: 13px;"><u><?php echo @ucwords($mumin->numWords($amount)); ?>&nbsp;</u></i>only</td></p></tr>
 <tr><td style="font-size:12px;line-height: 30px">Income Account : <b>&nbsp&nbsp;<?php echo  $incacc;?></b></td></tr>
 <tr><td style="font-size: 12px; line-height: 20px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?>" colspan="2" > Ejamaat No : <?php echo $ejno; ?></td></tr>
 <tr><td style="font-size: 12px; line-height: 20px; text-align: right; display: <?php echo $ejno; if ($sabilno != 'null' && $sabilno){ echo 'block';} else { echo 'none';} ?> " colspan="2">  Sabil  No : <?php echo strtoupper($sabilno); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
 <tr><td style="font-size: 12px; line-height: 30px" colspan="2">being payment of <b>&nbsp&nbsp;<?php echo $payment; ?></b></td></tr> 
 <tr><td style="font-size: 12px;line-height: 20px">Chq Details:&nbsp;<?php echo $chequedetails; ?></td></tr>
 <tr><td style="font-size: 12px;line-height: 20px">Chq. No :&nbsp;<?php echo $chequeno ;?> of &nbsp;KSHs <?php echo number_format($amount,2); ?></td></tr> 
 <tr><td style="font-size: 12px;line-height: 20px">Chq dated: &nbsp;<?php echo date('d-m-Y',  strtotime($chequedate)); ?></td></tr> 
 <tr><td style="font-size: 11px;text-align: right" colspan="2"><i>With thanks</i> &nbsp;_________________________</td></tr> 
  
 <tr><td style="font-size: 11px;text-align: left" colspan="2"><br><span style="float: left;"><?php echo "Created by&nbsp;".$user."&nbsp;on&nbsp;".date('d-m-Y',  strtotime($phptimedate)); ?></span></td></tr> 
 </table>      
        
</div>   
<?php
}?>
    <table style="width: 600px;" class="ordinal"><tr><td>&nbsp;&nbsp;<button style="margin: 10px auto 0px 50px" id="bbutton" onclick="history.back()">Back</button> <button id="rcptprintpd201" style="margin: 10px auto 0px 150px" onclick="window.print();">Print</button></td></tr></table>
<?php
                }
                else{
                     echo  "No Cheques Selected : <a href='pdcheqs_operation.php'>Click to Login</a>";
                }
?>


    

</body>
</html> 