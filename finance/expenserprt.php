<?php
 session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Expense Wise Report</title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17 !important; height:25px; }
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
$("#expnsexcel").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});
 $("#expnsexcel").click(function(e){
       // alert('test');
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Expense Account Report"
				});
                                	});

 
    }); 
 
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;;overflow-x: visible!important;">

<div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="expnsexcel" class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Export to Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
$expacct=$_GET['expacct'];
$type=$_GET['type'];


include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();

$crdtotal = 0; $debitotal = 0;

if($expacct==''){
    $expenseaccts = $mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' AND expnseaccs.id IN (SELECT expenseacc FROM bills WHERE bdate BETWEEN '$from_date' AND '$to_date' UNION SELECT dacc FROM directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date') and expnseaccs.type <> 'A'  GROUP BY expnseaccs.id ORDER BY accname asc ");
    
}
else{
     $expenseaccts = $mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs WHERE id = '$expacct' LIMIT 1"); 
     
     
}
if($type =='1'){
	echo'<div class="container1">';
echo '<div id="printableArea" >';
echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img src="../assets/images/gold new logo.jpg" id="" height="100px"  /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;"> Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.@$_SESSION['details'].'</span> </td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="center"><font style="font-size:14px;"><b>Expense Summary Report</font> <br> '.$_SESSION['dptname'].' Department <br> From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b> </p>';

$grantotal = 0; $totalxpenses = 0;
echo '<table id="report" class="table table-condensed exporttable">';
echo '<tr><th>Code</th><th>Name</th><th>Details</th><th style="text-align: right"> Amount </th></tr>';
//echo '<tbody><tr style="border: 1px dotted"><td colspan="2" ></td></tr>';
    for($t=0;$t<count($expenseaccts);$t++){
        $costcntretotal = 0;
    echo '<tr style="border-top:2px solid;"><td></td><td></td><td colspan="2"><b>'.$expenseaccts[$t]['accname'].'</b></td></tr>';    
         
          $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,ccntrid,centrename FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,department2.id as ccntrid,department2.centrename FROM  bills,department2 WHERE bills.costcentrid = department2.id AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND expenseacc = '".$expenseaccts[$t]['id']."' UNION
                                                                                                          SELECT IF(dramount='0',cramount*-1,dramount) as debitamnt, tno, '0' as ccntrid,'*No Costcentre*' as centrename FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date' AND tbl = 'E' and type = 'E'  AND acc = '".$expenseaccts[$t]['id']."' UNION
                                                SELECT sum(amount) as debitamnt,jid,ccntrid,centrename FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc,department2.id as ccntrid,department2.centrename FROM directexpense,department2 WHERE directexpense.costcentrid = department2.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '".$expenseaccts[$t]['id']."' GROUP BY ccntrid )T6 GROUP BY ccntrid ORDER BY centrename
");
           for($i=0;$i<count($expenseamnt);$i++){
          $debitamt= $expenseamnt[$i]['debitamnt'];
          $centrename = $expenseamnt[$i]['centrename'];
          if($debitamt == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 }
                 echo "<tr style='height: 20px;".$disply."'><td></td><td></td><td style='color: blue'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$centrename."</td><td class='right' style='padding-right: 10px'>".number_format($debitamt,2)."</td> </tr>";
          $costcntretotal = $debitamt + $costcntretotal;
          
           }
           $totalxpenses +=$costcntretotal;
        
            echo "<tr><td></td><td></td><td style='text-align: right'><b>".$expenseaccts[$t]['accname']." Total</b></td><td class='right' style='padding-right: 10px'><b>".number_format($costcntretotal,2)."</b></td> </tr>";
          
            }
       
    echo'<tr><td style="border-top: 1px solid black;border-bottom-style: double;"></td><td style="border-top: 1px solid black;border-bottom-style: double;"></td><td class="right" style="border-top: 1px solid black;border-bottom-style: double;"><b>Grand Total</b></td><td class="right" style="padding-right: 10px;border-top: 1px solid black;border-bottom-style: double;"><b>'.number_format($totalxpenses,2).'</b></b></td></tr>';


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
echo '<div align="center"><font size="2"><b>Expenses List</font></b> </div>';
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
    for($t=0;$t<count($expenseaccts);$t++){
        $costcntretotal = 0;
    echo '<tr><td colspan="5" style="background: grey"><b>'.$expenseaccts[$t]['accname'].'</b></td></tr>';    
         
         $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt,ccntrid,centrename FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,department2.id as ccntrid,department2.centrename FROM  bills,department2 WHERE bills.costcentrid = department2.id AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND expenseacc = '".$expenseaccts[$t]['id']."' UNION
                                                                                                          SELECT IF(dramount='0',cramount*-1,dramount) as debitamnt, tno, '0' as ccntrid,'*No Costcentre*' as centrename FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date' AND tbl = 'E' and type = 'E'  AND acc = '".$expenseaccts[$t]['id']."' UNION
                                                SELECT sum(amount) as debitamnt,jid,ccntrid,centrename FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc,department2.id as ccntrid,department2.centrename FROM directexpense,department2 WHERE directexpense.costcentrid = department2.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '".$expenseaccts[$t]['id']."' GROUP BY ccntrid )T6 GROUP BY ccntrid ORDER BY centrename
");
           for($i=0;$i<count($expenseamnt);$i++){
               $expensettal = 0;
         $expensename = $expenseamnt[$i]['centrename'];
          echo "<tr style='height: 20px;'><td style='color: blue' colspan='5'><b>&nbsp;&nbsp;&nbsp;".$expensename."</b></td></tr>";
          echo "<tr style='height: 20px;color: brown;font-weight: bold'><td>Date</td><td>Supplier</td><td>Doc No</td><td>Rmks</td><td class='right' style='padding-right: 10px'>Amount</td></tr>";
          $expensedetails = $mumin->getdbContent("SELECT debitamnt as debitamnt,costcentrid,centrename,rmks,doc,bdate,docno FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,bills.id,costcentrid,department2.centrename,rmks,suppliers.suppName as doc,bdate,docno FROM  bills,department2,suppliers WHERE bills.costcentrid = department2.id AND bills.supplier = suppliers.supplier  AND  estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND expenseacc = '".$expenseaccts[$t]['id']."' AND costcentrid = '".$expenseamnt[$i]['ccntrid']."'   UNION
                                                                                                                                  SELECT IF(dramount='0',cramount*-1,dramount) as debitamnt,tno, '0' as ccntrid,'*No Costcentre*' as centrename,rmks,'General Voucher' as doc,jdate,jno FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date' AND tbl = 'E' and type = 'E' AND acc = '".$expenseaccts[$t]['id']."' UNION
                                                    SELECT amount as debitamnt,jid,costcentrid,centrename,rmks,doc,dexpdate,dexpno FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,department2.centrename,rmks,'Direct Expense' as doc,dexpdate,dexpno,costcentrid FROM directexpense,department2 WHERE directexpense.costcentrid = department2.id and  dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' AND costcentrid = '".$expenseamnt[$i]['ccntrid']."' )t7 WHERE expacc = '".$expenseaccts[$t]['id']."' )T6");
          for($k=0;$k<count($expensedetails);$k++){
               $debitamt= $expensedetails[$k]['debitamnt'];
               $expensettal +=  $debitamt;
              echo "<tr><td>".date('d-m-Y',strtotime($expensedetails[$k]['bdate']))."</td><td>&nbsp;&nbsp;&nbsp;".$expensedetails[$k]['doc']."</td><td>".$expensedetails[$k]['docno']."</td><td>".$expensedetails[$k]['rmks']."</td><td class='right' style='padding-right: 10px'>".$expensedetails[$k]['debitamnt']."</td></tr>";
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
            echo'<tr<td></td><td></td><td class="right" colspan="4"><b>'.$expenseaccts[$t]['accname'].' Total</b></td><td class="right" style="padding-right: 10px"><b>'.number_format($costcntretotal,2).'</b></b></td></tr>';
           // echo '<tr><td colspan=5 style="border-top: 1px solid; "><hr /></td></tr>';
           $totalxpenses +=$costcntretotal;  
            }
        echo '<tr><td colspan=5><hr /></td></tr>';
    echo'<tr><td></td><td></td><td colspan="6"><b>Grand Total</b></td><td class="right" style="padding-right: 10px"><b>'.number_format($totalxpenses,2).'</b></td></tr>';

   echo '<tr><td colspan=5><hr /></td></tr>';
echo'</tbody></table><br>';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div>';
 
 }
?>

</body>
</html>