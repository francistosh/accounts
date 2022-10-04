<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
}
}
date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head runat="server">
<title>Trial Balance</title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
#report th { height: 25px;}
#report td { height: 30px; }
#printableArea {
            
            padding-left: 10px; padding-right: 10px;
            }
 .headin{border-bottom: #333333 ridge 2px;}
 a {
      text-decoration:none;
   }
    a:hover {text-decoration:underline;}
@media print
{ 
    a {
      text-decoration:none;
   }
 #printableArea { border: none;
            margin-left: 10px; margin-right: 10px;  margin-top: 0px;
            padding-left: 10px; padding-right: 10px;
            } 
#report th { height: 20px;}
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
$("#prnt_tb").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-print"
            },
            text: true
             
});
   $("#close_tb").button({  
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
 $("#tbtoexcel").click(function(e){
       // alert('test');
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
x.find('.noExl').remove();
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Trial Balance"
				});
                                	});

 
    }); 
 
</script>
</head>
    
    <body style="background: white;;overflow-x: visible!important;">
        
 <div align="center" id="printNot">
<button id="prnt_tb" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="close_tb" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow excel_tb" id="tbtoexcel"><span><span><span class="cancel">Export To Excel</span></span></span></button>

 </div>
<br />
        
        <?php
       
        $start=$_GET['startdate1'];
        $startdte1 = date('Y-m-d',  strtotime($start));
        $end=$_GET['enddate1'];
        $endate = date('Y-m-d',  strtotime($end));
        $estId=$_SESSION['dept_id'];

            $dis = 'display:none';

echo '<div id="printableArea">';
echo'<div class="container">';
echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img id="logo1" src="images/gold.png"></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p><font style="font-size:8px;">'.$_SESSION['details'].'</font>';
echo '</td>';
echo '<td><div class="topic"><font size="3"><b>Trial Balance</font></b></td>';
echo '</tr> ';
echo '</table>';
echo '<hr/><p font-size="2" align="right">FROM: <b>'.$start.' </b>TO <b>&nbsp;'.$end.'</b></p>';


echo '<table id="report" class="exporttable table table-condensed">';
echo '<thead><tr><th></th><th style="width:20px"></th><th style="display:none" class="noExl">BBF</th><th style="width:80px;"></th><th style="text-align: center;border-bottom: 2px solid;"> DEBIT</th><th style="width:80px"></th><th style="text-align:center;border-bottom: 2px solid;"> CREDIT</th></tr></thead>';
echo '<tbody>';
       
    $incmetotal =0; $expnsetotal =0; $tbdebitotal = 0; $bankactotal = 0; $bankcrdt=0;
    $bankbbftotatl = 0; $bankcreditamnt =0;
    
            
     echo "<tr><td colspan='3'><span class='headin'><b>Banks<b>&nbsp;&nbsp;&nbsp;</span></td></tr>";
        
              
                    $miniaccounts=$mumin->getdbContent("SELECT * FROM bankaccounts WHERE deptid = '$estId'");
            for($k=0;$k<count($miniaccounts);$k++){
                $bankame = $miniaccounts[$k]['acname'].' : '.$miniaccounts[$k]['acno'];
                $bankid = $miniaccounts[$k]['bacc'];
          $qtery = "SELECT sum(bbfamt) as brfamnt FROM (SELECT sum(amount) as bbfamt FROM recptrans WHERE bacc=$bankid AND est_id = '$estId' AND date(depots) < '$startdte1' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount,amount*-1)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM directexpense WHERE dexpdate < '$startdte1'  and estate_id ='$estId')t7 WHERE bankacct = $bankid UNION                        
                                                        SELECT (sum(amount)*-1)as bbfamt FROM paytrans WHERE bacc='$bankid' AND estId = '$estId' AND pdate < '$startdte1' UNION
                                                       SELECT sum(amount) as bbfamt FROM (SELECT IF(crdtacc= '$bankid' AND cbacc = '1' ,amount*-1,amount)as amount,tno FROM jentry WHERE (crdtacc= '$bankid' or dbtacc = '$bankid') AND  estId = '$estId' AND jdate < '$startdte1')T1) t6 ";
           $qry = "SELECT SUM(debitamt)- SUM(creditamt) as bankamount FROM (SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,sum(-1*amount),'')as creditamt,IF(amount>0,sum(amount),'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,depots as ts,tno FROM recptrans WHERE date(depots) BETWEEN '$startdte1' AND '$endate' AND bacc = $bankid  AND est_id LIKE '$estId' AND pmode = 'CASH' GROUP BY isdeposited UNION
                  SELECT date(depots) as date,isdeposited as docno,rmks,IF(amount<0,-1*amount,'')as creditamt,IF(amount>0,amount,'')as debitamt,if(tno>0,'Deposit','') as doctype, IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,depots as ts,tno FROM recptrans WHERE date(depots) BETWEEN '$startdte1' AND '$endate' AND bacc = $bankid  AND est_id LIKE '$estId' AND pmode = 'CHEQUE' UNION
                  SELECT pdate as date,payno as docno,rmks,IF(amount>0,amount,'')as creditamt,IF(amount<0,-1*amount,'')as debitamt,'Payment V.' as doctype,IF(pmode='CASH','Cash',concat('Cheque',' ','No:',' ',chqno,' ',chqdet)) AS pmode,ts,tno FROM paytrans WHERE pdate BETWEEN '$startdte1' AND '$endate' AND estId = '$estId' AND bacc='$bankid' UNION
                  SELECT jdate as date,jvno as docno,rmks,IF(crdtacc='".$bankid."' AND cbacc = '1' ,amount,'')as creditamt,IF(dbtacc='".$bankid."' AND dbacc = '1',amount,'')as debitamt,'Journal Voucher' as doctype, rmks AS pmode,ts,tno FROM jentry where jdate  BETWEEN '$startdte1' AND '$endate' AND estId = '$estId' AND (dbtacc = '$bankid' or crdtacc = '$bankid') UNION
                  SELECT date,docno,rmks,creditamt,debitamt,doctype,pmode,ts,jid FROM (SELECT dexpdate as date,dexpno docno,rmks,IF(cacc='$bankid' ,amount,'')as creditamt, IF(dacc='$bankid',amount,'')as debitamt,'Direct Expense' as doctype,rmks AS pmode,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,ts,jid FROM directexpense WHERE dexpdate BETWEEN  '$startdte1' and '$endate'  and estate_id ='$estId')t7 WHERE bankacct = '$bankid')t5 order by date,ts";

                       $bankledgerdet=$mumin->getdbContent($qry);
              $balancebank=$mumin->getdbContent($qtery);
                $bankamount = $bankledgerdet[0]['bankamount'];
                $bankbfrwrd = $balancebank[0]['brfamnt'];
				$bankamount1 = $bankledgerdet[0]['bankamount']+$bankbfrwrd;
				
				($bankbfrwrd < 0) ? $showpositiveamnt = '('.number_format(-1*$bankbfrwrd,2).')' : $showpositiveamnt = number_format($bankbfrwrd,2);	

				
                if ($bankamount1 < 0){
                    $bankamount = '0';
					$frmtbankamount = '';
                    $creditamnt = $bankamount1*-1;
                    $crdtamtfrmt = number_format($creditamnt,2);
                } elseif($bankamount1 >= 0){
                    $bankamount = $bankamount1;
                    $creditamnt = '';
                    $crdtamtfrmt = '';
					$frmtbankamount = number_format($bankamount,2);
                }
                if($showpositiveamnt != 0 || $frmtbankamount > 0 || $crdtamtfrmt > 0 ){
                echo "<tr><td><a target='blank' href='bankledger.php?fromdate=$startdte1&todate=$endate&bnkact=$bankid'>&nbsp;&nbsp;&nbsp;".($bankame)."</a></td><td></td><td class='right noExl' style='display: none'>".$showpositiveamnt." </td><td></td><td class='right'>$frmtbankamount</td><td></td><td class='right'>$crdtamtfrmt</td></tr>";
                //echo "<tr><td style='height:25px'><a target='blank' href='../estates/sabil_statement.php?param=debtor&start=$from_date&end=$to_date&debtor=$debtid&account='>*</a></td><td>$dname</td><td class='right'>".number_format($sumd[$j]['amount'],2)."$space</td><td class='right'>".number_format($dapaid,2)."$space</td><td class='right'>".number_format($dabalance,2)."&nbsp&nbsp&nbsp</td></tr>";
}else{}
                $bankactotal = $bankactotal + $bankamount;
                $bankbbftotatl = $bankbbftotatl +$bankbfrwrd;
				$bankcreditamnt = $creditamnt + $bankcreditamnt;
          }
           $bbfun =$mumin->getdbContent("SELECT SUM(amount) as amount,tno FROM recptrans WHERE rdate  < '$startdte1'  AND date(depots) > rdate AND date(depots) > '$startdte1'  AND isdeposited <> '0'  AND est_id LIKE '$estId' "); 
          $bbfundepr =$mumin->getdbContent("SELECT SUM(amount) as amount,tno FROM recptrans WHERE rdate BETWEEN '$startdte1' AND '$endate' AND date(depots) > rdate AND date(depots) > '$endate'  AND isdeposited <> '0'  AND est_id LIKE '$estId' ");
           $bbfundep =  "SELECT SUM(amount) as amount,tno FROM recptrans WHERE isdeposited = '0' AND rdate < '$startdte1' AND est_id LIKE '$estId' ";
           $query87 =  "SELECT SUM(amount) as amount,tno FROM recptrans WHERE isdeposited = '0' AND rdate BETWEEN '$startdte1' AND '$endate' AND est_id LIKE '$estId' ";
        $result87=$mumin->getdbContent($query87);
        $resultund = $mumin->getdbContent($bbfundep);
        $bbfundepo = $resultund[0]['amount'];
                 $undepo7 = $result87[0]['amount']+$bbfundepo + $bbfundepr[0]['amount']+$bbfun[0]['amount'];
                 
                 if($undepo7 == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 }
      echo '<tr style="height: 25px;'.$disply.'"><td>Undeposited Funds</td><td></td><td class="right noExl" style="display: none">'.number_format($bbfundepo,2).'</td><td></td><td class="right">'.number_format($undepo7,2).'</td><td></td><td class="right"></td> </tr>';          
  
      $grantotal = 0;
     echo "<tr><td colspan='3'><span class='headin'><b>Income &nbsp;&nbsp;&nbsp;</b></span></td><td colspan='5'></td></tr>";
             $wqry =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$estId' GROUP BY incomeaccounts.incacc"); //Income accounts
            
      for($t=0;$t<count($wqry);$t++){
          $actname = $wqry[$t]['accname'];
          $actid = $wqry[$t]['incacc'];
           
          $incmamnt = $mumin->getdbContent("SELECT SUM(debitamount) AS debitamount , SUM(creditamnt) AS creditamnt FROM (SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  invoice WHERE incacc='$actid'  AND estId = '$estId' AND idate BETWEEN '$startdte1' AND '$endate' UNION
                                            SELECT SUM(cramount) as debitamount , sum(dramount) as cramount  FROM `journals` WHERE tbl = 'I' and acc = '$actid' and type = 'I' AND jdate BETWEEN '$startdte1' AND '$endate' AND deptid = '$estId') T6 ");      
       
          $credtamnt = $incmamnt[0]['debitamount'] - $incmamnt[0]['creditamnt'];
         if($credtamnt != 0){
          echo "<tr><td><a target='blank' href='incomedetails.php?fromdate=$startdte1&todate=$endate&incmact=$actid'>&nbsp;&nbsp;&nbsp;&nbsp;".$actname."</a></td><td></td><td style='display: none' class='noExl'></td><td></td><td></td><td></td><td class='right'>".number_format($credtamnt,2)."</td></tr>";
         }else{
             
         }
          $incmetotal = $credtamnt+$incmetotal;
        }
		
            $qryz =$mumin->getdbContent("SELECT * FROM  incomeaccounts WHERE typ = 'G' "); //grant
                for($i=0;$i<count($qryz);$i++){
                    $amntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate BETWEEN '$startdte1' AND '$endate' AND estId = '$estId' AND crdtacc = '".$qryz[$i]['incacc']."')t5 ");
                    $amnt = $amntqry[0]['amount'];
                    if($amnt == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 
                 }
          echo '<tr style="height: 25px;'.$disply.'"><td><a target="blank" href="grantdetails.php?fromdate='.$startdte1.'&todate='.$endate.'&incmgact='.$qryz[$i]['incacc'].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$qryz[$i]['accname'].'</a></td>  <td></td><td style="display: none" class="noExl"></td><td></td><td></td><td></td><td class="right">'.number_format($amnt,2).'</td> </tr>';          
          $grantotal = $grantotal + $amnt;      
                          }
      
        
            //GRANT + INCOME - EXPENSE
            $amntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate < '$startdte1' AND estId = '$estId' AND crdtacc IN (SELECT incacc FROM incomeaccounts WHERE typ = 'G') )t5 ");
                    $grant = $amntqry[0]['amount'];
                $incmeqry = $mumin->getdbContent("SELECT sum(debitamount) as debitamount,sum(creditamnt) as creditamnt FROM (SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  invoice WHERE estId = '$estId' AND idate < '$startdte1' UNION 
                                                  SELECT SUM(cramount) as debitamount , sum(dramount) as cramount  FROM `journals` WHERE tbl = 'I' and type = 'I' AND jdate < '$startdte1' AND deptid = '$estId') T6");
                    $income = $incmeqry[0]['debitamount'] - $incmeqry[0]['creditamnt'];
                $expensegry = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT sum(IF(isinvce ='1',amount,amount*-1)) as debitamnt,id FROM  bills WHERE estate_id = '$estId' AND bdate < '$startdte1' UNION
                                                    SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  < '$startdte1'  AND deptid = '$estId' UNION
                                                    SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsmbrs` WHERE tbl = 'E' and type = 'E' AND jdate  < '$startdte1'  AND deptid = '$estId' UNION
                                                    SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsupplrs` WHERE tbl = 'E' and type = 'E' AND jdate  < '$startdte1'  AND deptid = '$estId' UNION
                                                    SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate < '$startdte1' AND estate_id= '$estId')t7 WHERE expacc IN (SELECT id FROM  expnseaccs))T6");
                        $expense = $expensegry[0]['debitamnt'];
                $opbalrearnings =  $mumin->getdbContent("SELECT amount FROM r_earningsbf");     //Get difference in R.Earnings i.e 9510523.32 minus 7842468 (Audited Figure in 2010)
  
                       $retainexp = ($grant + $income  - $expense -$opbalrearnings[0]['amount'])*-1;
                       if($retainexp <= 0){
                            $showcreditexp = number_format(-1*$retainexp,2);
                            $showdebitexp = '';
                            $addcreditretainexp = -1*$retainexp;
                            $adddebitretainexp = 0;
                            $disply = '';
                       }elseif($retainexp > 0){
                           $showdebitexp = number_format($retainexp,2);
                           $showcreditexp = '';
                           $addcreditretainexp = 0;
                            $adddebitretainexp = $retainexp;
                            $disply = '';
                       }
                       
                       
          echo '<tr style="height: 25px;'.$disply.'"><td>Retained Earnings B/F</td><td></td><td  style="display:none" class="noExl"></td><td></td><td class="right">'.$showdebitexp.'</td><td></td><td class="right">'.$showcreditexp.'</td> </tr>';          
                $assetstotal = 0;
            echo "<tr><td colspan='6'><span class='headin'><b>Assets &nbsp;&nbsp;&nbsp;</b></span></td></tr>";            // Calculate assets
             $qury =$mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname,opbal FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' AND expnseaccs.type = 'A' GROUP BY expnseaccs.id order by accname "); //Expense accounts
                        for($l=0;$l<count($qury);$l++){
                $assetsqry = $mumin->getdbContent("SELECT SUM(dramount) as debitamount , sum(cramount) as cramount  FROM `journals` WHERE tbl = 'E' and type = 'A' AND acc = ".$qury[$l]['id']." AND jdate  <='$endate' AND deptid = '$estId'");
                $expenseastamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  bills WHERE expenseacc = ".$qury[$l]['id']."  AND estate_id = '$estId' AND bdate <= '$endate' UNION
                                                     SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate <= '$endate' AND estate_id= '$estId' )t7 WHERE expacc = ".$qury[$l]['id']." )T6");

                $assetsamnt = $assetsqry[0]['debitamount'] - $assetsqry[0]['cramount'];
                $debitamt4= $expenseastamnt[0]['debitamnt'];
                $accname = $qury[$l]['accname'];
                $accid = $qury[$l]['id'];
                $opbal = $qury[$l]['opbal']+$assetsamnt +  $debitamt4;
                echo "<tr><td><a target='blank' href='assets.php?startdate=$startdte1&enddate=$endate&assetid=$accid'> &nbsp;&nbsp;$accname</a></td><td></td><td></td><td class='right'>".  number_format($opbal,2)."</td><td colspan='2'></td></tr>";           
                    $assetstotal = $assetstotal + $opbal;
                }
                $depreciationtotal = 0;
             $wry =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname,opbal FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'D' AND incomeactmgnt.deptid = '$estId' GROUP BY incomeaccounts.incacc order by accname"); //Income accounts
                       for($x=0;$x<count($wry);$x++){
                $depreciationqry = $mumin->getdbContent("SELECT SUM(dramount) as debitamount , sum(cramount) as cramount  FROM `journals` WHERE tbl = 'I' and type = 'D' AND acc = ".$wry[$x]['incacc']." AND jdate  <= '$endate' AND deptid = '$estId'");
                $depreciationamnt = $depreciationqry[0]['cramount'] - $depreciationqry[0]['debitamount'];           
                $accnme = $wry[$x]['accname'];
                $acci = $wry[$x]['incacc'];
                $dopbal = $wry[$x]['opbal'] + $depreciationamnt;
                echo "<tr><td><a target='blank' href='depreciationstmnt.php?startdate=$startdte1&enddate=$endate&depreciationid=$acci'>&nbsp;&nbsp;$accnme</td><td></td><td></td><td></td><td></td><td class='right'>".  number_format($dopbal,2)."</td></tr>";           
                   $depreciationtotal = $depreciationtotal + $dopbal;
                
                       }
                       $liabiltiestotl = 0; $liabiltiesdebittotl = 0;
             echo "<tr><td colspan='6'><span class='headin'><b>Liabilities &nbsp;&nbsp;&nbsp;</b></span></td></tr>";
             $wryincme =$mumin->getdbContent("SELECT incomeaccounts.incacc,incomeaccounts.accname,opbal FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'L' AND incomeactmgnt.deptid = '$estId' GROUP BY incomeaccounts.incacc order by accname"); //Income accounts
                       for($u=0;$u<count($wryincme);$u++){
                           $lamntqry = $mumin->getdbContent("SELECT sum(crdtamnt)-sum(dbtamnt) as amount  FROM (SELECT IF(dbacc='0',amount,'0') as dbtamnt,IF(cbacc='0',amount,'0') as crdtamnt,tno FROM jentry WHERE jdate <= '$endate' AND estId = '$estId' AND (crdtacc = '".$wryincme[$u]['incacc']."' OR dbtacc = '".$wryincme[$u]['incacc']."') UNION SELECT SUM(dramount) as debitamount , sum(cramount) as cramount,tno  FROM `journals` WHERE tbl = 'I' and type = 'L' AND acc = ".$wryincme[$u]['incacc']." AND jdate  <= '$endate' AND deptid = '$estId')t5 ");
                $lamnt = $lamntqry[0]['amount'];
                $laccnme = $wryincme[$u]['accname'];
                $acci = $wryincme[$u]['incacc'];
                $loanopbal = $wryincme[$u]['opbal']+$lamnt;
                 if($loanopbal == 0){
                 $disply = 'display:none;';
                 }else{
                 $disply = '';
                 
                 }
                 if($loanopbal < 0){
                echo "<tr style=".$disply."><td><a target='blank' href='loanacctstatmnt.php?startdate=$startdte1&enddate=$endate&loanactid=$acci'> &nbsp;&nbsp;$laccnme</a></td><td></td><td></td><td  class='right'>".number_format($loanopbal*-1,2)."</td><td></td><td></td></tr>";           
                    $liabiltiesdebittotl = $liabiltiesdebittotl +  $loanopbal*-1;
                     
                 }else{
                echo "<tr style=".$disply."><td><a target='blank' href='loanacctstatmnt.php?startdate=$startdte1&enddate=$endate&loanactid=$acci'> &nbsp;&nbsp;$laccnme</a></td><td></td><td></td><td></td><td></td><td class='right'>".number_format($loanopbal,2)."</td></tr>";           
                    $liabiltiestotl = $liabiltiestotl +  $loanopbal;
                       }
                       }
             echo "<tr><td colspan='6'><span class='headin'><b>Debtors &nbsp;&nbsp;&nbsp;</b></span></td></tr>";
            
                       
                         $qry3= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount ,tno FROM invoice WHERE  estId LIKE '$estId'  AND idate < '$startdte1'   UNION 
                    SELECT (SUM(amount))*-1 as amount,tno  FROM recptrans WHERE est_id LIKE '$estId' AND rdate < '$startdte1' UNION
                     SELECT sum(dramount) - sum(cramount) as amount,tno FROM bad_debtsmbrs WHERE deptid = '$estId'  AND jdate < '$startdte1' AND (tbl = 'M' OR tbl = 'D')) t1";
                    $bbf =$mumin->getdbContent($qry3);   
                        
                      $sumd =$mumin->getdbContent(
                       "SELECT sum(amount) as amount,sum(paid) as paid FROM (SELECT sum(IF(isinvce='1',amount,amount*-1))as amount,'0' as paid,sabilno,hofej FROM invoice WHERE  estId LIKE '$estId' AND idate BETWEEN '$startdte1' AND '$endate' UNION
                                                                              SELECT sum(dramount) - sum(cramount) as amount ,'0' as paid,acc,type FROM bad_debtsmbrs WHERE deptid = '$estId' AND jdate BETWEEN '$startdte1' AND '$endate'  AND (tbl = 'M' OR tbl = 'D') UNION
                            SELECT '0' as amount,SUM(amount)as paid,sabilno,hofej FROM recptrans WHERE rdate BETWEEN '$startdte1' AND '$endate' AND est_id LIKE '$estId' )t4");
                      //SELECT (amount-(crdtamnt+paid)) as dbtramount FROM (SELECT SUM(IF(isinvce='1',amount,'0')) as amount,SUM(IF(isinvce='0',amount,'0')) as crdtamnt,sum(pdamount)as paid FROM estate_invoice WHERE idate BETWEEN '$startdte1' AND '$endate' AND estId ='$estId')t9
                  
                            $bbfamount = $bbf[0]['bbfamnt'];
                           $dbtramount = $bbfamount+$sumd[0]['amount'] - $sumd[0]['paid']; 
                           
						   ($bbfamount < 0) ? $showdebtor = '('.number_format(-1*$bbfamount,2).')' : $showdebtor = number_format($bbfamount,2);	
							if ($dbtramount < 0){
                    $showdebit = '';
					$showcredit = number_format($dbtramount*-1,2);
                    $addcredit = $dbtramount*-1;
					$adddebit ='';
                } elseif($dbtramount >= 0){
                    $showdebit = number_format($dbtramount,2);
                    $showcredit = '';
                    $addcredit = '';
					$adddebit =$dbtramount;
                }
       echo "<tr><td><a target='blank' href='debtorsummary.php?dstartdate=$startdte1&denddate=$endate&incmeacct=all'> &nbsp;&nbsp;Accounts Receivable</a></td><td></td><td class='right noExl' style='display: none'>".$showdebtor."</td><td></td><td class='right'>".$showdebit."</td><td >  </td><td class='right'>$showcredit</td></tr>"; 
                           
     echo "<tr><td colspan='6'><span class='headin'><b>Creditors &nbsp;&nbsp;&nbsp;</b></span></td></tr>";
     
         
                $sumq = $mumin->getdbContent("SELECT SUM(amount) as bbf from (SELECT sum(IF(isinvce ='1', amount,(amount)*-1)) as amount,id FROM bills where estate_id='$estId'  and bdate < '$startdte1' UNION 
						 SELECT (sum(cramount) - sum(dramount)) as amount,tno FROM bad_debtsupplrs WHERE deptid = '$estId' AND jdate < '$startdte1' AND  tbl = 'S' UNION		
                                               SELECT (SUM(amount))*-1 as amount,tno  FROM paytrans WHERE  estId = '$estId' AND pdate < '$startdte1') T2");

        $supqr=$mumin->getdbContent("SELECT sum(creditamt) as creditamt, sum(debitamnt) as debitamnt FROM (SELECT if(isinvce='1',amount,0) as debitamnt,if(isinvce='0',amount,0) as creditamt,id FROM bills WHERE estate_id='$estId' AND bdate BETWEEN '$startdte1' AND '$endate' UNION
                    SELECT if(cramount <> '0.00',cramount,0) as creditamt,if(dramount <> '0.00',dramount, 0) as debitamnt ,tno FROM bad_debtsupplrs WHERE deptid = '$estId' AND jdate BETWEEN '$startdte1' AND '$endate'  AND tbl = 'S' UNION
                    SELECT  IF(amount<0,-1*amount,0)as creditamt, IF(amount>0,amount,0)as debitamnt,tno FROM paytrans WHERE estId='$estId'  AND pdate BETWEEN '$startdte1' AND '$endate')T4");
        
         $bbfowardamt = $sumq[0]['bbf']*-1;
            $creditoramnt = $sumq[0]['bbf']+$supqr[0]['debitamnt'] - $supqr[0]['creditamt'];
            
			($bbfowardamt < 0) ? $showcreditor = '('.number_format(-1*$bbfowardamt,2).')' : $showcreditor = number_format($bbfowardamt,2);	
			if ($creditoramnt < 0){
                    $shdebit = number_format($creditoramnt*-1,2);
					$shcredit = '';
                    $adcredit = '';
					$addebit =$creditoramnt*-1;
                } elseif($creditoramnt >= 0){
                    $shdebit = '';
                    $shcredit = number_format($creditoramnt,2);
                    $adcredit = $creditoramnt;
					$addebit ='';
                }
     echo "<tr><td><a target='blank' href='suppsummary.php?fromdate=$startdte1&enddate=$endate'> &nbsp;&nbsp;Accounts Payable</a></td><td></td><td class='right noExl' style='display: none'>".$showcreditor."</td><td></td><td class='right'> $shdebit </td><td></td><td class='right'>".$shcredit."</td></tr>"; 

     echo "<tr><td colspan='6'><span class='headin'><b>Expense &nbsp;&nbsp;&nbsp;</b></span></td></tr>";
            $eqry =$mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' AND type = 'E' GROUP BY expnseaccs.id order by accname "); //Expense accounts
              for($i=0;$i<count($eqry);$i++){
          $accname = $eqry[$i]['accname'];
          $accid = $eqry[$i]['id'];
          
          $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  bills WHERE expenseacc ='$accid'  AND estate_id = '$estId' AND bdate BETWEEN '$startdte1' AND '$endate' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$startdte1' AND '$endate' AND deptid = '$estId' AND acc = '$accid' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount) as debitamnt,tno FROM bad_debtsmbrs WHERE tbl = 'E' and type = 'E' AND jdate BETWEEN '$startdte1' AND '$endate' AND deptid = '$estId'  AND acc = '$accid'  UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount) as debitamnt,tno FROM bad_debtsupplrs WHERE tbl = 'E' and type = 'E' AND jdate BETWEEN '$startdte1' AND '$endate' AND deptid = '$estId'  AND acc = '$accid'  UNION
                                                SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate BETWEEN '$startdte1' AND '$endate' AND estate_id= '$estId' )t7 WHERE expacc = '$accid' )T6");
          
          $debitamt= $expenseamnt[0]['debitamnt'];
           if($debitamt != 0){
          echo "<tr style='height: 20px'><td><a target='blank' href='expensedtails.php?fromdate=$startdte1&enddate=$endate&expactid=$accid'>&nbsp;&nbsp;&nbsp;&nbsp;".$accname."</a></td> <td style='display: none' class='noExl'></td><td></td> <td></td><td class='right'>".number_format($debitamt,2)."</td><td></td> <td></td></tr>";
         }else{
             //leave blank if expense account has no value
         }
          $expnsetotal = $debitamt + $expnsetotal;
      }
            $creditoramntotal = $incmetotal+$adcredit+$grantotal+$bankcreditamnt+$addcredit+$addcreditretainexp+$depreciationtotal+$liabiltiestotl;                           
       $debittotal= $bankactotal+$expnsetotal+$adddebit+$addebit+$undepo7+$adddebitretainexp+$assetstotal+$liabiltiesdebittotl;
       $sumbbf = $bankbbftotatl + $retainexp + $bbfamount  + $bbfowardamt+$bbfundepo;
echo'<tr><td><b></b></td><td></td><td class="right noExl" style="border-top: 1px solid; display: none "><b>'.number_format($sumbbf,2).'</b></td><td></td><td class="right" style="border-top: 1px solid;border-bottom: 1px solid;"><b>'.number_format($debittotal,2).'</b></td><td></td><td class="right" style="border-top: 1px solid;border-bottom: 1px solid;" ><b>'.number_format($creditoramntotal,2).'</b></td></tr>';
echo '<td colspan=7><hr/></td>';
echo'</tbody></table>';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div>';
//echo '<div style="page-break-after:always"> </div>';
        
        
?>
          
 <!-- <table class="ordinal" style="border: none;width: 100%"><tr style="border-top: 3px solid #000"><td><h5>This statement is computer generated and hence valid without stamp or signature</h5></td> </tr></table>-->
          
 
</body>
    
</html>