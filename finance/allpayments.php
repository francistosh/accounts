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
<title>JIMS 2 | Payments</title> 

<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
<script>
$(function() {
    $("#prntbldgr").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-print"
            },
            text: true
             
});
   $("#closebldgr").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-close"
            },
            text: true
             
});
});
</script>
</head>
    
    <body style="background:#FFF;overflow-x: visible!important;">
          
 <div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

    
 <?php
        
 
          $sdate1=trim($_GET['sdate']);
          $sdate= date('Y-m-d',  strtotime($sdate1));
          $edate1=trim($_GET['edate']);
          $edate= date('Y-m-d',  strtotime($edate1));
          $est_id=$_SESSION['dept_id'];
          
          $costcenter=trim($_GET['costcenterid']);
            
          $expenseacc=trim($_GET['expenseacc']);
          
        if($costcenter==""){
            if ($expenseacc=="all"){
                
        
            $qr="SELECT payno,pdate,ts,pmode,chqno,expenseacc,supplier,costcentrid,rmks,amount FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' UNION
                 SELECT dexpno,dexpdate,ts,'Direct Expense' as pmode,chqno,dacc,'-' AS supplier,costcentrid,rmks,amount FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' AND estate_id = '$est_id' ORDER BY pdate,ts ";
            }
            else{
              
            $qr="SELECT payno,pdate,ts,pmode,chqno,expenseacc,supplier,costcentrid,rmks,amount FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' AND expenseacc = '$expenseacc' UNION
                 SELECT dexpno,dexpdate,ts,'Direct Expense' as pmode,chqno,dacc,'-' AS supplier,costcentrid,rmks,amount FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' AND estate_id = '$est_id' AND dacc = '$expenseacc' ORDER BY pdate,ts ";               
            }
            $costcentername= 'ALL';
          }
          else{
              if ($expenseacc=="all"){
                 
              $qr="SELECT payno,pdate,ts,pmode,chqno,expenseacc,supplier,costcentrid,rmks,amount FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' AND costcentrid = '$costcenter' UNION
                 SELECT dexpno,dexpdate,ts,'Direct Expense' as pmode,chqno,dacc,'-' AS supplier,costcentrid,rmks,amount FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' AND estate_id = '$est_id' AND costcentrid = '$costcenter' ORDER BY pdate,ts ";
  
              
              }
             else{
                
             $qr="SELECT payno,pdate,ts,pmode,chqno,expenseacc,supplier,costcentrid,rmks,amount FROM paytrans WHERE pdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' AND costcentrid = '$costcenter' AND expenseacc = '$expenseacc' UNION
                 SELECT dexpno,dexpdate,ts,'Direct Expense' as pmode,chqno,dacc,'-' AS supplier,costcentrid,rmks,amount FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' AND estate_id = '$est_id' AND costcentrid = '$costcenter' AND dacc = '$expenseacc' ORDER BY pdate,ts ";
              
             
             }
             
             $supplr=$mumin->getdbContent("SELECT centrename FROM department2 WHERE id = '$costcenter' LIMIT 1");
                  
                  $costcentername=$supplr[0]['centrename'];
          }
          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $sum=0;
          
 
      $disp = 'none';
 echo '<div class="container">';             
echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img src="../assets/images/gold new logo.jpg" style="float:right" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span></td>';
echo '<td><span style="float:right;font-size: 12px; padding-right: 30px"><b>'.$_SESSION['dptname'].'</b></span><div class="topic"><font size="3"><b>Payments</font></b> </div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="right" font-size="2">Cost Center: &nbsp; <b>'.$costcentername.'</b><br>Payment List From:&nbsp; <b>'.date('d-m-Y',  strtotime($sdate)).'</b>&nbsp; to &nbsp;<b>'.date('d-m-Y',  strtotime($edate)).'</b></p>';

echo '<table class="table table-bordered" id="treport">';
echo '<thead><tr><th><center>12 Point Budget</center></th><th> Doc. No.</th><th> Date.</th><th> Mode.</th><th> Chq No</th><th>Account</th><th>Supplier</th><th>Cost Center</th><th>Remarks</th><th style="text-align:right"> Amount</th></tr></thead>';
echo '<tbody>';
         
          //cheque
          
          
          for($i=0;$i<=count($data)-1;$i++){
              
                
                $expenseacc = $data[$i]['expenseacc'];
                $supplier = $data[$i]['supplier'];
                $costcentrid = $data[$i]['costcentrid'];
                $rmks = $data[$i]['rmks'];             

                  $expensename = $mumin->getexpnseactname($expenseacc);
                  if($supplier == '-'){
                      $suppliername = '-';
                  }else{
                      $suppliername = $mumin->get_suplierName($supplier);
                  }
                  $costcntrname = $mumin->getcostcentername($costcentrid);
              //$accid=$data[$i]['expacc'];
              
              //$deptq=$mumin->getdbContent("SELECT accname FROM expaccs WHERE id  LIKE  '$accid' LIMIT 1");
              
             // $dept=$deptq[0]['accname'];
             // ;
              
              echo"<tr><td></td><td >".$data[$i]['payno']."</td><td >".date('d-m-Y',  strtotime($data[$i]['pdate']))."</td><td>".$data[$i]['pmode']."</td><td >".$data[$i]['chqno']."</td><td>$expensename</td><td >".$suppliername."</td><td>".$costcntrname."</td><td >".$data[$i]['rmks']."</td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td></tr>";
 
              $numbering+=1;
              
              $sum+=floatval($data[$i]['amount']);  
              
              
          }
     

echo'<tr><td colspan="9" style="text-align:center"><b>Totals</b></td><td style="text-align:right;padding-right:10px" ><b>'.number_format($sum,2).'</b></td></tr>';

echo'</tbody></table><br />';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div> <br />';
echo '<div style="page-break-after:always"> </div>';
        
          
?>
    </body>
</html>