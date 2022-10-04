<?php
 session_start();
 if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supplier Summary </title>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
.centr{ text-align: center; }
#report th { background-color:#957c17; height: 25px; }
#report td{height: 25px; }
 a {
      text-decoration:none;
   }
   a:hover {text-decoration:underline;}
@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
 a {
      text-decoration:none;
   }
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
   $("#suppcsvfile").button({  
            icons: {
               primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});
   $("#suppcsvfile").click(function(e){
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Supplier Accounts"
				});
                                	});
});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;overflow-x: visible!important;">

<div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();" id="prntst"><span><span><span class="print">Print Statement</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();" id="closest"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" id="suppcsvfile"><span><span><span class="cancel">Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['fromdate'];
$from_date = date('Y-m-d',  strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d',  strtotime($to_date1));
 
include 'operations/Mumin.php';

$id=@$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();


$wqw =$mumin->getdbContent("SELECT * FROM  suppliers  WHERE estId LIKE '$id' ORDER BY suppName");

$totalamount = 0; $totalcarrfrd = 0; $totalbalance= 0 ; $balancetotal = 0; $totalbilled = 0; $totalpd =0;

      $disp = 'none';
  

echo '<div id="printableArea">';
echo '<div class="container1">';
echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img src="../assets/images/gold new logo.jpg" id="" height="100px"  /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;"> Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.@$_SESSION['details'].'</span> </td>';
echo '<td><span style="float:right;font-size: 10px; padding-right: 30px"><b>'.@$_SESSION['dptname'].'</b></span><div class="topic"><font size="3"><b>Supplier Summary</font></b> </div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="right" font-size="2">From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></p>';

echo '<table id="lists" style="width:100%" cellpading=4 class="exporttable table table-bordered">';
echo '<thead style="height: 25px;"><tr><th> Name </th> <th class="centr">  Brought Forward</th> <th class="centr">Billed</th><th class="centr">Paid</th><th class="right"> Balance&nbsp&nbsp&nbsp</th></tr></thead>';
echo '<tbody>';
        
              for($j=0;$j<count($wqw);$j++){
                 //$sumqry = array();
                  
				  $sumq = $mumin->getdbContent("SELECT SUM(amount) as bbf from (SELECT sum(IF(isinvce ='1', amount,(amount)*-1)) as amount,id FROM bills where estate_id='$id' AND supplier = '".$wqw[$j]['supplier']."' and bdate < '$from_date' UNION 
						 SELECT (sum(cramount) - sum(dramount)) as amount,tno FROM bad_debtsupplrs WHERE acc = '".$wqw[$j]['supplier']."' AND deptid = '$id' AND jdate < '$from_date' AND  tbl = 'S'  UNION		
                                                        SELECT (SUM(amount))*-1 as amount,tno  FROM paytrans WHERE supplier = '".$wqw[$j]['supplier']."' AND estId = '$id' AND pdate < '$from_date') T2");
                     // $sumq =$mumin->getdbContent("SELECT sum(amount-pdamount) as bbf FROM  estate_bills  WHERE estate_id LIKE '$id' and supplier = '".$wqw[$j]['supplier']."' AND bdate < '$from_date'");
		$sumqry =$mumin->getdbContent("SELECT SUM(amount) as amount,supplier FROM (SELECT SUM(if(isinvce='1',amount,0))- sum(if(isinvce='0',amount,0)) as amount,supplier,id FROM bills WHERE estate_id='$id' AND supplier = '".$wqw[$j]['supplier']."' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
                     SELECT (sum(cramount) - sum(dramount)) as amount,acc,tno FROM bad_debtsupplrs WHERE acc = '".$wqw[$j]['supplier']."' AND deptid = '$id' AND jdate BETWEEN  '$from_date' AND '$to_date' AND  tbl = 'S' UNION
                    SELECT SUM(IF(amount<0,-1*amount,0)) - SUM(IF(amount>0,amount,0)) as amount,supplier,tno FROM paytrans WHERE estId='$id' AND supplier= '".$wqw[$j]['supplier']."' AND pdate BETWEEN '$from_date' AND '$to_date')t6;");

		  $sumbilled =$mumin->getdbContent("SELECT sum(amount) as amount,supplier from (SELECT SUM(if(isinvce='1',amount,0))- sum(if(isinvce='0',amount,0)) as amount,supplier,id FROM bills WHERE estate_id='$id' AND supplier = '".$wqw[$j]['supplier']."' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
                                                    SELECT (sum(cramount) - sum(dramount)) as amount,acc,tno FROM bad_debtsupplrs WHERE acc = '".$wqw[$j]['supplier']."' AND deptid = '$id' AND jdate BETWEEN  '$from_date' AND '$to_date' AND  tbl = 'S')T7");	
                  $sumpaid =$mumin->getdbContent("SELECT sum(amount) as amount,supplier,tno FROM paytrans WHERE estId='$id' AND supplier= '".$wqw[$j]['supplier']."' AND pdate BETWEEN '$from_date' AND '$to_date'");
                  
                  
                  $carrfwrd = $sumq[0]['bbf'] + $sumqry[0]['amount'];
                  $balancetotal = $balancetotal+ $sumq[0]['bbf'];
                  $totalamount = $totalamount + $sumqry[0]['amount'];
                  $totalbilled += $sumbilled[0]['amount'];
                  $totalpd += $sumpaid[0]['amount'];
                  $totalcarrfrd = $totalcarrfrd + $carrfwrd;
                    $suppid = $wqw[$j]['supplier'];
                                  if (($sumq[0]['bbf'] == '' || $sumq[0]['bbf'] == '0.00' ) && ($sumbilled[0]['amount'] == '' || $sumbilled[0]['amount'] == '0.00' ) && ($sumpaid[0]['amount'] == '' || $sumpaid[0]['amount'] == '0.00') ){
                  // echo blank
              }else{
                  echo "<tr><td><a target='blank' href='suppstatement.php?startdate=$from_date&enddate=$to_date&supplier=$suppid&type=1&expnseacct=all'>".$wqw[$j]['suppName']."</a></td><td class='right' style='padding-right:10px'>".  number_format($sumq[0]['bbf'],2)."</td><td class='right' style='padding-right:10px'>".  number_format($sumbilled[0]['amount'],2)."</td><td class='right' style='padding-right:10px'>".  number_format($sumpaid[0]['amount'],2)."</td><td class='right' style='padding-right:10px'> ".number_format($carrfwrd,2)."</td></tr>";
              }
              
              }
           
echo '<td colspan=6></td>';
echo'<tr><td><b>Totals</b></td><td class="right"><b>'.number_format($balancetotal,2).'</b></td><td class="right"><b>'.number_format($totalbilled,2).'</b></td><td class="right"><b>'.number_format($totalpd,2).'</b></td><td class="right"><b>'.number_format($totalcarrfrd,2).'</b></td></tr>';
echo '<td colspan=6><hr /></td>';
echo'</tbody></table><br />';


echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
 
?>

</body>
</html>