<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level!=1){
  
        header("location: index.php"); 
        
    }
    
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Admin Report</title>
    
 
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
    
    
<style>
    #report5{
         border: #8F5B00 solid 3px;
    border-collapse:collapse;
    }
    #report5 td{
        height: 25px;
        border: #8F5B00 solid 1px;
    }
     #report6{
         border: #379AA4 solid 3px;
    border-collapse:collapse;
    }
    #report6 td{
        height: 25px;
        border: #4f6d81 solid 1px;
    }
    
    a {
      text-decoration:none;
   }
    a:hover {text-decoration:underline;}
    @media print
{ 
 a {
      text-decoration:none;
   }
   #printNot {display:none}
}
</style>

<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;">

<div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();" id="prntst"><span><span><span class="print">Print Report</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();" id="closest"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

<?php
$startdate = $_GET['startdate'];
$from_date = date('Y-m-d',  strtotime($startdate));
$to_date1 = $_GET['todate'];
$to_date = date('Y-m-d',  strtotime($to_date1));
$id=$_SESSION['est_prop'];

//$user=$_SESSION['usname'];
include 'operations/Mumin.php';
$mumin=new Mumin();

?>
 <div id="printableArea">

<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp; Ajuman-e-Burhani &nbsp;</font></i></b><br />
<span style="font-size:75%">&nbsp;P.O Box 81766-80100, Tel: 020-2040372,Mombasa,Kenya <br>
Mobile: 0715609990, Email: jims@msajamaat.org 
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="100" /></img> </td>
</tr> 
</table>
<div align="center"><font size="5"><b>CONTRIBUTION SUMMARY</font></b> </div>
<hr />
<div><table id="report">
<tr><td> &nbsp;&nbsp;&nbsp;From&nbsp; <b><?php echo "$startdate"; ?></b>&nbsp; to &nbsp;<b><?php echo "$to_date1"; ?></b></td><td align=right></td></tr>
</table></div>
<hr />
<br />

<table id="report5" style="width:100%" cellpading=4>
    <?php
    $rsl = $mumin->getdbContent("SELECT distinct(moh) AS moh FROM mumin ORDER BY moh ASC");
    $wqw =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE typ = 'I'");

    ?>
    <thead style="height: 25px;"> <tr bgcolor="#FDF5CE"><th style="text-align:center; width: 100%;" colspan="<?php echo count($wqw)*4+1;?>"> INCOME</th></tr></thead>
<tbody>
                    <?php 
                    
                    $totalamount = 0; $totalpaid = 0; $totalbalance= 0 ; $totaldamount = 0; $totaldpaid = 0; $totaldbalance= 0 ;
                    //$rslt =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej,hseno FROM (SELECT mumin.sabilno ,mumin.hofej,hseno,IF(isinvce='1' and incacc='$incmeactid',estate_invoice.amount,0) as amount,IF(isinvce='0' AND incacc='$incmeactid',estate_invoice.amount,0) as paid FROM  mumin LEFT JOIN estate_invoice ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND  idate BETWEEN '$from_date' AND '$to_date'   UNION
                      //                           SELECT mumin.sabilno ,mumin.hofej,hseno,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount<0,-1*amount,0) as amount,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount>0,amount,0) as paid FROM  mumin LEFT JOIN estates_recptrans ON estates_recptrans.sabilno = mumin.sabilno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno  ORDER BY sabilno)t9 GROUP BY sabilno");
                        //$rsl =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',amount,0)) as amount,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',paid,0)) as paid from 
                         //   (SELECT mumin.sabilno,mumin.sector ,mumin.hofej,hseno,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid FROM  estate_invoice RIGHT JOIN  mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno)T8 GROUP BY sector ");
                         						// $rsl = $mumin->getdbContent("SELECT distinct(moh) AS moh FROM mumin ORDER BY moh ASC");
                                                                        // $wqw =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE typ = 'I'");
                                                                         echo '<tr><td rowspan="2" style="text-align:center;font-weight: bold">Mohalla</td>';
                                   for ($t=0;$t<count($wqw);$t++){
                                 echo '<td colspan="3" style="text-align: center;">'.$wqw[$t]['accname'].'</td>';
                             }   
                           echo '<td colspan="3" style="text-align: center;">Totals</td></tr>';
                                                                         echo '<tr>';                  
                                    for ($t=0;$t<count($wqw);$t++){
                                 echo '<td style="text-align: center;">Invoiced &nbsp</td><td style="text-align: center;">Received &nbsp</td><td style="text-align: center;">Balance &nbsp</td>';
                             }
                             echo '<td style="text-align: center;">Invoiced</td><td style="text-align: center;">Received</td><td style="text-align: center;">Balance</td></tr>';
                         for($j=0;$j<count($rsl);$j++){
					 $totalamount5 = 0; $totalrecvd = 0; $totalbalnce = 0; 
						                         						
                      echo '<tr><td><a href="#">&nbsp;&nbsp;'.$rsl[$j]['moh'].'<a></td>';
                                            for ($t=0;$t<count($wqw);$t++){
                                                $rsl2 = $mumin->getdbContent("SELECT sum(amount) as amount from 
						 (SELECT if(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1)as amount,tno,incacc,idate FROM  estate_invoice where estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '".$wqw[$t]['incacc']."'  AND idate between '$from_date' AND '$to_date' ) as t5");
							
						//$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND recpno IN (SELECT recpno FROM estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' and sector = '".$rsl[$j]['sector']."' AND rev = '0') AND idate BETWEEN '$from_date' AND '$to_date' UNION
						//SELECT amount*-1 as amount,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND idate BETWEEN '$from_date' AND '$to_date' and sector = '".$rsl[$j]['sector']."' AND recpno > 0) UNION
						//SELECT invceamnt as amount, tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = '$incmeactid' and isinvce = '1' AND estId = '$id'  AND idate between '$from_date AND '$to_date' and sector = '".$rsl[$j]['sector']."') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' AND rev = '0' and sector = '".$rsl[$j]['sector']."') t6");
						//$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId IN (SELECT //est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '".$wqw[$t]['incacc']."' and isinvce = '1' AND recpno IN (SELECT recpno FROM //estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE 	mohalla = '".$rsl[$j]['moh']."')  AND rev = //'0') AND idate BETWEEN '$from_date' AND '$to_date' UNION
	//					SELECT amount*-1 ,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId IN //SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '".$wqw[$t]['incacc']."' and isinvce = '1' AND idate BETWEEN '$from_date' AND //'$to_date' AND recpno > 0) and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') UNION
	//					SELECT invceamnt , tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = //'".$wqw[$t]['incacc']."' and isinvce = '1' AND estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND idate between '$from_date' AND //'$to_date') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND rev = '0') t6");	

$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM estates_recptrans WHERE  rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND incacc = '".$wqw[$t]['incacc']."' ");
                                                    $bal = $rsl2[0]['amount'] - $rsl5[0]['paid'];
                                                    $totalamount5 = $totalamount5 + $rsl2[0]['amount'];
                                                    $totalrecvd =   $totalrecvd + $rsl5[0]['paid'];
                                                     $totalbalnce =  $totalbalnce + $bal;
                                 echo '<td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($rsl2[0]['amount'],2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($rsl5[0]['paid'],2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($bal,2).'</td>';
                             }
                             echo '<td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalamount5,2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalrecvd,2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalbalnce,2).'</td></tr>';
                                                }
                                                 
                       // echo ' <td style="text-align:right">'.number_format($rsl2[0]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rsl5[0]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal,2).'&nbsp;&nbsp;</td></tr>';    
                        			
						

                        ?>
        
<td colspan="<?php echo count($wqw)*4+1;?>" style="height:2px"></td>
<tr><td><b>Totals</b>
        <?php
        for ($u=0;$u<count($wqw);$u++){
             $totalpaidamnt = 0; $totalamntivcd = 0;    $totalbal = 0;
            for($j=0;$j<count($rsl);$j++){
                $rsl3 = $mumin->getdbContent("SELECT sum(amount) as amount from 
						 (SELECT if(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1)as amount,tno,incacc,idate FROM  estate_invoice where estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '".$wqw[$u]['incacc']."'  AND idate between '$from_date' AND '$to_date' ) as t5");
							
		$rsl89 = $mumin->getdbContent("SELECT sum(amount) as paid FROM estates_recptrans WHERE  rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND incacc = '".$wqw[$u]['incacc']."'");	

               $totalpaidamnt = $totalpaidamnt + $rsl89[0]['paid'];
               $totalamntivcd = $totalamntivcd + $rsl3[0]['amount'];
               $bal4 = $rsl3[0]['amount'] - $rsl89[0]['paid'];
               $totalbal = $totalbal + $bal4;
            }
           
            					
 echo   '</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalamntivcd,2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalpaidamnt,2).'</td><td style="text-align: right;padding-right:10px;padding-left:5px">'.number_format($totalbal,2).'</td>';
}
echo '<td></td><td></td><td></td>';
?>
        </tr>
<td colspan="<?php echo count($wqw)*4+1;?>" bgcolor="#357918" style="height:5px"></td>
</tbody></table><br/>


 <br /><br />
 
<table id="report6" style="width:100%" cellpading=4>
    <?php
      $qrydtails =$mumin->getdbContent("SELECT * FROM  estate_expaccs  WHERE id IN (select expenseacc FROM estate_bills) ");

    ?>
    <thead style="height: 25px;"> <tr bgcolor="grey"><th style="text-align:center; width: 100%;" colspan="<?php echo count($wqw)*4+1;?>"> EXPENSE</th></tr></thead>
<tbody>
                    <?php 
                    $totalamount = 0; $totalpaid = 0; $totalbalance= 0 ; $totaldamount = 0; $totaldpaid = 0; $totaldbalance= 0 ;
                    //$rslt =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej,hseno FROM (SELECT mumin.sabilno ,mumin.hofej,hseno,IF(isinvce='1' and incacc='$incmeactid',estate_invoice.amount,0) as amount,IF(isinvce='0' AND incacc='$incmeactid',estate_invoice.amount,0) as paid FROM  mumin LEFT JOIN estate_invoice ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND  idate BETWEEN '$from_date' AND '$to_date'   UNION
                      //                           SELECT mumin.sabilno ,mumin.hofej,hseno,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount<0,-1*amount,0) as amount,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount>0,amount,0) as paid FROM  mumin LEFT JOIN estates_recptrans ON estates_recptrans.sabilno = mumin.sabilno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno  ORDER BY sabilno)t9 GROUP BY sabilno");
                        //$rsl =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',amount,0)) as amount,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',paid,0)) as paid from 
                         //   (SELECT mumin.sabilno,mumin.sector ,mumin.hofej,hseno,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid FROM  estate_invoice RIGHT JOIN  mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno)T8 GROUP BY sector ");
                         				 echo '<tr><td rowspan="2" style="text-align:center;font-weight: bold">Mohalla</td>';
                                   for ($t=0;$t<count($qrydtails);$t++){
                                 echo '<td colspan="3" style="text-align: center;">'.$qrydtails[$t]['accname'].'</td>';
                             }   
                           echo '<td colspan="3" style="text-align: center;">Totals</td></tr>';
                                                                         echo '<tr>';                  
                                    for ($t=0;$t<count($qrydtails);$t++){
                                 echo '<td style="text-align: center;">Billed</td><td style="text-align: center;">Paid</td><td style="text-align: center;">Balance</td>';
                             }
                             echo '<td style="text-align: center;">Billed</td><td style="text-align: center;">Paid</td><td style="text-align: center;">Balance</td></tr>';
                         for($j=0;$j<count($rsl);$j++){
					 $totalamount6 = 0; $totalrecvd1 = 0; $totalbalnce1 = 0; 
						                         						
                      echo '<tr><td><a href="#">&nbsp;&nbsp;'.$rsl[$j]['moh'].'<a></td>';
                                            for ($t=0;$t<count($qrydtails);$t++){
                                               
                                                $rsltamnt = $mumin->getdbContent("SELECT sum(debitamnt) as amount FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  estate_bills WHERE expenseacc = '".$qrydtails[$t]['id']."'  AND estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND bdate BETWEEN '$from_date' AND '$to_date') AS T2");
                                                
						$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,id FROM estate_bills WHERE estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND  expenseacc = '".$qrydtails[$t]['id']."' and isinvce = '1' AND payno IN (SELECT payno FROM estate_paytrans WHERE pdate BETWEEN '$from_date' AND '$to_date' and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."')  AND rev = '0') AND bdate BETWEEN '$from_date' AND '$to_date' UNION
						SELECT amount*-1 ,id FROM estate_bills WHERE isinvce = '0' AND crdtinvce IN (SELECT docno FROM estate_bills WHERE estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND expenseacc  = '".$qrydtails[$t]['id']."' and isinvce = '1' AND bdate BETWEEN '$from_date' AND '$to_date' AND payno > 0) and  estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') UNION
						SELECT amount , tno FROM estate_paytrans WHERE billsettled IN (SELECT docno FROM estate_bills WHERE 	expenseacc = '".$qrydtails[$t]['id']."' and isinvce = '1' AND estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND bdate between '$from_date' AND '$to_date') AND  pdate BETWEEN '$from_date' AND '$to_date' and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND rev = '0') t6");	
                                                    $bal = $rsltamnt[0]['amount'] - $rsl5[0]['paid'];
                                                    $totalamount6 = $totalamount6 + $rsltamnt[0]['amount'];
                                                    $totalrecvd1 =   $totalrecvd1 + $rsl5[0]['paid'];
                                                    $totalbalnce1 =  $totalbalnce1 + $bal;
                                                    
                                 echo '<td style="text-align: right;">&nbsp'.number_format($rsltamnt[0]['amount'],2).'&nbsp&nbsp&nbsp</td><td style="text-align: right;">&nbsp'.number_format($rsl5[0]['paid'],2).'&nbsp&nbsp&nbsp</td><td style="text-align: right;">&nbsp'.number_format($bal,2).'&nbsp&nbsp&nbsp</td>';
                             }
                             echo '<td style="text-align: right;">&nbsp'.number_format($totalamount6,2).'&nbsp&nbsp</td><td style="text-align: right;">&nbsp'.number_format($totalrecvd1,2).'&nbsp&nbsp</td><td>&nbsp'.number_format($totalbalnce1,2).'&nbsp&nbsp</td></tr>';
                                                }
                                                 
                       // echo ' <td style="text-align:right">'.number_format($rsl2[0]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rsl5[0]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal,2).'&nbsp;&nbsp;</td></tr>';    
                        			
						

                        ?>
        
<td colspan="<?php echo count($wqw)*4+1;?>" style="height:2px"></td>
<tr><td><b>Totals</b>
        <?php
        for ($u=0;$u<count($qrydtails);$u++){
           
             $totalpdamnt = 0; $totalamntbilld = 0;    $totalbalamt = 0;
            for($j=0;$j<count($rsl);$j++){
                $rsltamnt2 = $mumin->getdbContent("SELECT sum(debitamnt) as amount FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  estate_bills WHERE expenseacc = '".$qrydtails[$u]['id']."'  AND estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND bdate BETWEEN '$from_date' AND '$to_date') AS T2");
					
		$rsl52 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,id FROM estate_bills WHERE estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND  expenseacc = '".$qrydtails[$u]['id']."' and isinvce = '1' AND payno IN (SELECT payno FROM estate_paytrans WHERE pdate BETWEEN '$from_date' AND '$to_date' and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."')  AND rev = '0') AND bdate BETWEEN '$from_date' AND '$to_date' UNION
						SELECT amount*-1 ,id FROM estate_bills WHERE isinvce = '0' AND crdtinvce IN (SELECT docno FROM estate_bills WHERE estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND expenseacc  = '".$qrydtails[$u]['id']."' and isinvce = '1' AND bdate BETWEEN '$from_date' AND '$to_date' AND payno > 0) and  estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') UNION
						SELECT amount , tno FROM estate_paytrans WHERE billsettled IN (SELECT docno FROM estate_bills WHERE 	expenseacc = '".$qrydtails[$u]['id']."' and isinvce = '1' AND estate_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND bdate between '$from_date' AND '$to_date') AND  pdate BETWEEN '$from_date' AND '$to_date' and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND rev = '0') t6");	
               $totalpdamnt = $totalpdamnt + $rsl52[0]['paid'];
               $totalamntbilld = $totalamntbilld + $rsltamnt2[0]['amount'];
               $bal5 = $rsltamnt2[0]['amount'] - $rsl52[0]['paid'];
               $totalbalamt = $totalbalamt + $bal5;
            }
           
  echo   '</td><td style="text-align:right">&nbsp;'.number_format($totalamntbilld,2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($totalpdamnt,2).'&nbsp;&nbsp;</td><td style="text-align:right">'.  number_format($totalbalamt,2).'&nbsp;&nbsp;</td>';
}
echo '<td></td><td></td><td></td>';
?>
        </tr>
<td colspan="<?php echo count($wqw)*4+1;?>" bgcolor="#357918" style="height:5px"></td>
</tbody></table>
 
 <br></br>
<span align="left" style="font-size:x-small">Printed by: <?php echo $_SESSION['uname']. date("d-m-Y H:i:s") ?></span> 

 </div> <br />


</body>
</html> 