<?php
 session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Accounts Summary </title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17; height:25px; }
.center{text-align: center;}
.left{text-align: left;}
a {
      text-decoration:none;
   }
    a:hover {text-decoration:underline;}
@media print
{ 
#printNot {display:none}

}
-->
</style>

<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
 ?>
<script>
$(function() {
    $("#prntst").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-print"
            },
            text: true
             
});
   $("#closest").button({  
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
					filename: "Income summary"
				});
                                	});

});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;;overflow-x: visible!important;">

<div align="center" id="printNot">
<button id="prntst" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closest" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="incomexcel" class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Export To Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
//$supplier=$_GET['supplier'];
 
include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();

$crdtotal = 0; $debitotal = 0;
echo '<div class="container">';
echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
?>
<?php
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" id="" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;"> Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.@$_SESSION['details'].'</span> </td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="center" font-size="2"><font size="3"><b>'.$_SESSION['dptname'].' - Accounts Summary</font></b> <br> From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></p>';


$grantotal = 0;
echo '<table id="report" class="table table-bordered exporttable">';
echo '<tr><th>#</th><th>12 Point Budget</th><th> Income </th><th class="right"> B/F</th><th class="right"> Invoiced</th><th class="right">Receipts</th><th class="right">Balance</th></tr>';
//echo '<tbody><tr><td colspan="6"><hr></td></tr>';
    $sumbf = 0; $suminvcd = 0; $sumrcpt = 0; $sumbal = 0;$numbering=1; 
      $wqry =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname,incomeaccounts.mainincgrp FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"); //Income accounts
           
      for($t=0;$t<count($wqry);$t++){
          $actname = $wqry[$t]['accname'];
          $twelvepoint = $wqry[$t]['mainincgrp'];
          $actid = $wqry[$t]['incacc'];
        if($to_date > '2016-12-31' ){ //opening balance-b/bf
           $qry37= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount  FROM invoice WHERE incacc = '$actid' AND estId LIKE '$id' AND opb = '1'  ) t1");
            $result37=$qry37[0]['bbfamnt'];
            }else{
                $result37 = '0';
            }  
           
$qry3= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount  FROM invoice WHERE incacc = '$actid' AND estId LIKE '$id'  AND idate < '$from_date' AND opb = '0' UNION 
               SELECT (SUM(amount))*-1 as amount  FROM recptrans WHERE  est_id LIKE '$id' AND rdate < '$from_date' AND incacc = '$actid') t1";
            $result3=$mumin->getdbContent($qry3);

           $balance_bf=$result3[0]['bbfamnt']+$result37;
           
        $qrinvoiced="SELECT incacc,rmks,ts,sum(IF(isinvce='1',amount,amount*-1))as invoiceamnt FROM invoice WHERE  estId LIKE '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND incacc = '$actid' AND opb = '0' "; 
        $qr2recpt="SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date'  AND est_id LIKE '$id' AND incacc = '$actid'";
                 $q=$mumin->getdbContent($qrinvoiced);
                 $qrcpt=$mumin->getdbContent($qr2recpt);
                 $balance = $balance_bf + $q[0]['invoiceamnt'] - $qrcpt[0]['receiptamount'];
                 
            echo "<tr style='height: 20px'><td>$numbering</td><td>$twelvepoint</td><td>".$actname."</td>  <td class='right'>".number_format($balance_bf,2)."</td><td class='right'>".number_format($q[0]['invoiceamnt'],2)."</td><td class='right'>".number_format($qrcpt[0]['receiptamount'],2)."</td><td class='right'>".number_format($balance,2)."</td> </tr>";
        //  $crdtotal = $credtamnt+$crdtotal;
            $sumbf += $balance_bf;
            $suminvcd += $q[0]['invoiceamnt'];
            $sumrcpt += $qrcpt[0]['receiptamount'];
            $sumbal += $balance;
            $numbering +=1;
        }
		            $qryz =$mumin->getdbContent("SELECT * FROM  incomeaccounts WHERE typ = 'G' "); //grant
                for($i=0;$i<count($qryz);$i++){
                    $amntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate  BETWEEN '$from_date' AND '$to_date' AND estId = '$id' AND crdtacc = '".$qryz[$i]['incacc']."')t5 ");
                    $amnt = $amntqry[0]['amount'];
                    if($amnt == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 
                 }
          echo '<tr style="height: 25px;'.$disply.'"><td>'.($numbering).'</td><td></td><td><a target="blank" href="grantdetails.php?fromdate='.$from_date.'&todate='.$to_date.'&incmgact='.$qryz[$i]['incacc'].'">'.$qryz[$i]['accname'].'</a></td>  <td class="right">-</td><td class="right">-</td><td class="right">'.number_format($amnt,2).'</td><td class="right">-</td> </tr>';          
          $grantotal = $grantotal + $amnt;   
         
                          }
        // $numbering +=1;
        
            
      
        
    echo'<tr style="height: 30px;border-bottom-style:double;"><td></td><td></td><td class="right"><b>Total</b></td><td class="right"><b>'.number_format($sumbf,2).'</b></td><td class="right"><b>'.number_format($suminvcd,2).'</b></td><td class="right"><b>'.number_format($sumrcpt+$grantotal,2).'</b></td><td class="right"><b>'.number_format($sumbal,2).'</b></td></tr>';


echo'</tbody></table><br>';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div>';
//echo '<div style="page-break-after:always"> </div>';
 
?>

</body>
</html>