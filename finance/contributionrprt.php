<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include './operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['incomeaccounts']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Contribution Report</title>
    
 
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
    
    
<script>

$(function() {
    

  
       
         
      
    });
 
</script>
<style>
    
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
$type = $_GET['type'];
$startdate = $_GET['startdate'];
$from_date = date('Y-m-d',  strtotime($startdate));
$to_date1 = $_GET['todate'];
$to_date = date('Y-m-d',  strtotime($to_date1));
$incmeactid =$_GET['actid'];
 $sector = $_GET['sector'];
$id=$_SESSION['est_prop'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();


$wqw =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE incacc = '$incmeactid'");


?>
 <div id="printableArea">
     <?php if($type=='list'){ ?>
     
<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp; Estate :&nbsp;<?php echo  $_SESSION['estatefullname']?></font></i></b><br />
<span style="font-size:75%">&nbsp;&nbsp; Mobile: <?php echo $_SESSION['estmobno']?>',&nbsp;&nbsp;Email: <?php echo $_SESSION['estemail']?>
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="120" /></img> </td>
</tr> 
</table>
<div align="center"><font size="5"><b>CONTRIBUTION LIST</font></b> </div>
<hr />
<div><table id="report">
<tr><td>&nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b><?php echo "".$wqw[0]['accname'].""; ?></b></td><td align=right>&nbsp;&nbsp; &nbsp;&nbsp; </td></tr>
<tr><td> From&nbsp; <b><?php echo "$startdate"; ?></b>&nbsp; to &nbsp;<b><?php echo "$to_date1"; ?></b></td><td align=right></td></tr>
</table></div>
<hr />
<br />

<table id="report" style="width:100%" cellpading=4>
    <thead style="height: 25px;"><tr><th> Sabilno</th> <th>  House No</th> <th>Sector</th> <th>Name</th><th> &nbsp;&nbsp;Pledge</th> <th> &nbsp;&nbsp;Paid</th> <th> &nbsp;&nbsp;Balance</th></tr></thead>
<tbody><tr><td colspan="7"><hr></td></tr>
                    <?php 
                    $totalamount = 0; $totalpaid = 0; $totalbalance= 0 ; $totalamount2 = 0; $totalpaid2 = 0; $totalbalance2 = 0 ;
                    //$rslt =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej,hseno FROM (SELECT mumin.sabilno ,mumin.hofej,hseno,IF(isinvce='1' and incacc='$incmeactid',estate_invoice.amount,0) as amount,IF(isinvce='0' AND incacc='$incmeactid',estate_invoice.amount,0) as paid FROM  mumin LEFT JOIN estate_invoice ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND  idate BETWEEN '$from_date' AND '$to_date'   UNION
                      //                           SELECT mumin.sabilno ,mumin.hofej,hseno,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount<0,-1*amount,0) as amount,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount>0,amount,0) as paid FROM  mumin LEFT JOIN estates_recptrans ON estates_recptrans.sabilno = mumin.sabilno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno  ORDER BY sabilno)t9 GROUP BY sabilno");
                    if($_SESSION['grp']=='EXTERNAL' && $sector == ''){
                    $rslt =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(amount) as amount,sum(paid) as paid from 
							(SELECT mumin.sabilno ,mumin.hofej,hseno,mumin.sector,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,tno FROM estate_invoice RIGHT JOIN mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND incacc = '$incmeactid' AND idate between '$from_date' AND '$to_date' AND estate_invoice.sector = '".$_SESSION['sector']."')T8 GROUP BY sabilno");
                        }
						                        elseif ($_SESSION['grp']=='MASOOL' && $sector == ''){
                           $rslt =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(amount) as amount,sum(paid) as paid from 
							(SELECT mumin.sabilno ,mumin.hofej,hseno,mumin.sector,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,tno FROM estate_invoice RIGHT JOIN mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND incacc = '$incmeactid' AND idate between '$from_date' AND '$to_date'  )T8 GROUP BY sabilno");
 
                        } elseif ($sector !== '') {
                            $rslt =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(amount) as amount,sum(paid) as paid from 
							(SELECT mumin.sabilno ,mumin.hofej,hseno,mumin.sector,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,tno FROM estate_invoice RIGHT JOIN mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND incacc = '$incmeactid' AND idate between '$from_date' AND '$to_date' AND estate_invoice.sector = '$sector')T8 GROUP BY sabilno");

                        }
                    for($j=0;$j<count($rslt);$j++){
                        $muminam = $mumin->get_MuminNames($rslt[$j]['hofej']);
                        $bal = $rslt[$j]['amount'] - $rslt[$j]['paid'];
                        echo '<tr><td>&nbsp;&nbsp;'.$rslt[$j]['sabilno'].'</td><td style="text-align:center">'.$rslt[$j]['hseno'].'</td> <td style="text-align:center">'.$rslt[$j]['sector'].'</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$muminam.'</td><td style="text-align:right">'.number_format($rslt[$j]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rslt[$j]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal,2).'&nbsp;&nbsp;</td></tr>';    
                        $totalamount = $totalamount + $rslt[$j]['amount'];
                        $totalpaid = $totalpaid + $rslt[$j]['paid'];
                        $totalbalance = $totalbalance + $bal;
                    }
                    if($_SESSION['grp']=='EXTERNAL' && $sector == ''){
                    $rslt2 =$mumin->getdbContent("SELECT IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,debtorname,estate_debtors.sabilno FROM  estate_invoice JOIN estate_debtors ON estate_invoice.dno = estate_debtors.dno WHERE estate_invoice.sector='".$_SESSION['sector']."' and estate_invoice.estId = '$id'  AND incacc='$incmeactid' AND idate between '$from_date' AND '$to_date' GROUP BY estate_debtors.dno");
                        }
                        elseif ($_SESSION['grp']=='MASOOL' && $sector == ''){
                           $rslt2 =$mumin->getdbContent("SELECT IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,debtorname,estate_debtors.sabilno FROM  estate_invoice JOIN estate_debtors ON estate_invoice.dno = estate_debtors.dno WHERE estate_invoice.estId = '$id'  AND incacc='$incmeactid' AND idate between '$from_date' AND '$to_date' GROUP BY estate_debtors.dno");
 
                        } elseif (!$sector !== '') {
                            $rslt2 =$mumin->getdbContent("SELECT IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid,debtorname,estate_debtors.sabilno FROM  estate_invoice JOIN estate_debtors ON estate_invoice.dno = estate_debtors.dno WHERE estate_invoice.sector='$sector' and estate_invoice.estId = '$id'  AND incacc='$incmeactid' AND idate between '$from_date' AND '$to_date' GROUP BY estate_debtors.dno");

                        }
                    for($j=0;$j<count($rslt2);$j++){
                         $bal2 = $rslt2[$j]['amount'] - $rslt2[$j]['paid'];
                        echo '<tr><td>&nbsp;&nbsp;'.$rslt2[$j]['sabilno'].'</td><td style="text-align:center">*</td> <td style="text-align:center">*</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$rslt2[$j]['debtorname'].'</td><td style="text-align:right">'.number_format($rslt2[$j]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rslt2[$j]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal2,2).'&nbsp;&nbsp;</td></tr>';    
                        $totalamount2 = $totalamount2 + $rslt2[$j]['amount'];
                        $totalpaid2 = $totalpaid2 + $rslt2[$j]['paid'];
                        $totalbalance2 = $totalbalance2 + $bal2;
                    }
                    $totalALamount = $totalamount2 + $totalamount;
					$totalALLpaid = $totalpaid2 + $totalpaid;
					$totalALLbalance = $totalbalance2 + $totalbalance;
                    ?>
        
<td colspan=7><hr /></td>
<tr><td><b>Totals</b></td><td></td><td></td><td></td><td style="text-align:right"><?php echo number_format($totalALamount,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalALLpaid,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalALLbalance,2);?>&nbsp;&nbsp;</td></tr>
<td colspan=7><hr /></td>
</tbody></table><br/>


<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />
<span align="left" style="font-size:x-small">Printed by:<?php  echo ''.$_SESSION['uname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). ''; ?></span> 
 <?php }
 
 
 
 elseif ($type=='summary') {
 ?>
<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp; Estate :&nbsp;<?php echo  $_SESSION['estatefullname']?></font></i></b><br />
<span style="font-size:75%">&nbsp;&nbsp; Mobile: <?php echo $_SESSION['estmobno']?>',&nbsp;&nbsp;Email: <?php echo $_SESSION['estemail']?>
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="120" /></img> </td>
</tr> 
</table>
<div align="center"><font size="5"><b>CONTRIBUTION SUMMARY</font></b> </div>
<hr />
<div><table id="report">
<tr><td>&nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b><?php echo "".$wqw[0]['accname'].""; ?></b></td><td align=right>&nbsp;&nbsp; &nbsp;&nbsp; </td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;From&nbsp; <b><?php echo "$startdate"; ?></b>&nbsp; to &nbsp;<b><?php echo "$to_date1"; ?></b></td><td align=right></td></tr>
</table></div>
<hr />
<br />

<table id="report" style="width:100%" cellpading=4>
    <thead style="height: 25px;"><tr><th style="text-align:left"> &nbsp;&nbsp;&nbsp;&nbsp;Sector</th> <th style="text-align:right">  Pledge&nbsp;&nbsp;</th> <th style="text-align:right">Paid &nbsp;&nbsp;</th ><th style="text-align:right">Balance</th> </thead>
<tbody><tr><td colspan="4"><hr></td></tr>
                    <?php 
                    $totalamount = 0; $totalpaid = 0; $totalbalance= 0 ; $totaldamount = 0; $totaldpaid = 0; $totaldbalance= 0 ;
                    //$rslt =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej,hseno FROM (SELECT mumin.sabilno ,mumin.hofej,hseno,IF(isinvce='1' and incacc='$incmeactid',estate_invoice.amount,0) as amount,IF(isinvce='0' AND incacc='$incmeactid',estate_invoice.amount,0) as paid FROM  mumin LEFT JOIN estate_invoice ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND  idate BETWEEN '$from_date' AND '$to_date'   UNION
                      //                           SELECT mumin.sabilno ,mumin.hofej,hseno,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount<0,-1*amount,0) as amount,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount>0,amount,0) as paid FROM  mumin LEFT JOIN estates_recptrans ON estates_recptrans.sabilno = mumin.sabilno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno  ORDER BY sabilno)t9 GROUP BY sabilno");
                        //$rsl =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',amount,0)) as amount,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',paid,0)) as paid from 
                         //   (SELECT mumin.sabilno,mumin.sector ,mumin.hofej,hseno,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid FROM  estate_invoice RIGHT JOIN  mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno)T8 GROUP BY sector ");
                         						 $rsl = $mumin->getdbContent("SELECT distinct(sector) AS sector FROM mumin WHERE moh = '".$_SESSION['mohalla']."'");
						 for($j=0;$j<count($rsl);$j++){
						 
						 $rsl2 = $mumin->getdbContent("SELECT sum(amount) as amount from 
						 (SELECT if(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1)as amount,tno,incacc,idate FROM  estate_invoice where estId = '$id' AND incacc = '$incmeactid'  AND idate between '$from_date' AND '$to_date' and sector = '".$rsl[$j]['sector']."') as t5");
							
						$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND recpno IN (SELECT recpno FROM estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' and sector = '".$rsl[$j]['sector']."' AND rev = '0') AND idate BETWEEN '$from_date' AND '$to_date' UNION
						SELECT amount*-1 ,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND idate BETWEEN '$from_date' AND '$to_date' and sector = '".$rsl[$j]['sector']."' AND recpno > 0) AND estId = '$id' UNION
						SELECT invceamnt , tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = '$incmeactid' and isinvce = '1' AND estId = '$id'  AND idate between '$from_date' AND '$to_date' and sector = '".$rsl[$j]['sector']."') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' AND rev = '0' and sector = '".$rsl[$j]['sector']."') t6");	

	
						                        $bal = $rsl2[0]['amount'] - $rsl5[0]['paid'];
                        echo '<tr><td><a target="blank" href="../finance/contributionrprt.php?type=list&startdate='.$startdate.'&todate='.$to_date1.'&actid='.$incmeactid.'&sector='.$rsl[$j]['sector'].'">&nbsp;&nbsp;'.$rsl[$j]['sector'].'<a></td><td style="text-align:right">'.number_format($rsl2[0]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rsl5[0]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal,2).'&nbsp;&nbsp;</td></tr>';    
                        $totalamount = $totalamount + $rsl2[0]['amount'];
                        $totalpaid = $totalpaid + $rsl5[0]['paid'];
                        $totalbalance = $totalbalance + $bal;
						
                    }
								$qryrslt = $mumin->getdbContent("SELECT distinct(dno) AS dno FROM estate_invoice WHERE estId = '$id' AND sector = ' '");
								 for($j=0;$j<count($qryrslt);$j++){
						 
						 $rsl3 = $mumin->getdbContent("SELECT sum(amount) as amount from 
						 (SELECT if(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1)as amount,tno,incacc,idate FROM  estate_invoice where estId = '$id' AND incacc = '$incmeactid'  AND idate between '$from_date' AND '$to_date' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ') as t5");
						$rsl6 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND recpno IN (SELECT recpno FROM estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ' AND rev = '0') AND idate BETWEEN '$from_date' AND '$to_date' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ' UNION
						SELECT amount*-1 ,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND idate BETWEEN '$from_date' AND '$to_date' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ' AND recpno > 0) AND estId = '$id' UNION
						SELECT invceamnt , tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = '$incmeactid' and isinvce = '1' AND estId = '$id'  AND idate between '$from_date' AND '$to_date' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' AND rev = '0' and dno = '".$qryrslt[$j]['dno']."' AND sector = ' ') t6");	

						
                        $bal3 = $rsl3[0]['amount'] - $rsl6[0]['paid'];
                             $totaldamount = $totaldamount + $rsl3[0]['amount'];
                        $totaldpaid = $totaldpaid + $rsl6[0]['paid'];
                        $totaldbalance = $totaldbalance + $bal3;
						
                    }
					echo '<tr><td>&nbsp;&nbsp;DEBTORS&nbsp;</td><td style="text-align:right">'.number_format($totaldamount,2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($totaldpaid,2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal3,2).'&nbsp;&nbsp;</td></tr>';    

						$totalALLamount = $totalamount + $totaldamount;
						$totalALLpaid = $totalpaid + $totaldpaid;
						$totalALLbalance =  $totalbalance + $totaldbalance;
                        ?>
        
<td colspan=4><hr /></td>
<tr><td><b>Totals</b></td><td style="text-align:right"><?php echo number_format($totalALLamount,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalALLpaid,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalALLbalance,2);?>&nbsp;&nbsp;</td></tr>
<td colspan=4><hr /></td>
</tbody></table><br/>


 <br /><br />
<span align="left" style="font-size:x-small">Printed by: <?php echo $_SESSION['uname']. date("d-m-Y H:i:s") ?></span> 


<?php
}
 
 ?>
 
 </div> <br />
<div style="page-break-after:always"> </div>


</body>
</html> 