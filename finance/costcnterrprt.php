<?php
 session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cost Center Report</title>
 
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

 ?>

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
 
$("#costcntrexcel").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});

 $("#costcntrexcel").click(function(e){
       // alert('test');
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Cost Centre Report"
				});
                                	});

 
    }); 
 
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;;overflow-x: visible!important;">

<div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="costcntrexcel" class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Export to Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
$costcenter=$_GET['costcenter'];
$type=$_GET['type'];


include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();

$crdtotal = 0; $debitotal = 0;

if($costcenter=='789'){
    $costscenters = $mumin->getdbContent("SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$id' AND department2.id IN (SELECT costcentrid FROM bills WHERE bdate BETWEEN '$from_date' AND '$to_date' UNION SELECT costcentrid FROM directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date') GROUP BY department2.id ORDER BY centrename");
    
}
else{
     $costscenters = $mumin->getdbContent("SELECT department2.centrename,department2.id as cntrid FROM department2 WHERE department2.id = '$costcenter' LIMIT 1"); 
     
     
}
if($type =='1'){
	echo'<div class="container1">';
echo '<div id="printableArea">';

echo '<table width="100%"  border="0">';   
echo '<tr>';
//echo '<td> <img src="../assets/images/gold new logo.jpg" id="" height="80" width="120" /></img> </td>';
echo '<td width="70%" style="text-align: center;">';?>
<b><i><font size="5">Anjuman-e-Burhani</font></i></b>
<?php

echo '</td>';
echo '</tr> ';
echo '</table>';
echo '<div align="center"><font size="2"><b>Cost Center Summary Report</font></b> </div>';
echo '<div align="center"><font size="2"><b>'.$_SESSION['dptname'].' Department</font></b> </div>';
//echo '<hr />';
echo '<div><table id="report">';
//echo '<tr><td>Account No. &nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b></b></td><td align=right>Ejamaat/Entity No.&nbsp;&nbsp; &nbsp; Tel: &nbsp;</td></tr>';
echo '<tr><td style="text-align: center;"> From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></td><td></td></tr>'; 
echo '</table></div>';
echo '<hr />';
//echo '<br />';
$grantotal = 0; $totalxpenses = 0;
echo '<table id="report" class="table table-condensed exporttable">';
echo '<tr><th>Details</th><th style="text-align: right"> Amount </th></tr>';
//echo '<tbody><tr style="border: 1px dotted"><td colspan="2" ></td></tr>';
    for($t=0;$t<count($costscenters);$t++){
        $costcntretotal = 0;
    echo '<tr><td colspan="2" style="background: grey"><b>'.$costscenters[$t]['centrename'].'</b></td></tr>';    
         
          $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,expenseacc,accname FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND costcentrid = '".$costscenters[$t]['cntrid']."' AND expnseaccs.type <> 'A' UNION
                                                SELECT sum(amount) as debitamnt,jid,expacc,accname FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' AND costcentrid = '".$costscenters[$t]['cntrid']."' AND expnseaccs.type <> 'A' )t7 GROUP BY expacc )T6 GROUP BY expenseacc ORDER BY accname");
           for($i=0;$i<count($expenseamnt);$i++){
          $debitamt= $expenseamnt[$i]['debitamnt'];
          $expensename = $expenseamnt[$i]['accname'];
          if($debitamt == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 }
                 echo "<tr style='height: 20px;".$disply."'><td style='color: blue'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$expensename."</td><td class='right' style='padding-right: 10px'>".number_format($debitamt,2)."</td> </tr>";
          $costcntretotal = $debitamt + $costcntretotal;
          
           }
           $totalxpenses +=$costcntretotal;
           echo '<td colspan=2 style="border-bottom: 1px solid; height: 5px"></td>';
            echo "<tr><td style='text-align: center'><b>".$costscenters[$t]['centrename']." Total</b></td><td class='right' style='padding-right: 10px'><b>".number_format($costcntretotal,2)."</b></td> </tr>";
           echo '<tr><td colspan=2 style="border-top: 1px solid; height: 3px"></td></tr>';     
            }
    
    echo'<tr><td class="right" style="border-top: 1px solid black;border-bottom: 1px solid black;"><b>Grand Total</b></td><td class="right" style="padding-right: 10px;border-top: 1px solid black;border-bottom: 1px solid black;"><b>'.number_format($totalxpenses,2).'</b></b></td></tr>';

  
echo'</tbody></table><br>';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div>';
//echo '<div style="page-break-after:always"> </div>';
 }else if($type =='2'){
    echo '<div id="printableArea" style="width: 620px; margin-right: auto;margin-left: auto">';

echo '<table width="100%"  border="0">';   
echo '<tr>';
//echo '<td> <img src="../assets/images/gold new logo.jpg" id="" height="80" width="120" /></img> </td>';
echo '<td width="70%" style="text-align: center;">';?>
<b><i><font size="3">Anjuman-e-Burhani</font></i></b>
<?php

echo '</td>';
echo '</tr> ';
echo '</table>';
echo '<div align="center"><font size="2"><b>Cost Center Detailed Report</font></b> </div>';
echo '<div align="center"><font size="2"><b>'.$_SESSION['dptname'].' Department</font></b> </div>';
//echo '<hr />';
echo '<div><table id="report">';
//echo '<tr><td>Account No. &nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b></b></td><td align=right>Ejamaat/Entity No.&nbsp;&nbsp; &nbsp; Tel: &nbsp;</td></tr>';
echo '<tr><td style="text-align: center;"> From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></td><td></td></tr>'; 
echo '</table></div>';
echo '<hr />';
//echo '<br />';
$grantotal = 0; $totalxpenses = 0;
echo '<table id="report" style="width:100%" class="exporttable" cellpading=4>';
echo '<tr><th colspan="4">Details</th><th style="text-align: right"> Amount </th></tr>';
echo '<tbody>';
    for($t=0;$t<count($costscenters);$t++){
        $costcntretotal = 0;
    echo '<tr><td colspan="5" style="background: grey"><b>'.$costscenters[$t]['centrename'].'</b></td></tr>';    
         
          $expenseamnt = $mumin->getdbContent("SELECT expenseacc,accname FROM(SELECT expenseacc,expnseaccs.accname FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND costcentrid = '".$costscenters[$t]['cntrid']."' AND expnseaccs.type <> 'A' UNION
                                                SELECT expacc,accname FROM (SELECT IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc,expnseaccs.accname FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' AND costcentrid = '".$costscenters[$t]['cntrid']."' AND expnseaccs.type <> 'A' )t7 GROUP BY expacc )T6 GROUP BY expenseacc ORDER BY accname
");
           for($i=0;$i<count($expenseamnt);$i++){
               $expensettal = 0;
         $expensename = $expenseamnt[$i]['accname'];
          echo "<tr style='height: 20px;'><td style='color: blue' colspan='5'><b>&nbsp;&nbsp;&nbsp;".$expensename."</b></td></tr>";
          echo "<tr style='height: 20px;color: brown;font-weight: bold'><td>Date</td><td>Doc</td><td>Doc No</td><td>Rmks</td><td class='right' style='padding-right: 10px'>Amount</td></tr>";
          $expensedetails = $mumin->getdbContent("SELECT debitamnt as debitamnt,expenseacc,accname,rmks,doc,bdate,docno FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,expenseacc,expnseaccs.accname,rmks,'Bill' as doc,bdate,docno FROM  bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND costcentrid = '".$costscenters[$t]['cntrid']."' AND expenseacc = '".$expenseamnt[$i]['expenseacc']."'   UNION
                                                SELECT amount as debitamnt,jid,expacc,accname,rmks,doc,dexpdate,dexpno FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,expnseaccs.accname,rmks,'Direct Expense' as doc,dexpdate,dexpno FROM directexpense,expnseaccs WHERE directexpense.dacc = expnseaccs.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' AND costcentrid = '".$costscenters[$t]['cntrid']."' )t7 WHERE expacc = '".$expenseamnt[$i]['expenseacc']."' )T6 ");
          for($k=0;$k<count($expensedetails);$k++){
               $debitamt= $expensedetails[$k]['debitamnt'];
               $expensettal +=  $debitamt;
              echo "<tr><td>".$expensedetails[$k]['bdate']."</td><td>".$expensedetails[$k]['doc']."</td><td>".$expensedetails[$k]['docno']."</td><td>".$expensedetails[$k]['rmks']."</td><td class='right' style='padding-right: 10px'>".number_format($expensedetails[$k]['debitamnt'],2)."</td></tr>";
          }
          if($debitamt == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 }
              echo "<tr style='height: 20px;border-top: 1px solid;border-bottom: 1px solid'><td colspan='4' style='text-align: center'><b>".$expensename." Total</b></td><td class='right' style='padding-right: 10px'>".number_format($expensettal,2)."</td></tr>";
          $costcntretotal = $expensettal + $costcntretotal;
          
           }
           //echo '<tr><td colspan=5 style="border-bottom: 1px solid;"><hr /></td></tr>';
            echo'<tr><td class="right" colspan="4"><b>'.$costscenters[$t]['centrename'].' Total</b></td><td class="right" style="padding-right: 10px"><b>'.number_format($costcntretotal,2).'</b></b></td></tr>';
           // echo '<tr><td colspan=5 style="border-top: 1px solid; "><hr /></td></tr>';
           $totalxpenses +=$costcntretotal;  
            }
      
    echo'<tr><td colspan="4"><b>Grand Total</b></td><td class="right" style="padding-right: 10px"><b>'.number_format($totalxpenses,2).'</b></td></tr>';

 
echo'</tbody></table><br>';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div>';
 
 }
?>

</body>
</html>