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
<title>Accounts Summary </title>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
.centr{ text-align: center; }
#report th { background-color:#957c17; }
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
   $("#csvfile").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});
   $("#csvfile").click(function(e){
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "exportedList"
				});
                                	});

});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;overflow-x: visible!important;">

<div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();" id="prntst"><span><span><span class="print">Print Summary</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();" id="closest"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow"  id="csvfile"><span><span><span class="cancel">Excel</span></span></span></button>
</div>
<br />

<?php
$from_date1 = $_GET['dstartdate'];
$from_date = date('Y-m-d',  strtotime($from_date1));
$to_date1 = $_GET['denddate'];
$to_date = date('Y-m-d',  strtotime($to_date1));
 $incmeac =  $_GET['incmeacct'];
include 'operations/Mumin.php';

$id=@$_SESSION['dept_id'];
if (!isset($id)){
    $id = $_GET['department'];
}
//$user=$_SESSION['usname'];

$mumin=new Mumin();
       
      $disp = 'none';
  
$wqw =$mumin->getdbContent("SELECT * FROM  invoice WHERE estId LIKE '$id' AND dno > 0");

$totalamount = 0; $dtotal = 0; $babftotal=0; $babf2total=0;
$spaid = 0;     $dpaid = 0;
$sbalance = 0;  $dbalance = 0;
if($incmeac== 'all'){
    $incmeqry = ' ';
    
}else{
    $incmeqry = 'AND incacc = '.$incmeac.' ';
}
$dept1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc  LIKE  '$incmeac' LIMIT 1");
              
          if($dept1){
              
              $deptname=$dept1[0]['accname'];
          }
          else{
              $deptname="All Accounts";
          }


echo '<div id="printableArea" class="container">';

echo '<table width="100%" >';   
echo '<tr>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.@$_SESSION['details'].'</span> </td>';
echo '<td><span style="float:right;font-size:12px; padding-right: 30px"><b>'.@$_SESSION['dptname'].'</b></span><div class="topic"><font size="5"><b>Debtors Summary</font></b></div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p align="right" font-size="2">From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b><br>&nbsp;&nbsp;&nbsp'.$deptname.'</p>';

echo '<table id="lists" style="width:100%" cellpading=4 class="exporttable">';
echo '<thead><tr><th style="height:25px" colspan="2"> SabilNo </th> <th colspan="2">  Debtor Name</th><th  class="centr" colspan="2" >BF</th> <th class="centr">Invoiced</th><th class="centr">Receipts</th><th class="right"> Balance</th></tr></thead>';
echo '<tbody>';
        $space = str_repeat('&nbsp', 10);
                                                                         
                        $mumincontent =$mumin->getdbContent("SELECT distinct(sabilno) as sabilno,ejno FROM mumin WHERE  ejno = hofej order by sabilno");
                      //SELECT (amount-(crdtamnt+paid)) as dbtramount FROM (SELECT SUM(IF(isinvce='1',amount,'0')) as amount,SUM(IF(isinvce='0',amount,'0')) as crdtamnt,sum(pdamount)as paid FROM estate_invoice WHERE idate BETWEEN '$startdte1' AND '$endate' AND estId ='$estId')t9
          
              for($j=0;$j<count($mumincontent);$j++){
                   $name = $mumin->get_MuminNames($mumincontent[$j]['ejno']);
                   if($to_date > '2016-12-31' ){ //opening balance-b/bf
           $qry56= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE sabilno LIKE '".$mumincontent[$j]['sabilno']."' AND estId LIKE '$id' AND opb = '1' $incmeqry) t1");
            $result36=$qry56[0]['bbfamnt'];
            }else{
                $result36 = '0';
            }
                   $qry3= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE  estId LIKE '$id'  AND idate < '$from_date'  AND dno = '0' AND opb = '0' AND sabilno='".$mumincontent[$j]['sabilno']."' $incmeqry UNION 
                    SELECT (SUM(amount))*-1 as amount,tno  FROM recptrans WHERE est_id LIKE '$id' AND rdate < '$from_date' AND sabilno='".$mumincontent[$j]['sabilno']."' AND dno = '0' $incmeqry UNION 
                    SELECT sum(dramount) - sum(cramount) as amount,tno FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate < '$from_date' AND acc = '".$mumincontent[$j]['sabilno']."' AND tbl = 'M'  $incmeqry ) t1";
                    $bbf =$mumin->getdbContent($qry3); 
                    
                  $sumq =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej FROM (SELECT tno,IF(isinvce='1',amount,amount*-1)as amount,'0' as paid,sabilno,hofej FROM invoice WHERE  estId LIKE '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND dno = '0' AND sabilno = '".$mumincontent[$j]['sabilno']."' AND opb = '0' $incmeqry UNION
                                                                                                                  SELECT tno,IF((sum(dramount) - sum(cramount)) > 0 ,(sum(dramount) - sum(cramount)),'0') as amount ,IF((sum(dramount) - sum(cramount)) <= 0 ,(sum(dramount) - sum(cramount))*-1,'0') as paid,acc,type FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date' AND tbl = 'M' AND acc = '".$mumincontent[$j]['sabilno']."' $incmeqry UNION
                                               SELECT tno,'0' as amount,amount as paid,sabilno,hofej FROM recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' AND est_id LIKE '$id' AND dno = '0' AND sabilno = '".$mumincontent[$j]['sabilno']."' $incmeqry )t4 ");
                   $bbfamnt = $bbf[0]['bbfamnt']+ $result36;
                   $sapaid = $sumq[0]['paid'];
                   //$sapaid = $sumq[$j]['paid'] + $sumq[$j]['crdtamnt'];
                   $sabalance = $bbfamnt+$sumq[0]['amount'] - $sapaid;
                   $sabl = $mumincontent[$j]['sabilno'];
              if (($bbfamnt == '' || $bbfamnt == '0.00' ) && ($sumq[0]['amount'] == '' || $sumq[0]['amount'] == '0.00' ) && ($sapaid == '' || $sapaid == '0.00') ){
                  // echo blank
              }else{
                   echo "<tr><td style='height:25px' colspan='2'><a target='blank' href='../finance/sabil_statement.php?param=sabil&sabil=$sabl&start=$from_date&end=$to_date&account=$incmeac'>".$mumincontent[$j]['sabilno']."</a></td><td colspan='2'>$name</td><td class='right' colspan='2'>".number_format($bbfamnt,2)."</td><td class='right' style='padding-right:20px'>".number_format($sumq[0]['amount'],2)."</td><td class='right' style='padding-right:20px'>".number_format($sapaid,2)."</td><td class='right' style='padding-right: 10px;'>".number_format($sabalance,2)."</td></tr>";
              //<a target='blank' href='suppstatement.php?startdate=$from_date&enddate=$to_date&supplier=$suppid'>".$wqw[$j]['suppName']."</a></td><td class='right' style='padding-right:20px'>".  number_format($sumq[0]['bbf'],2)."</td><td class='right' style='padding-right:20px'>".  number_format($sumqry[0]['amount'],2)."</td><td class='right' style='padding-right:10px'> ".number_format($carrfwrd,2)."</td></tr>";
              }
                   $totalamount = $sumq[0]['amount'] + $totalamount;
              $spaid = $sumq[0]['paid'] + $spaid;
              $sbalance =  $sabalance +  $sbalance; 
              $babf2total= $bbfamnt + $babf2total;
              } 
              //DEBTORS
                                    $debtorcontent = $mumin->getdbContent("SELECT dno,sabilno FROM debtors WHERE deptid='$id' ORDER BY sabilno,debtorname");
              for($j=0;$j<count($debtorcontent);$j++){
                   $dname = $mumin->get_debtorName($debtorcontent[$j]['dno']);
                   if($debtorcontent[$j]['sabilno'] == ''){
                       $debtorecho = '*';
                   }else{
                       $debtorecho = $debtorcontent[$j]['sabilno'];
                   }
                           if($to_date > '2016-12-31' ){ //opening balance-b/bf
           $qry56= $mumin->getdbContent("SELECT SUM(amount) as bbfamnt , tno from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE  dno = '".$debtorcontent[$j]['dno']."' AND estId = '$id' AND opb = '1' $incmeqry) t1");
            $result36=$qry56[0]['bbfamnt'];
            }else{
                $result36 = '0';
            }   
                                $qr4= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE dno = '".$debtorcontent[$j]['dno']."' AND estId LIKE '$id' AND opb = '0' AND idate < '$from_date' $incmeqry UNION 
                                       SELECT sum(dramount) - sum(cramount) as amount,tno FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate < '$from_date' AND acc = '".$debtorcontent[$j]['dno']."' AND tbl = 'D'  $incmeqry UNION
                                       SELECT (SUM(amount))*-1 as amount,tno FROM recptrans WHERE dno = '".$debtorcontent[$j]['dno']."' AND est_id LIKE '$id' AND rdate < '$from_date'  $incmeqry) t1";
                                $result4=$mumin->getdbContent($qr4);           
                   
                      $sumd =$mumin->getdbContent(
                       "SELECT sum(amount) as amount,sum(paid) as paid,sabilno,dno FROM (SELECT tno,IF(isinvce='1',amount,amount*-1)as amount,'0' as paid,sabilno,dno FROM invoice WHERE  estId LIKE '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND dno = '".$debtorcontent[$j]['dno']."' AND opb = '0' $incmeqry  UNION
                        SELECT tno,IF((sum(dramount) - sum(cramount)) > 0 ,(sum(dramount) - sum(cramount)),'0') as amount ,IF((sum(dramount) - sum(cramount)) <= 0 ,(sum(dramount) - sum(cramount))*-1,'0') as paid,acc,type FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate BETWEEN '$from_date' AND '$to_date' AND tbl = 'D' AND acc = '".$debtorcontent[$j]['dno']."' $incmeqry UNION
                        SELECT tno,'0' as amount,amount as paid,sabilno,dno FROM recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' AND est_id LIKE '$id' AND dno = '".$debtorcontent[$j]['dno']."' $incmeqry )t4 ");
                      //SELECT (amount-(crdtamnt+paid)) as dbtramount FROM (SELECT SUM(IF(isinvce='1',amount,'0')) as amount,SUM(IF(isinvce='0',amount,'0')) as crdtamnt,sum(pdamount)as paid FROM estate_invoice WHERE idate BETWEEN '$startdte1' AND '$endate' AND estId ='$estId')t9
             
                    $balance_bf= $result4[0]['bbfamnt'] + $result36;
                   $dtotal = $sumd[0]['amount'] + $dtotal;
                   $dapaid = $sumd[0]['paid'];
                   $dabalance = $balance_bf+$sumd[0]['amount'] - $dapaid ;
                   $babftotal = $babftotal + $balance_bf;
                   $dpaid = $dapaid + $dpaid;
                   $dbalance = $dabalance + $dbalance;
                   $debtid = $debtorcontent[$j]['dno'];
                   
                  if (($balance_bf == '' || $balance_bf == '0.00' ) && ($sumd[0]['amount'] == '' || $sumd[0]['amount'] == '0.00' ) && ($dapaid == '' || $dapaid == '0.00') ){
                  // echo blank
              } else{
                   echo "<tr><td style='height:25px' colspan='2'><a target='blank' href='../finance/sabil_statement.php?param=debtor&start=$from_date&end=$to_date&debtor=$debtid&account=$incmeac'>".$debtorecho."</a></td><td colspan='2'>$dname</td><td class='right' colspan='2'>".number_format($balance_bf,2)."</td><td class='right' style='padding-right:20px'>".number_format($sumd[0]['amount'],2)."</td><td class='right' style='padding-right:20px'>".number_format($dapaid,2)."</td><td class='right' style='padding-right: 10px;'>".number_format($dabalance,2)."</td></tr>";
              }}
              $babf3total = $babftotal + $babf2total;
              $tamount = $dtotal + $totalamount;
              $tpaid = $spaid + $dpaid;
              $tbalance = $dbalance +$sbalance;
              echo '<tr><td colspan="10"></td></tr>';
echo'<tr><td colspan="4"><b>Totals</b></td><td class="right" colspan="2"><b>'.number_format($babf3total,2).'</b></td><td class="right" style="padding-right:20px"><b>'.number_format($tamount,2).'</b></td><td class="right" style="padding-right:20px"><b>'.number_format($tpaid,2).'</b></td><td class="right" ><b>'.number_format($tbalance,2).'</b></td></tr>';
//echo '<td colspan=10><hr /></td>';
echo'</tbody></table><br />';


echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.@$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
 
?>

</body>
</html>
<?php }?>