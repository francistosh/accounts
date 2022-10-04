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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>JIMS 2 | Receipts</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }

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
 $("#incomexcel").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});
   $("#incomexcel").click(function(e){
             var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Accounts summary"
				});
                                	});
});
</script>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
           <div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="incomexcel"class="sexybutton sexymedium sexyyellow" id="invcelstoxcel"><span><span><span class="cancel">Excel</span></span></span></button>
           </div>
<br />
<?php
        
  
          $sdate1=trim($_GET['sdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $edate1=trim($_GET['edate']);
          $edate = date('Y-m-d', strtotime($edate1));
          $est_id=$_SESSION['dept_id'];
          
          $pmd=trim($_GET['pmd']);
            
          $dpt=trim($_GET['dpt']);
          
        if($pmd=="ALL" && $dpt =="ALL" ){
        
            $qr="SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND est_id LIKE '$est_id'  ORDER BY rdate,recpno";
       
          }
          
         else if($pmd=="ALL" && $dpt!="ALL"){
              
            $qr="SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND est_id LIKE '$est_id' AND incacc = '$dpt'  ORDER BY rdate,recpno ";
           
          }
          
           else if($pmd!="ALL" && $dpt =="ALL"){
                
            $qr="SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND est_id LIKE '$est_id' AND pmode LIKE '$pmd'  ORDER BY rdate,recpno";
              
          }
          
          else{
               
             $qr="SELECT * FROM recptrans WHERE rdate BETWEEN '$sdate' AND '$edate' AND est_id LIKE '$est_id' AND incacc = '$dpt' AND pmode LIKE '$pmd'  ORDER BY rdate,recpno ";  
               
             
          }
                $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $sum=0;
          $sum1=0;
                       
          if($dpt!='ALL'){
              $dept1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$dpt'");
              @$deptname=$dept1[0]['accname'];
          }
          else{
              $deptname="All";
          }
    
      $disp = 'none';

          echo '<div class="container">'; 
          echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span> </td>';
echo'<td><span style="float:right;font-size: 12px; padding-right: 40px"><b>'.$_SESSION['dptname'].'</b></span><div class="topic"><font size="3"><b>Receipt List</font></b> </div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="right" font-size="2"></b> Payment Mode: &nbsp; <b>'.$pmd.'</b> &nbsp;&nbsp;&nbsp; Income Account: &nbsp; <b>'.$deptname.'</b>
<br>&nbsp; Receipt List From:&nbsp; <b>'.$sdate1.'</b>&nbsp; to &nbsp;<b>'.$edate1.'</b></p>'; 
echo '<table id="treport" style="width:100%" cellpading=4 class="table table-bordered exporttable">';
echo '<thead><tr><th colspan="2" style="width:70px"> Date</th> <th colspan="2">Recp. No.</th><th colspan="2">Name</th><th colspan="2"> Sabil No</th><th colspan="2">Mode</th><th colspan="2">Chq No.</th><th>Remarks</th><th>Acct</th><th style="text-align:right">Amount&nbsp;&nbsp;</th></tr></thead>';
//echo '<tbody><tr><td colspan="16"><hr></td></tr>';
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
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td colspan='2'>".$data[$i]['recpno']."</td><td colspan='2'>".$payer ."</td><td colspan='2'>".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$data[$i]['pmode']."</td><td colspan='2'></td><td>".$data[$i]['rmks']."</td><td>$dept</td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['amount'];
              
              }
          }
          // echo '<td colspan=16><hr /></td>';
         echo"<tr><th colspan='10'></th><th colspan='4'>CASH TOTALS</th><th style='text-align:right;padding-right:10px'>". number_format($sum,2)."</th></tr>";    
        
 echo '<td colspan=16></td>';
          
         for($i=0;$i<=count($data)-1;$i++){
              
              
              if($data[$i]['chqno']){
              
              if($data[$i]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                  
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$accid'  LIMIT 1"); 
              
              @$dept=$deptq[0]['accname'];
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td colspan='2'>".$data[$i]['recpno']."</td><td colspan='2'>".$payer ."</td><td colspan='2'>".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$data[$i]['pmode']."</td><td colspan='2'>".$data[$i]['chqno']." : &nbsp".$data[$i]['chqdet']."</td><td>".$data[$i]['rmks']."</td><td>$dept</td><td style='text-align:right;padding-right:10px'>".number_format($data[$i]['amount'],2)."</td></tr>";
              
              $numbering+=1;
              
              $sum1+=$data[$i]['amount'];
              
              }
          }
         // echo '<td colspan=16><hr /></td>';
         echo"<tr><th colspan='10'></th><th colspan='4'>CHEQUE TOTALS</th><th style='text-align:right;padding-right:10px'>". number_format($sum1,2)."</th></tr>";    
        echo "<td colspan=16></td>";
          
          
          //cheque
          

echo'<tr><th colspan=10></th><th colspan=4><b>GRAND TOTALS</b></th><th style="text-align:right;padding-right:10px"><b>'. number_format($sum1+$sum,2).'</b></th></tr>';
echo'</tbody></table>';


echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div> <br />';
echo '<div style="page-break-after:always"> </div>';
         
         
          
         
         
         
         
         
         
         
  echo"</table>";
          
?>
    </body>
</html>