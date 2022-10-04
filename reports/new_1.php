<!DOCTYPE html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="keywords" content="Anjuman-e-Burhani,Dawoodi,Bohra,Community,Mombasa,jamaat">
		<meta name="description" content="A Non-Profit Corporation administering & managing the affairs of the Dawoodi Bohra Community of Mombasa">
		<link rel="icon" href="images/favicon.ico">
		
	   <title>Anjuman-e-Burhani | MSA</title>
<?php
session_start();
if(!isset($_SESSION['jmsloggedIn'])){
  
    echo  "You must Login to see this page : <a href='../index.php'>Click to Login</a>";
       
}
include '../finance/operations/Mumin.php';

$mumin=new Mumin();
//  $id=$_SESSION['dept_id'];
?>
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/reports.css" rel="stylesheet">
	
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
	
<style type="text/css">
@media print
{ 
#printNot {display:none}

}
</style>	
	
	</head>
	<body>
	<div align="center" id="printNot">
		<button id ="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Statement</span></span></span></button>
		<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
	</div>
	<div class="container">
	<div id="printableArea">
		<img src="images/logo.png" class="logo">
                <div class="col-md-10 reports">
				<?php
                                $dateTime = new DateTime();
                                   $nummonths = $dateTime->format('m');
                                ?>                                
		
				<table class="table table-bordered">
					<tr>
					  <th class="th" colspan="2"><center>Department wise</center></th>
					  <th class="th" colspan="3"><center>Analysis Section</center></th>
					  <th class="th" colspan="2"><center>Budget</center></th>
                                          <th class="th" colspan="1"><center>Actual</center></th>
					</tr> 
					<tr>
					  <th colspan="2"><center><b>Income Account</b></center></th>
					  <th>12point</th>
					  <th style="min-width:80px"><?php echo date('Y')-1; ?> Actual</th>
					  <th style="min-width:80px"><?php echo date('Y'); ?> Actual</th>
					  <th style="min-width:80px"><?php echo date('Y'); ?> Yearly</th>
					  <th style="min-width:80px"><?php echo date('Y'); ?> Monthly</th>
					  <th><center><?php echo date('F'); ?></center></th>
					</tr>  
					<tr>
						<th class="width">Admin</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
									
                                  <?php
                                  $dataquery = $mumin->getdbContent("SELECT * FROM `incomeaccounts` WHERE incacc IN (SELECT incacc FROM incomeactmgnt WHERE deptid = '25') AND typ = 'I'");
                                  $yearbfore =date('Y')-1;
                                  $currentyr = date('Y');
                                  $totalyearbfr = 0;    $totalcurrentyr = 0;
                                  $totalbudgetyr = 0; $subtotalincme = 0;
                                  $t=1;
                                  for($l=0;$l<= count($dataquery)-1;$l++){
                                      $qr2recpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$yearbfore'");
                                      $recptcurntyr=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$currentyr'");
                                      $qrbudgtcurntyr=$mumin->getdbContent("SELECT incacc,rmks,ts,sum(IF(isinvce='1',amount,amount*-1))as invoiceamnt FROM invoice WHERE  estId LIKE '25' AND YEAR(idate) = '$currentyr' AND incacc = '".$dataquery[$l]['incacc']."' AND opb = '0'");
                                      echo '<tr>
				  <th>'.$t++.'</th>
                                  <th>'.$dataquery[$l]['accname'].'</th>
                                   <td>'.$dataquery[$l]['mainincgrp'].'</td>
				  <td>'.number_format($qr2recpt[0]['receiptamount'],2).'</td>
				  <td>'.number_format($recptcurntyr[0]['receiptamount'],2).'</td>
				  <td>'.number_format($qrbudgtcurntyr[0]['invoiceamnt'],2).'</td>
				  <td>'.number_format($qrbudgtcurntyr[0]['invoiceamnt']/12,2).'</td>';
                                      $totalyearbfr = $totalyearbfr + $qr2recpt[0]['receiptamount'];
                                      $totalcurrentyr =$totalcurrentyr + $recptcurntyr[0]['receiptamount'];
                                      $totalbudgetyr = $totalbudgetyr + $qrbudgtcurntyr[0]['invoiceamnt'];
                                       
                                  
                                      $date = date('m');
                                      $qr2monthlyrecpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$currentyr' AND MONTH(rdate)='$date'");
                                      echo '<td>'.number_format($qr2monthlyrecpt[0]['receiptamount'],2).'</td>';
                                           $subtotalincme += $qr2monthlyrecpt[0]['receiptamount'];
                                
                                  }
                                  ?>
                                        				<tr>
				  <td></td>
				  <th><b>Total Income</b></th>
				  <td></td>
				  <td><b><?php echo number_format($totalyearbfr,2); ?></b></td>
				  <td><b><?php echo number_format($totalcurrentyr,2); ?></b></td>
				  <td><b><?php echo number_format($totalbudgetyr,2);?></b></td>  <!-- Last year budget -->
				  <td><b><?php echo number_format($totalbudgetyr/12,2);?></b></td>  <!-- Current year budget -->
				  <?php
                                
                                  $date = date('m');
                                 
                                      $qr2monthlyrecpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND YEAR(rdate)='$currentyr' AND MONTH(rdate)='$date'");
                                      echo '<td><b>'.number_format($qr2monthlyrecpt[0]['receiptamount'],2).'</b></td>';
                                     
                                   ?>
                                 
				</tr> 
					<tr>
						<th colspan="2">Cost Center</th>
						<th class="th">12point</th>
					  <th class="th" style="min-width:80px"><?php echo date('Y')-1; ?> Actual</th>
					  <th class="th" style="min-width:80px"><?php echo date('Y'); ?> Actual</th>
					  <th class="th" style="min-width:80px"><?php echo date('Y'); ?> Yearly</th>
					  <th class="th" style="min-width:80px"><?php echo date('Y'); ?> Monthly</th>
					  <th class="th" style="min-width:80px"><center><?php echo date('F'); ?></center></th>
					</tr>
                                <?php 
                                $ccgrps = $mumin->getdbContent("SELECT id,name FROM costcentre_groups ORDER BY priority");
                                for($t=0;$t<=count($ccgrps)-1;$t++){
                                    echo '<tr><th>'.$ccgrps[$t]['name'].'</th><th></th><td></td><td></td><td></td><td></td><td></td>';
                                      echo '<td></td>';
                                  echo '</tr>';
                                 $mainccgrps = $mumin->getdbContent("SELECT * FROM `department2` WHERE id IN (SELECT costcentrid from costcentrmgnt WHERE deptid = '25') AND cgroup = '".$ccgrps[$t]['id']."' ORDER BY centrename ");   
                                   $j=1;
                                 for($h=0;$h<=count($mainccgrps)-1;$h++){
                                $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND YEAR(bdate) ='$yearbfore' AND costcentrid = '".$mainccgrps[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  YEAR(dexpdate)='$yearbfore' AND estate_id= '25' AND costcentrid = '".$mainccgrps[$h]['id']."' )t7 GROUP BY expacc )T6 ");
                                 $expenseamntcurntyr = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND YEAR(bdate) ='$currentyr' AND costcentrid = '".$mainccgrps[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  YEAR(dexpdate)='$currentyr' AND estate_id= '25' AND costcentrid = '".$mainccgrps[$h]['id']."' )t7 GROUP BY expacc )T6 ");

                                             echo '<tr><th>'.$j++.'</th><th>'.$mainccgrps[$h]['centrename'].'</th><td>'.$mainccgrps[$h]['code'].'</td><td>'.@$expenseamnt[0]['debitamnt'].'</td><td>'.@number_format($expenseamntcurntyr[0]['debitamnt'],2).'</td><td>-</td><td>-</td>';

                                $date = date('m');
                                $monthqry = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND MONTH(bdate) ='$date' AND costcentrid = '".$mainccgrps[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  MONTH(dexpdate)='$date' AND estate_id= '25' AND costcentrid = '".$mainccgrps[$h]['id']."' )t7 )T6 ");

                                      echo '<td>'.@number_format($monthqry[0]['debitamnt'],2).'</td>';
                                      
                                   }
                                   
                                 echo '</tr>';
                                }
                                
                                ?>				</table>
                <div style="page-break-after: always;"></div>
				<table class="table table-bordered">
					<tr>
					  <th class="th" colspan="2"><center>Department wise</center></th>
					  <th class="th" colspan="<?php echo $nummonths;?>"><center>Actual for the year</center></th>
				  <th class="th" rowspan="2"><center>Total Amount</center></th>
					</tr> 
					<tr>
					  <th colspan="2"><center><b>Income Account</b></center></th>
					  <?php
                                  
                                   
                                    for ($i = 1; $i < $nummonths; $i++) {
                                      echo '<th>'.date('F', mktime(0,0,0,$i)).'</th>';
                                      
                                    }
                                     echo '<th>'.date('F').'</th>';
                                   
                                      ?>

					</tr>  
					<tr>
						<th class="width">Admin</th>
						<td></td>
						<td></td>
						<td></td>
						
						
					</tr>
					<?php
                                         $o=1;
                                  for($l=0;$l<= count($dataquery)-1;$l++){
                                      $qr2recpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$yearbfore'");
                                      $recptcurntyr=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$currentyr'");
                                      $qrbudgtcurntyr=$mumin->getdbContent("SELECT incacc,rmks,ts,sum(IF(isinvce='1',amount,amount*-1))as invoiceamnt FROM invoice WHERE  estId LIKE '25' AND YEAR(idate) = '$currentyr' AND incacc = '".$dataquery[$l]['incacc']."' AND opb = '0'");
                                     
                                      echo '<tr>
				  <th>'.$o++.'</th>
                                  <th>'.$dataquery[$l]['accname'].'</th>';
                                   
                                      $totalyearbfr = $totalyearbfr + $qr2recpt[0]['receiptamount'];
                                      $totalcurrentyr =$totalcurrentyr + $recptcurntyr[0]['receiptamount'];
                                      $totalbudgetyr = $totalbudgetyr + $qrbudgtcurntyr[0]['invoiceamnt'];
                                       $incmewisetotal = 0; 
                                  for ($k = 1; $k <= $nummonths; $k++) {
                                      $qr2monthlyrecpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND incacc = '".$dataquery[$l]['incacc']."' AND YEAR(rdate)='$currentyr' AND MONTH(rdate)='$k'");
                                      echo '<td>'.number_format($qr2monthlyrecpt[0]['receiptamount'],2).'</td>';
                                      $incmewisetotal =$incmewisetotal + $qr2monthlyrecpt[0]['receiptamount'];
                                       $subtotalincme += $qr2monthlyrecpt[0]['receiptamount'];
                                  } 
                                 
                                  echo 
				'<td><b>'.number_format($incmewisetotal,2).'</b></td></tr>';
                                  }
                                  ?>
                                        				<tr>
				  <td></td>
				  <th><b>Total Income</b></th>
				   <?php
                                  $allmonthlyincmesubtotl = 0;
                                  for ($k = 1; $k <= $nummonths; $k++) {
                                      $qr2monthlyrecpt=$mumin->getdbContent("SELECT rmks,ts,sum(amount) as receiptamount FROM recptrans WHERE  est_id LIKE '25' AND YEAR(rdate)='$currentyr' AND MONTH(rdate)='$k'");
                                      echo '<td><b>'.number_format($qr2monthlyrecpt[0]['receiptamount'],2).'</b></td>';
                                      $allmonthlyincmesubtotl += $qr2monthlyrecpt[0]['receiptamount'];
                                  } ?>
                                  <td><b><?php echo number_format($allmonthlyincmesubtotl,2); ?></b></td>
				</tr> 
					<tr>
						<th colspan="2">Cost Center</th>
						<?php
                                  
                                   
                                    for ($i = 1; $i < $nummonths; $i++) {
                                      echo '<th>'.date('F', mktime(0,0,0,$i)).'</th>';
                                      
                                    }
                                     echo '<th>'.date('F').'</th>';
                                   
                                      ?>
                                    <td></td>
					</tr>
                                        <?php
                                        $ccgrp = $mumin->getdbContent("SELECT id,name FROM costcentre_groups ORDER BY priority");
                                for($t=0;$t<=count($ccgrp)-1;$t++){
                                    echo '<tr><th>'.$ccgrp[$t]['name'].'</th><th></th><td></td>';
                                      echo '<td></td>';
                                  echo '</tr>';
                                 $mainccgrp = $mumin->getdbContent("SELECT * FROM `department2` WHERE id IN (SELECT costcentrid from costcentrmgnt WHERE deptid = '25') AND cgroup = '".$ccgrps[$t]['id']."' ORDER BY centrename ");   
                                   $j=1;
                                   for($h=0;$h<=count($mainccgrp)-1;$h++){
                                $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND YEAR(bdate) ='$yearbfore' AND costcentrid = '".$mainccgrp[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  YEAR(dexpdate)='$yearbfore' AND estate_id= '25' AND costcentrid = '".$mainccgrp[$h]['id']."' )t7 GROUP BY expacc )T6 ");
                                 $expenseamntcurntyr = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND YEAR(bdate) ='$currentyr' AND costcentrid = '".$mainccgrp[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  YEAR(dexpdate)='$currentyr' AND estate_id= '25' AND costcentrid = '".$mainccgrp[$h]['id']."' )t7 GROUP BY expacc )T6 ");

                                             echo '<tr><td></td><th>'.$mainccgrp[$h]['centrename'].'</th>';
                                  $expenstotal = 0;
                                             for ($k = 1; $k <= $nummonths; $k++) {
                                $monthqry = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '25' AND MONTH(bdate) ='$k' AND costcentrid = '".$mainccgrp[$h]['id']."' AND opb = '0' UNION
                                 SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  MONTH(dexpdate)='$k' AND estate_id= '25' AND costcentrid = '".$mainccgrp[$h]['id']."' )t7 )T6 ");

                                      echo '<td>'.@number_format($monthqry[0]['debitamnt'],2).'</td>';
                                      $expenstotal += @$monthqry[0]['debitamnt'];
                                  }
                                  echo '<td><b>'.number_format($expenstotal,2).'</b></td></tr>';
                                }
                                 echo '</tr>';}?>
				</table>
				</div>
				
				<footer class="footer">
			<br>
			<b>© JIMS <?php echo date('Y');?> - All Rights Reserved.</b>
		</footer>
	</div>
	</div>
	
	</body>	
</html>	