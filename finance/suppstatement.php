<?php
 session_start();
 if(!(isset($_SESSION['jmsloggedIn']))) {
header("location:../index.php"); 
}
else{
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Supplier Statement </title>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
.centr{ text-align: center; }
#report th { background-color:#957c17; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

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
});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;overflow-x: visible!important;">

<div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();" id="prntst"><span><span><span class="print">Print Statement</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();" id="closest"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d',  strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d',  strtotime($to_date1));
$supplier=$_GET['supplier'];
 $account =  $_GET['expnseacct'];
 $stype = $_GET['type'];
include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();


$wqw =$mumin->getdbContent("SELECT * FROM  suppliers  WHERE estId LIKE '$id' AND supplier = '$supplier' ");


if($stype =='2'){
if($account== 'all'){
  $qryies = "SELECT * from (SELECT bills.expenseacc as expenseacc,accname FROM bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id  AND bills.supplier = '$supplier' union
          SELECT acc,accname FROM bad_debtsupplrs,expnseaccs WHERE bad_debtsupplrs.acc = expnseaccs.id AND bad_debtsupplrs.type = 'E'  AND jno IN (SELECT jno FROM `bad_debtsupplrs` WHERE tbl = 'S' AND acc = '$supplier'))T7 GROUP BY expenseacc  ";
       
        
}else{
     $qryies = "SELECT * FROM (SELECT bills.expenseacc as expenseacc,accname FROM bills,expnseaccs WHERE bills.expenseacc = expnseaccs.id  AND bills.expenseacc = '$account' 
             UNION SELECT acc,accname FROM bad_debtsupplrs,expnseaccs WHERE bad_debtsupplrs.acc = expnseaccs.id AND bad_debtsupplrs.type = 'E'  AND jno IN (SELECT jno FROM `bad_debtsupplrs` WHERE tbl = 'S' AND acc = '$supplier') and acc = '$account') T8 GROUP BY expenseacc ";  
       //$query="SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$id'";

          
}}else if ($stype =='1') {
    if($account== 'all'){
        $qryies ="SELECT * FROM (SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt,bills WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$id' AND department2.id = bills.costcentrid AND bills.supplier = '$supplier' UNION 
                   SELECT centrename,costcentrid FROM bad_debtsupplrs,department2 WHERE bad_debtsupplrs.costcentrid = department2.id  AND tbl = 'S' AND acc = '$supplier') T23  GROUP BY cntrid";

    }else{
        $qryies ="SELECT * FROM (SELECT department2.centrename,department2.id as cntrid FROM department2,costcentrmgnt WHERE costcentrmgnt.costcentrid = department2.id AND costcentrmgnt.deptid = '$id' AND department2.id='$account' UNION 
                  SELECT centrename,costcentrid FROM bad_debtsupplrs,department2 WHERE bad_debtsupplrs.costcentrid = department2.id  AND tbl = 'S' AND acc = '$supplier' AND department2.id='$account')T8 GROUP BY cntrid";

    }
}
       $indata = $mumin->getdbContent($qryies);
       $disp = 'none';
  
echo '<div id="printableArea">';

echo '<table width="100%"  border="0">';   
echo '<tr>';
echo '<td colspan="2"> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:10px">'.$_SESSION['details'].'</span> </td><td><span style="float:right;font-size: 10px; padding-right: 30px"><b>'.$_SESSION['dptname'].'</b></span></td>';
echo '</tr> ';
echo '</table>';
echo '<div align="right"><font size="5"><b>Supplier Account</font></b> </div>';
echo '<hr />';
echo '<div><table id="report" style="font-size:13px;" >';
echo '<tr><td ><b>&nbsp;&nbsp;&nbsp; </b> Supplier Name: &nbsp; <b>'.$wqw[0]['suppName'].'</b></td><td align=right>&nbsp;&nbsp; &nbsp; Tel: &nbsp; '.$wqw[0]['suppTelephone'].'</td></tr>';
echo '<tr><td>Account Transaction From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></td><td align=right>Email:&nbsp;'.$wqw[0]['email'].'</td></tr>'; 
echo '</table></div>';
echo '<hr />';
echo '<br />';

echo '<table id="treport" style="width:100%" cellpading=4>';
echo '<thead style="height: 25px;"><tr><th> Date</th> <th>  Document No</th> <th>Payment mode</th><th class="right"> Debit</th> <th class="right"> Credit</th> <th class="right"> Balance</th></tr></thead>';
echo '<tbody>';
if($stype =='2'){
    $totaldebit = 0; $totalcredit = 0; $totalbalance= 0 ; 
            for($l=0;$l<=count($indata)-1;$l++){
                 
                 echo"<tr><td colspan='17' style='background-color:grey'><b>".$indata[$l]['accname']."</b></td></tr>";
        $supbbf = $mumin->getdbContent("SELECT SUM(amount) as supbbf from (SELECT sum(IF(isinvce ='1', amount,(amount)*-1)) as amount,id FROM bills where estate_id='$id' AND supplier = '$supplier' and bdate < '$from_date' AND expenseacc = '".$indata[$l]['expenseacc']."' UNION 
                                                                        SELECT (sum(dramount) - sum(cramount)) as amount,tno FROM bad_debtsupplrs WHERE acc = '".$indata[$l]['expenseacc']."' AND deptid = '$id' AND jdate < '$from_date' AND jno IN (SELECT jno FROM `bad_debtsupplrs` WHERE tbl = 'S' AND acc = '$supplier') UNION
                                        SELECT (SUM(amount))*-1 as amount ,tno  FROM paytrans WHERE supplier = '$supplier' AND estId = '$id' AND pdate < '$from_date' AND expenseacc = '".$indata[$l]['expenseacc']."') T2"); 
	$supplierbbf = $supbbf[0]['supbbf'];
       
        echo "<tr><td colspan='2' class='centr'><b>BBF</b></td><td></td><td></td><td></td><td class='right'>".number_format($supplierbbf,2)."</td></tr>";
       
        $supqr=$mumin->getdbContent("SELECT bdate as date,docno,ts,id,if(isinvce='1',amount,0) as creditamt,if(isinvce='0',amount,0) as debitamnt, if(isinvce='1','Bill ','Debit Note ') as doctype, ' ' as pmode FROM bills WHERE estate_id='$id' AND supplier = '$supplier' AND bdate BETWEEN '$from_date' AND '$to_date' AND expenseacc = '".$indata[$l]['expenseacc']."' UNION
                          SELECT jdate as date, jno as docno,ts,tno,if(cramount <> '0.00',cramount,0) as creditamt,if(dramount <> '0.00',dramount, 0) as debitamnt,'Journal Entry' as doctype,' ' as pmode  FROM bad_debtsupplrs WHERE acc = '".$indata[$l]['expenseacc']."' AND deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date'  AND jno IN (SELECT jno FROM `bad_debtsupplrs` WHERE tbl = 'S' AND acc = '$supplier') UNION
                        SELECT pdate as date,payno,ts,tno, IF(amount<0,-1*amount,0)as creditamt, IF(amount>0,amount,0)as debitamnt,'Payment Voucher' as doctype,IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE estId='$id' AND supplier= '$supplier' AND pdate BETWEEN '$from_date' AND '$to_date' AND expenseacc = '".$indata[$l]['expenseacc']."' ORDER BY date, ts ASC");
    
        $idvdldebit = 0; $idvdlcredit = 0; $indvdlbal = 0; 
        for($k=0; $k<=count($supqr)-1; $k++){
           
            $creditamnt = $supqr[$k]['creditamt'];
            $debitamnt = $supqr[$k]['debitamnt'];
            
             if($creditamnt<>0){
                 $supplierbbf+=floatval($supqr[$k]['creditamt']);
             }
             elseif ($debitamnt<>0){
                 $supplierbbf-=floatval($supqr[$k]['debitamnt']);
             }
        echo '<tr><td style="height: 25px;">'.date('d-m-Y',  strtotime($supqr[$k]['date'])).'</td><td>'.$supqr[$k]['doctype'].'No: &nbsp;&nbsp;'.$supqr[$k]['docno'].'&nbsp</td><td> '.$supqr[$k]['pmode'].'</td> <td class="right">'.number_format($debitamnt,2).'</td> <td class="right">'.number_format($creditamnt,2).'</td> <td class="right">'.number_format($supplierbbf,2).'</td> </tr>';
            $totaldebit = $debitamnt+ $totaldebit;
            $totalcredit = $creditamnt + $totalcredit;
           $idvdldebit += $debitamnt;
           $idvdlcredit += $creditamnt;
           $indvdlbal = $idvdlcredit - $idvdldebit;
        }$totalbalance = $supplierbbf + $totalbalance;
        $indvdualbal = $totalcredit - $totaldebit + $supplierbbf;
        echo'<tr><td colspan=3 style="text-align: right"><b>'.$indata[$l]['accname'].' Balance</b></td><td class="right"><b>'.number_format($idvdldebit,2).'</b></td><td class="right"><b>'.number_format($idvdlcredit,2).'</b></td><td class="right"><b>'.number_format($indvdlbal,2).'</b></td></tr>';

         }
         echo '<td colspan=6><hr /></td>';
echo'<tr><td colspan=3><b>Totals</b></td><td class="right"><b>'.number_format($totaldebit,2).'</b></td><td class="right"><b>'.number_format($totalcredit,2).'</b></td><td class="right"><b>'.number_format($totalbalance,2).'</b></td></tr>';
echo '<td colspan=6><hr /></td>';
echo'</tbody></table><br />';
             }
         
         
         elseif ($stype =='1') {
             $totaldebit = 0; $totalcredit = 0; $totalbalance= 0 ;
                     for($l=0;$l<=count($indata)-1;$l++){
                         
                 $indvdualbal = 0;
                 echo"<tr><td colspan='17' style='background-color:grey'><b>".$indata[$l]['centrename']."</b></td></tr>";
        $supbbf = $mumin->getdbContent("SELECT SUM(amount) as supbbf from (SELECT sum(IF(isinvce ='1', amount,(amount)*-1)) as amount,id FROM bills where estate_id='$id' AND supplier = '$supplier' and bdate < '$from_date' AND costcentrid = '".$indata[$l]['cntrid']."' UNION 
                                                                           SELECT (sum(cramount) - sum(dramount)) as amount,tno FROM bad_debtsupplrs WHERE acc = '$supplier' AND deptid = '$id' AND jdate < '$from_date' AND  tbl = 'S' AND costcentrid = '".$indata[$l]['cntrid']."' UNION
                                    SELECT (SUM(amount))*-1 as amount,tno  FROM paytrans WHERE supplier = '$supplier' AND estId = '$id' AND pdate < '$from_date' AND costcentrid = '".$indata[$l]['cntrid']."') T2"); 
	$supplierbbf = $supbbf[0]['supbbf'];
       
        echo "<tr><td colspan='2' class='centr'><b>BBF</b></td><td></td><td></td><td></td><td class='right'>".number_format($supplierbbf,2)."</td></tr>";
       
        $supqr=$mumin->getdbContent("SELECT bdate as date,docno,ts,id,if(isinvce='1',amount,0) as creditamt,if(isinvce='0',amount,0) as debitamnt, if(isinvce='1','Bill ','Debit Note ') as doctype, ' ' as pmode FROM bills WHERE estate_id='$id' AND supplier = '$supplier' AND bdate BETWEEN '$from_date' AND '$to_date' AND costcentrid = '".$indata[$l]['cntrid']."' UNION
                        SELECT jdate as date, jno as docno,ts,tno,if(cramount <> '0.00',cramount,0) as creditamt,if(dramount <> '0.00',dramount, 0) as debitamnt,'Journal Entry' as doctype,' ' as pmode  FROM bad_debtsupplrs WHERE acc = '$supplier' AND deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date'  AND tbl = 'S' AND costcentrid = '".$indata[$l]['cntrid']."' UNION
                        SELECT pdate as date,payno,ts,tno, IF(amount<0,-1*amount,0)as creditamt, IF(amount>0,amount,0)as debitamnt,'Payment Voucher' as doctype,IF(pmode='CASH',pmode,concat(pmode,' ','NO:',' ',chqno,' ',chqdet)) AS pmode FROM paytrans WHERE estId='$id' AND supplier= '$supplier' AND pdate BETWEEN '$from_date' AND '$to_date' AND costcentrid = '".$indata[$l]['cntrid']."' ORDER BY date, ts ASC");
    
         $idvdldebit = 0; $idvdlcredit = 0; $indvdlbal = 0; 
        for($k=0; $k<=count($supqr)-1; $k++){
            
            $creditamnt = $supqr[$k]['creditamt'];
            $debitamnt = $supqr[$k]['debitamnt'];
            
             if($creditamnt<>0){
                 $supplierbbf+=floatval($supqr[$k]['creditamt']);
             }
             elseif ($debitamnt<>0){
                 $supplierbbf-=floatval($supqr[$k]['debitamnt']);
             }
        echo '<tr><td style="height: 25px;">'.date('d-m-Y',  strtotime($supqr[$k]['date'])).'</td><td>'.$supqr[$k]['doctype'].'No: &nbsp;&nbsp;'.$supqr[$k]['docno'].'&nbsp</td><td> '.$supqr[$k]['pmode'].'</td> <td class="right">'.number_format($debitamnt,2).'</td> <td class="right">'.number_format($creditamnt,2).'</td> <td class="right">'.number_format($supplierbbf,2).'</td> </tr>';
            $totaldebit = $debitamnt+ $totaldebit;
            $totalcredit = $creditamnt + $totalcredit;
            $idvdldebit += $debitamnt;
           $idvdlcredit += $creditamnt;
           $indvdlbal = $idvdlcredit - $idvdldebit ;
        }$totalbalance = $supplierbbf + $totalbalance;
        $indvdualbal = $totalcredit - $totaldebit + $supplierbbf;
        echo'<tr><td colspan=3 style="text-align: right"><b>'.$indata[$l]['centrename'].' Balance</b></td><td class="right"><b>'.number_format($idvdldebit,2).'</b></td><td class="right"><b>'.number_format($idvdlcredit,2).'</b></td><td class="right"><b>'.number_format($supplierbbf,2).'</b></td></tr>';

         }
echo '<td colspan=6><hr /></td>';
echo'<tr><td colspan=3><b>Totals</b></td><td class="right"><b>'.number_format($totaldebit,2).'</b></td><td class="right"><b>'.number_format($totalcredit,2).'</b></td><td class="right"><b>'.number_format($totalbalance,2).'</b></td></tr>';
//echo '<td colspan=6><hr /></td>';
echo'</tbody></table><br />';
         
             }



echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
 
?>

</body>
</html>
<?php }?>