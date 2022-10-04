<?php
 session_start();
  if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
} else {
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Income/expense Statement </title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
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
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>
<script>
$(function() {

   $("#iexpnsexcel").click(function(e){
            var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					exclude: ".noExl",
					name: "Exported File",
					filename: "Income Statement"
				});
                                	});

});
</script>
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
$(".excel_tb").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-grip-diagonal-se"
            },
            text: true
             
});
});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;;overflow-x: visible!important;">

<div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button  class="sexybutton sexymedium sexyyellow excel_tb" id="iexpnsexcel"><span><span><span class="cancel">Export To Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
//$supplier=$_GET['supplier'];
// include 'links.php';

include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();

$crdtotal = 0; $debitotal = 0;
echo '<div id="printableArea" class="container" >';
echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img id="logo1" src="images/gold.png"></td>';
echo '<td><p><i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani </font></i> </p><font style="font-size:8px;">'.$_SESSION['details'].'</font>';
echo '</td>';
echo '<td><div class="topic"><font size="3"><b>Income Statement</font></b></div></td>';
echo'</tr></table>';?>
<?php

echo '<hr /><p font-size="2" align="right">From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></p>';

$grantotal = 0;
echo '<table id="report"  cellpading=4 class="exporttable table table-condensed">';
echo '<tr><th> 12 point Budget</th><th> Receivables </th>   <th class="right"> Amount</th></tr>';
echo '<tbody>';

      $wqry =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname,incomeactmgnt.point12 FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"); //Income accounts
            
      for($t=0;$t<count($wqry);$t++){
          $actname = $wqry[$t]['accname'];
          $actid = $wqry[$t]['incacc'];
          $twelvepnt = $wqry[$t]['point12'];
          $incmamnt = $mumin->getdbContent("SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  invoice WHERE incacc='$actid'  AND estId = '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND opb = '0' ");      
          
          $credtamnt = $incmamnt[0]['debitamount']- $incmamnt[0]['creditamnt'];
          if($credtamnt == 0){
                 $disply = 'display:none;';
                $disclas =  'noExl';
                 }else{
                 $disply = '';
                 $disclas ='';
                 }
          echo "<tr style='height: 20px;".$disply."' class='$disclas'><td>$twelvepnt</td><td><a target='blank' href='incomedetails.php?fromdate=$from_date&todate=$to_date&incmact=$actid'>&nbsp;&nbsp;&nbsp;&nbsp;".$actname."</a></td>  <td class='right' style='padding-right: 10px'>".number_format($credtamnt,2)."</td> </tr>";
          $crdtotal = $credtamnt+$crdtotal;
        }
		
            $qryz =$mumin->getdbContent("SELECT * FROM  incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND typ = 'G'  AND incomeactmgnt.deptid = '$id'"); //Income accounts
                for($i=0;$i<count($qryz);$i++){
                    $amntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate BETWEEN '$from_date' AND '$to_date' AND estId = '$id' AND 	crdtacc = '".$qryz[$i]['incacc']."' )t5 ");
                    $amnt = $amntqry[0]['amount'];
                    if($amnt == 0){
                     $disply = 'display:none;';
                $disclas =  'noExl';
                 }else{
                 $disply = '';
                 $disclas ='';
                 }
          echo '<tr style="height: 25px;'.$disply.'" class="'.$disclas.'" ><td></td><td>&nbsp;&nbsp;&nbsp;&nbsp;'.$qryz[$i]['accname'].'</td> <td class="right" style="padding-right: 10px">'.number_format($amnt,2).'</td> </tr>';          
          $grantotal = $grantotal + $amnt;      
                          }
      
        echo '<td colspan=3 style="height: 5px"></td>';
    echo'<tr><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"></td><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"><b>Income Total</b></td><td class="right" style="border-top:1px solid black;border-bottom:1px solid black;padding-right: 10px">'.number_format($crdtotal+$grantotal,2).'</td></tr>';

    echo  '<tr><td colspan="3" style="border-bottom: 1px solid; height: 10px"></td></tr></tbody>';
 echo '<tr><th>12 point Budget</th><th> Payable </th>   <th class="right"> Amount</th> </tr>';     
    echo  '<tbody></tr>';
    
    
 $eqry =$mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id order by accname"); //Expense accounts
              for($i=0;$i<count($eqry);$i++){
          $accname = $eqry[$i]['accname'];
          $accid = $eqry[$i]['id'];
          // if ($_SESSION['grp']=='EXTERNAL') {
         // $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT (amount) as debitamnt FROM  estate_bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND sector='".$_SESSION['sector']."' UNION
         //                                      SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' and sector='".$_SESSION['sector']."' AND estate_id= '$id')t7 WHERE expacc = '$accid' )T6");
         //  } else {
         // $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT (amount) as debitamnt FROM  estate_bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
          //                                      SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '$accid' )T6");
          // }
		
          
          $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsmbrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsupplrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '$accid' )T6");
        
          $debitamt= $expenseamnt[0]['debitamnt'];
          if($debitamt == 0){
                 $disply = 'display:none;';
                 $disclas =  'noExl';
                 }else{
                 $disply = '';
                 $disclas =  '';
                 }
          echo "<tr style='height: 20px;".$disply."' class='$disclas'><td></td><td><a target='blank' href='expensedtails.php?fromdate=$from_date&enddate=$to_date&expactid=$accid'>&nbsp;&nbsp;&nbsp;&nbsp;".$accname."</a></td>  <td class='right' style='padding-right: 10px'>".number_format($debitamt,2)."</td> </tr>";
          $debitotal = $debitamt + $debitotal;
      }
        $balan = $grantotal+$crdtotal - $debitotal;
        
echo '<td colspan=3 style="height: 3px" ></td>';
echo '<tr><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"></td><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"><b>Expense Total</b></td><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right" style="padding-right: 10px">'.number_format($debitotal,2).'</td></tr>';
echo '<td colspan=3 style="height: 3px"></td>';
echo '<tr><td style="border-top:1px solid black;" class="right"></td><td style="border-top:1px solid black;" class="right"><b>Surplus/Deficit for the Period</b></td><td style="border-top:1px solid black;" class="right" style="padding-right: 10px">'.number_format($balan,2).'</td></tr>';
//echo '<td colspan=2><hr /></td>';
   
            //GRANT + INCOME - EXPENSE
            $amntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate < '$from_date' AND estId = '$id' AND crdtacc IN (SELECT incacc FROM incomeaccounts WHERE typ = 'G') )t5 ");
                    $grant = $amntqry[0]['amount'];
                $incmeqry = $mumin->getdbContent("SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  invoice WHERE estId = '$id' AND idate < '$from_date'");
               $income = $incmeqry[0]['debitamount'] - $incmeqry[0]['creditamnt'];
                
//$expensegry = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT sum(amount) as debitamnt FROM  bills WHERE estate_id = '$id' AND bdate < '$from_date' UNION
                //                               SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate < '$from_date' AND estate_id= '$id')t7 WHERE expacc IN (SELECT id FROM  expnseaccs))T6");
                $expensegry = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  bills WHERE estate_id = '$id' AND bdate < '$from_date' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  < '$from_date'  AND deptid = '$id' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsmbrs` WHERE tbl = 'E' and type = 'E' AND jdate  < '$from_date'  AND deptid = '$id' UNION    
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsupplrs` WHERE tbl = 'E' and type = 'E' AND jdate  < '$from_date'  AND deptid = '$id' UNION        
                                                SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate < '$from_date' AND estate_id= '$id' )t7 WHERE expacc IN (SELECT id FROM  expnseaccs))T6");
                
                $opbalrearnings =  $mumin->getdbContent("SELECT amount FROM r_earningsbf");
                
                $expense = $expensegry[0]['debitamnt']; 
                        $retainexp = ($grant + $income - $expense -$opbalrearnings[0]['amount']);
                     
                          
    
		$netearnings = $retainexp +$balan;
echo'<tr><td style="border-bottom:1px solid black;"class="right"></td><td style="border-bottom:1px solid black;"class="right"><b>Retained Earnings B/F</b></td><td style="border-bottom:1px solid black;"class="right" style="padding-right: 10px">'.number_format($retainexp,2).'</td></tr>';
echo '<td colspan=3 ></td>';
echo'<tr><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"></td><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right"><b>Expected Net Surplus/Deficit</b></td><td style="border-top:1px solid black;border-bottom:1px solid black;" class="right" style="padding-right: 10px"><font style="border-bottom: double black;" >'.number_format($netearnings,2).'</font></td></tr>';
echo '<td colspan=3></td>';
echo'</tbody></table><br>';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div><br>';
//echo '<div style="page-break-after:always"> </div>';
 
?>

</body>
</html>
<?php
}
?>