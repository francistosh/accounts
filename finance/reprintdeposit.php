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
if($priviledges[0]['deposits']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Deposit</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:80%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
treport{width:100%}
}
-->
</style>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.location.href = 'deposit.php?type=printdeposit'"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php
        
  
          $sdate1=trim($_GET['sdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $est_id=$_SESSION['dept_id'];
          $acct = trim($_GET['acct']);
                    
              if($acct == "all"){
                  $actqry = "";
              }
              else{
                  $actqry = 'AND incacc = '.$acct.'';
              }
          $numbering=1;
          
          $sum=0;
          $sum1=0;
    
      $disp = 'none';
          echo '<div id="printableArea" style="width: 900px;margin-left:auto;margin-right: auto">';

echo '<table width="80%"  border="0" style="margin-right: auto; margin-left: auto">';   
echo '<tr>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:10px">'.$_SESSION['details'].'</span> </td><td><span style="font-size:12px;font-weight:normal; float:right;">'.$_SESSION['dptname'].'</span></td>';
echo '</tr> ';
echo '</table>';
echo '<div style="text-align: center"><font size="3"><b>Depositing Monies List on '.$sdate1.' </font></b> </div>';

echo '<div>';
echo '<hr />';
echo '</div><script> $("#bnkacct2").val('.$acct.');</script>';
echo '<hr />';
echo '<br />';

echo '<table id="treport" style="width:100%;margin-right:auto; margin-left:auto;font-size:12px;" cellpading=4>';
echo '<thead><tr><th colspan="2">R. Date</th> <th> Recp. No.</th><th>Sabil No</th> <th colspan="2">Name</th> <th colspan="2"> Incme Acct</th> <th colspan="2">Chq No.</th><th>Chq Details</th><th style="text-align:right">Amount&nbsp;&nbsp;</th></tr></thead>';
          
$qr="SELECT * FROM recptrans WHERE date(depots) = '$sdate' AND est_id LIKE '$est_id' AND isdeposited <> '0' $actqry  ORDER BY rdate";
        $bankqry = $mumin->getdbContent("SELECT distinct(bacc) FROM recptrans WHERE date(depots) = '$sdate' AND est_id LIKE '$est_id' AND isdeposited <> '0' $actqry "); 
          
        $banknamei = @$mumin->getbankname($bankqry[0]['bacc']) ;
        echo '<tr><td colspan="12"><b>'.$banknamei.'</b></td></tr>';
        $data=$mumin->getdbContent($qr);
              
          //cheque
          
          for($i=0;$i<=count($data)-1;$i++){
              
              
              if(!$data[$i]['chqno']){
              
              if($data[$i]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                  
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$accid' LIMIT 1");
              
              @$dept=$deptq[0]['accname'];
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td id='rcpnodpst".$i."'>".$data[$i]['recpno']."</td><td>".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$payer ."</td><td colspan='2'>$dept</td><td></td><td colspan='2'></td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['amount'];
              
              }
          }
     
         echo"<tr><th colspan='10' style='text-align:right;'>Cash Totals</th><th colspan='2' style='text-align:right;padding-right:10px'>". number_format($sum,2)."</th></tr>";    
        
         for($i=0;$i<=count($data)-1;$i++){
              
              
              if($data[$i]['chqno']){
              
              if($data[$i]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                  
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid = '$est_id' LIMIT 1");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$accid'  LIMIT 1"); 
              
              @$dept=$deptq[0]['accname'];
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td id='rcpnodpst".$i."'>".$data[$i]['recpno']."</td><td >".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$payer ."</td><td colspan='2'>$dept</td><td>".$data[$i]['chqno']." :</td><td colspan='2'> &nbsp".$data[$i]['chqdet']."</td><td style='text-align:right;padding-right:10px'>".number_format($data[$i]['amount'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum1+=$data[$i]['amount'];
              
              }
          }
         
         // echo '<tr><td colspan="12"></td></tr>';
         echo"<tr><th colspan='10' style='border-top: 1px solid;text-align:right;'>Cheque Totals</th><th style='text-align:right;padding-right:10px' colspan='2'>". number_format($sum1,2)."</th></tr>";    
      

  
echo '<td colspan=12 style="border: 1px"></td>';
echo'<tr><td colspan=10 style="text-align: right;font-size:14px"><b>'.$banknamei.' Total</b></td><td style="text-align:right;padding-right:10px" colspan="2"><b>'. number_format($sum1+$sum,2).'</b></td></tr>';
echo '<td colspan=16><hr />Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</td>';
echo'</tbody></table><br />';
echo '<div style="page-break-after:always"> </div>';
         
     
  echo"</table>";
          
?>
    </body>
</html>