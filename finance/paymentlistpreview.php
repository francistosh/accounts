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
if($priviledges[0]['payments']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>  
<head>  
<title>Estates</title> 

<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
</head>
    
    <body style="background:#FFF;overflow-x: visible!important;">
          
 <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

    
 <?php
        
 
          $sdate1=trim($_GET['sdate']);
          $sdate= date('Y-m-d',  strtotime($sdate1));
          $edate1=trim($_GET['edate']);
          $edate= date('Y-m-d',  strtotime($edate1));
          $est_id=$_SESSION['dept_id'];
          
          $supplier=trim($_GET['paymentsupplier']);
            
          $bank=trim($_GET['dpt']);
          
        if($supplier=="ALL"){
            if ($bank=="ALL"){
                
        
            $qr="SELECT * FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' order by pdate ";
            

            }
            else{
              
            $qr="SELECT * FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' and bacc ='$bank' order by pdate";    
               
            }
            $supname= 'ALL';
          }
          else{
              if ($bank=="ALL"){
                 
             $qr="SELECT * FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND supplier = '$supplier' order by pdate";  
               
              
              }
             else{
                
             $qr="SELECT * FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND supplier = '$supplier' and bacc ='$bank' order by pdate";    
              
             
             }
             
             $supplr=$mumin->getdbContent("SELECT suppName FROM suppliers WHERE supplier = '$supplier' AND estId LIKE '$est_id' LIMIT 1");
                  
                  $supname=$supplr[0]['suppName'];
          }
          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $sum=0;
          
 
      $disp = 'none';
              
		echo '<div id="printableArea" class="container">';

		echo '<table width="100%">';   
		echo '<tr>';
		echo '<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
		echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span> </td></td>';
		echo '<td><div class="topic"><font size="3"><b>Payment Voucher List</font></b></div></td>';
		echo '</tr> ';
		echo '</table>';
		echo '<hr /><p align="right" font-size="2">SUPPLIER: &nbsp; <b>'.$supname.'</b><br>Payment List From:&nbsp; <b>'.date('d-m-Y',  strtotime($sdate)).'</b>&nbsp; to &nbsp;<b>'.date('d-m-Y',  strtotime($edate)).'</b></p>'; 

		echo '<table id="treport" style="width:100%;" cellpading=4 class="table table-bordered">';
		echo '<thead><tr><th> Doc. No.</th><th> Date.</th><th> Mode.</th><th> Chq No</th><th>Account</th><th>Supplier</th><th>Cost Center</th><th>Remarks</th><th style="text-align:right"> Amount</th></tr></thead>';
		echo '<tbody><tr><td colspan="9"></td></tr>';
         
          //cheque
          
          
          for($i=0;$i<=count($data)-1;$i++){
              
              
               
              
                  $costid = $data[$i]['costcentrid'];
                 
                  $sbid=$data[$i]['supplier'];
                  
                  $supp=$mumin->getdbContent("SELECT suppName FROM suppliers WHERE supplier = '$sbid' AND estId LIKE '$est_id' LIMIT 1");
                  
                  $payer=$supp[0]['suppName'];
                  
                  $acct=$mumin->getdbContent("SELECT acname FROM bankaccounts WHERE bacc = '".$data[$i]['bacc']."' AND deptid LIKE '$est_id'");
                  
                  $acctname=$acct[0]['acname'];
                  
                  $costcntrname = $mumin->getcostcentername($costid);
              //$accid=$data[$i]['expacc'];
              
              //$deptq=$mumin->getdbContent("SELECT accname FROM expaccs WHERE id  LIKE  '$accid' LIMIT 1");
              
             // $dept=$deptq[0]['accname'];
             // ;
              
              echo"<tr><td >".$data[$i]['payno']."</td><td >".date('d-m-Y',  strtotime($data[$i]['pdate']))."</td><td>".$data[$i]['pmode']."</td><td >".$data[$i]['chqno']."</td><td>$acctname</td><td >".$payer ."</td><td>".$costcntrname."</td><td >".$data[$i]['rmks']."</td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td></tr>";
 
              $numbering+=1;
              
              $sum+=floatval($data[$i]['amount']);  
              
              
          }
     
			 echo '<td colspan=9><hr /></td>';
			echo'<tr><td colspan="8" style="text-align:center"><b>Totals</b></td><td style="text-align:right;padding-right:10px" ><b>'.number_format($sum,2).'</b></td></tr>';
			echo '<td colspan=9></td>';
		echo'</tbody></table><br />';


		//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
		echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
		echo '<div style="page-break-after:always"> </div>';
        
          
?>
    </body>
</html>