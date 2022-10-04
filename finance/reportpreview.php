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
$id=$_SESSION['est_prop'];

//$user=$_SESSION['usname'];
include 'operations/Mumin.php';
$mumin=new Mumin();


$wqw =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE incacc = '$incmeactid'");


?>
 <div id="printableArea">
     <?php 
 
 
 
 if ($type=='mohallastat') {
 ?>
<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >Anjuman-e-Burhani</font></i></b><br />
<span style="font-size:75%">P.O Box 81766-800100, Tel: 020-2040372, Mombasa, Kenya<br>
        Mobile: 0733846571, Email: jims@msajamaat.org
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="100" /></img> </td>
</tr> 
</table>
<div align="center"><font size="5"><b>STATISTICS</font></b> </div>
<hr />
<div><table id="report">
<tr><td>&nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b><?php echo "".$wqw[0]['accname'].""; ?></b></td><td align=right>&nbsp;&nbsp; &nbsp;&nbsp; </td></tr>
<tr><td> &nbsp;&nbsp;&nbsp;From&nbsp; <b><?php echo "$startdate"; ?></b>&nbsp; to &nbsp;<b><?php echo "$to_date1"; ?></b></td><td align=right></td></tr>
</table></div>
<hr />
<br />

<table id="report" style="width:100%" cellpading=4>
    <thead style="height: 25px;"><tr><th style="text-align:left"> &nbsp;&nbsp;&nbsp;&nbsp</th>
            <?php
            $rsl =$mumin->getdbContent("SELECT distinct(moh) as moh from mumin ");
                $numad = count($rsl)+1;
            for($k=0;$k<count($rsl);$k++){
                    echo "<th>".$rsl[$k]['moh']."</th>";
                                        
                }
                echo '</tr></thead>';
            ?>
<tbody><tr><td colspan="<?php echo $numad;?>"><hr></td></tr>
    <tr style="background-color: #ccccff"><td>Mumineen</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(ejno) as number from mumin WHERE moh = '".$rsl[$k]['moh']."' ");
                    echo "<td style='text-align:center'>".$rsle[0]['number']."</td>";                                    
                }?></tr>
    <tr style="background-color: #cccccc"><td>Houses</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as houses from mumin WHERE moh = '".$rsl[$k]['moh']."'");
                    echo "<td style='text-align:center'>".$rsle[0]['houses']."</td>";
                    
                }?>
    </tr>
    <tr style="background-color: #ccccff"><td>Contributed</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as contributed FROM estates_recptrans WHERE rev = '0' AND sabilno in (SELECT distinct(sabilno) FROM mumin WHERE moh ='".$rsl[$k]['moh']."' ) AND rdate BETWEEN '$from_date' AND '$to_date' AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid' AND dno = '0') ") ;
                    echo "<td style='text-align:center'>".$rsle[0]['contributed']."</td>"; 
                    
                }?></tr>
    <tr style="background-color: #cccccc"><td>Not Contributed</td><?php for($k=0;$k<count($rsl);$k++){
         $rsle =$mumin->getdbContent("SELECT COUNT(DISTINCT(sabilno)) AS notcontributed FROM mumin WHERE sabilno NOT IN (SELECT distinct(sabilno) as sabilno FROM estates_recptrans WHERE rev = '0' AND sabilno in (SELECT distinct(sabilno) FROM mumin WHERE moh ='".$rsl[$k]['moh']."' ) AND rdate BETWEEN '$from_date' AND '$to_date' AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid' AND dno = '0')) AND  moh ='".$rsl[$k]['moh']."'");
                    echo "<td style='text-align:center'>".$rsle[0]['notcontributed']."</td>";                                    
                }?> 
    </tr>
     <tr ><td style="color: red">% Contributed</td><?php for($k=0;$k<count($rsl);$k++){
         $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as houses from mumin WHERE moh = '".$rsl[$k]['moh']."' ");
        $rsle1 =$mumin->getdbContent("SELECT count(distinct(sabilno)) as contributed FROM estates_recptrans WHERE rev = '0' AND sabilno in (SELECT distinct(sabilno) FROM mumin WHERE moh ='".$rsl[$k]['moh']."' ) AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid') AND rdate BETWEEN '$from_date' AND '$to_date' AND dno = '0'");
            $houseno = $rsle[0]['houses'];
            $contrbtd = $rsle1[0]['contributed'];
                    $percent = ($contrbtd / $houseno) * 100;
                   echo "<td style='text-align:center;color:red'><b>".round($percent,2)."%</b></td>";                                    
                }?> 
    </tr>               
        
<td colspan="<?php echo $numad;?>"><hr /></td>
<!--<tr><td><b>Totals</b></td><td style="text-align:right">&nbsp;&nbsp;</td><td style="text-align:right"></td><td style="text-align:right">&nbsp;&nbsp;</td></tr>-->
<td colspan="<?php echo $numad;?>"><hr /></td>
</tbody></table><br/>


 <br /><br />
<span align="left" style="font-size:x-small">Printed by: <?php echo $_SESSION['uname']. "&nbsp;&nbsp&nbsp".date("d-m-Y H:i:s") ?></span> 

<?php }
 
 elseif ($type=='adminsummary') {
 ?>
<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp; Ajuman-e-Burhani &nbsp;</font></i></b><br />
<span style="font-size:75%">&nbsp;&nbsp;P.O Box 81766-80100, Tel: 020-2040372,Mombasa,Kenya <br>
Mobile: 0715609990, Email: jims@msajamaat.org
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
    <thead style="height: 25px;"><tr><th style="text-align:left"> &nbsp;&nbsp;&nbsp;&nbsp;Mohalla</th> <th style="text-align:right">  Pledge&nbsp;&nbsp;</th> <th style="text-align:right">Paid &nbsp;&nbsp;</th ><th style="text-align:right">Balance</th> </thead>
<tbody><tr><td colspan="4"><hr></td></tr>
                    <?php 
                    $totalamount = 0; $totalpaid = 0; $totalbalance= 0 ; $totaldamount = 0; $totaldpaid = 0; $totaldbalance= 0 ;
                    //$rslt =$mumin->getdbContent("SELECT sum(amount) as amount,sum(paid) as paid,sabilno,hofej,hseno FROM (SELECT mumin.sabilno ,mumin.hofej,hseno,IF(isinvce='1' and incacc='$incmeactid',estate_invoice.amount,0) as amount,IF(isinvce='0' AND incacc='$incmeactid',estate_invoice.amount,0) as paid FROM  mumin LEFT JOIN estate_invoice ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno AND  idate BETWEEN '$from_date' AND '$to_date'   UNION
                      //                           SELECT mumin.sabilno ,mumin.hofej,hseno,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount<0,-1*amount,0) as amount,IF(rdate BETWEEN '$from_date' AND '$to_date' and amount>0,amount,0) as paid FROM  mumin LEFT JOIN estates_recptrans ON estates_recptrans.sabilno = mumin.sabilno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno  ORDER BY sabilno)t9 GROUP BY sabilno");
                        //$rsl =$mumin->getdbContent("SELECT sabilno,hofej,hseno,sector,incacc,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',amount,0)) as amount,sum(if(incacc='$incmeactid' AND idate between '$from_date' AND '$to_date',paid,0)) as paid from 
                         //   (SELECT mumin.sabilno,mumin.sector ,mumin.hofej,hseno,idate,incacc,IF(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1) as amount,IF(isinvce='0',estate_invoice.pdamount*-1,estate_invoice.pdamount) as paid FROM  estate_invoice RIGHT JOIN  mumin ON estate_invoice.hofej = mumin.ejno WHERE mumin.moh = '".$_SESSION['mohalla']."' AND mumin.hofej = mumin.ejno)T8 GROUP BY sector ");
                         						 $rsl = $mumin->getdbContent("SELECT distinct(moh) AS moh FROM mumin");
						 for($j=0;$j<count($rsl);$j++){
						 
						 $rsl2 = $mumin->getdbContent("SELECT sum(amount) as amount from 
						 (SELECT if(isinvce='1',estate_invoice.amount,estate_invoice.amount*-1)as amount,tno,incacc,idate FROM  estate_invoice where estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '$incmeactid'  AND idate between '$from_date' AND '$to_date' ) as t5");
								
						//$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND recpno IN (SELECT recpno FROM estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' and sector = '".$rsl[$j]['sector']."' AND rev = '0') AND idate BETWEEN '$from_date' AND '$to_date' UNION
						//SELECT amount*-1 as amount,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId = '$id' AND incacc = '$incmeactid' and isinvce = '1' AND idate BETWEEN '$from_date' AND '$to_date' and sector = '".$rsl[$j]['sector']."' AND recpno > 0) UNION
						//SELECT invceamnt as amount, tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = '$incmeactid' and isinvce = '1' AND estId = '$id'  AND idate between '$from_date AND '$to_date' and sector = '".$rsl[$j]['sector']."') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id = '$id' AND rev = '0' and sector = '".$rsl[$j]['sector']."') t6");
						$rsl5 = $mumin->getdbContent("SELECT sum(amount) as paid FROM (SELECT amount,tno FROM estate_invoice WHERE estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '$incmeactid' and isinvce = '1' AND recpno IN (SELECT recpno FROM estates_recptrans WHERE rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE 	mohalla = '".$rsl[$j]['moh']."')  AND rev = '0') AND idate BETWEEN '$from_date' AND '$to_date' UNION
						SELECT amount*-1 ,tno FROM estate_invoice WHERE isinvce = '0' AND crdtinvce IN (SELECT invno FROM estate_invoice WHERE estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."' ) AND incacc = '$incmeactid' and isinvce = '1' AND idate BETWEEN '$from_date' AND '$to_date' AND recpno > 0) and  estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') UNION
						SELECT invceamnt , tno FROM estates_recptrans WHERE invoicesettled IN (SELECT invno FROM estate_invoice WHERE incacc = '$incmeactid' and isinvce = '1' AND estId IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND idate between '$from_date' AND '$to_date') AND  rdate BETWEEN '$from_date' AND '$to_date' and  est_id IN (SELECT est_id FROM anjuman_estates WHERE mohalla = '".$rsl[$j]['moh']."') AND rev = '0') t6");	

                        $bal = $rsl2[0]['amount'] - $rsl5[0]['paid'];
                      echo '<tr><td><a href="#">&nbsp;&nbsp;'.$rsl[$j]['moh'].'<a></td><td style="text-align:right">'.number_format($rsl2[0]['amount'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($rsl5[0]['paid'],2).'&nbsp;&nbsp;</td><td style="text-align:right">'.number_format($bal,2).'&nbsp;&nbsp;</td></tr>';    
                        $totalamount = $totalamount + $rsl2[0]['amount'];
                        $totalpaid = $totalpaid + $rsl5[0]['paid'];
                        $totalbalance = $totalbalance + $bal;
						
						}

                        ?>
        
<td colspan=4><hr /></td>
<tr><td><b>Totals</b></td><td style="text-align:right"><?php echo number_format($totalamount,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalpaid,2);?>&nbsp;&nbsp;</td><td style="text-align:right"><?php echo number_format($totalbalance,2);?>&nbsp;&nbsp;</td></tr>
<td colspan=4><hr /></td>
</tbody></table><br/>


 <br /><br />
<span align="left" style="font-size:x-small">Printed by: <?php echo $_SESSION['uname']. date("d-m-Y H:i:s") ?></span> 


<?php

}
 else if ($type=='incmexpsummary'){
     $countincme =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE typ = 'I'");
     $countexpe =$mumin->getdbContent("SELECT * FROM  estate_expaccs");
     ?>
     <table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp;&nbsp;<?php echo  $_SESSION['estatefullname']?></font></i></b><br />
<span style="font-size:75%">&nbsp;&nbsp; Mobile: <?php echo $_SESSION['estmobno']?>',&nbsp;&nbsp;Email: <?php echo $_SESSION['estemail']?>
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="100" align="right" /></img> </td>
</tr> 
</table>
<div align="center"><font size="5"><b>INCOME SUMMARY</font></b> </div>
<hr />
<div><table id="report">
<tr><td> &nbsp;&nbsp;&nbsp;From&nbsp; <b><?php echo "$startdate"; ?></b>&nbsp; to &nbsp;<b><?php echo "$to_date1"; ?></b></td><td align=right></td></tr>
</table></div>
<hr />
<br />

<table id="report" style="width:100%" cellpading=4>
    <thead style="height: 25px;"><tr><th style="text-align:left"> &nbsp;&nbsp;&nbsp;&nbsp</th>
            <?php
            $rsl =$mumin->getdbContent("SELECT distinct(sector) as sector from mumin WHERE moh = '".$_SESSION['mohalla']."' ");
                $numad = (count($rsl)*2)+2;
            for($k=0;$k<count($rsl);$k++){
                    echo "<th>".$rsl[$k]['sector']."</th><th></th>";
                                        
                }
                echo '<th>TOTAL</th></tr></thead>';
            ?>
            
<tbody><tr><td colspan="<?php echo $numad;?>"><hr></td></tr>
    <?php   
    $sectorincmetotal =0;
    for($c=0;$c<count($countincme);$c++){
        
        echo "<tr><td>".$countincme[$c]['accname']."</td>";
        $specifictotal = 0; 
            for($k=0;$k<count($rsl);$k++){
                
            $rsle =$mumin->getdbContent("SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  estate_invoice WHERE incacc='".$countincme[$c]['incacc']."'  AND estId = '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND sector =  '".$rsl[$k]['sector']."' ");
            $credtamnt = $rsle[0]['debitamount']- $rsle[0]['creditamnt'];        
            echo "<td style='text-align:right'>".number_format($credtamnt,2)."</td><td></td>"; 
             $specifictotal = $specifictotal + $credtamnt;
             
           }
           
           
           
           echo "<td style='text-align:right'> ".number_format($specifictotal,2)."</td>";
        echo "</tr>";
            
        $sectorincmetotal =  $specifictotal + $sectorincmetotal;
    }
    echo '<tr><td colspan='.$numad.'><hr></td></tr>';
    echo '<tr "background-color: #ccccff"><td><b>INCOME TOTAL</b></td>';
    
            for($g=0;$g<count($rsl);$g++){
                $rsle =$mumin->getdbContent("SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  estate_invoice WHERE estId = '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND sector =  '".$rsl[$g]['sector']."' ");
            $sumcredtamnt = $rsle[0]['debitamount']- $rsle[0]['creditamnt'];  
               echo "<td style='text-align:right'>".number_format($sumcredtamnt,2)."</td><td style='text-align:right'></td>";   
            }
           '<td>fsfsf</td></tr>';
    echo '<tr><td colspan='.$numad.'><hr></td></tr>';
    $sectorincmetotl =0;
    for($t=0;$t<count($countexpe);$t++){
        $expensetotal =0;
        echo "<tr><td>".$countexpe[$t]['accname']."</td>";
            for($k=0;$k<count($rsl);$k++){
            $rslt =$mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT sum(amount) as debitamnt FROM  estate_bills WHERE expenseacc ='".$countexpe[$t]['id']."'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND sector= '".$rsl[$k]['sector']."' UNION
                                         SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' and sector= '".$rsl[$k]['sector']."' AND estate_id= '$id')t7 WHERE expacc = '".$countexpe[$t]['id']."' )T6");
            $expeamnt = $rslt[0]['debitamnt'];        
            echo "<td style='text-align:right'>".number_format($expeamnt,2)."</td><td></td>";
            $expensetotal = $expensetotal + $expeamnt;
           }
           echo "<td style='text-align:right'> ".number_format($expensetotal,2)."</td>";
        echo "</tr>";
        }
        echo '<tr><td colspan='.$numad.'><hr></td></tr>';
    echo '<tr><td ><b>EXPENSE TOTAL<b></td>';
    
            for($g=0;$g<count($rsl);$g++){
                $rslt =$mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT sum(amount) as debitamnt FROM  estate_bills WHERE estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND sector= '".$rsl[$g]['sector']."' UNION
                                         SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' and sector= '".$rsl[$g]['sector']."' AND estate_id= '$id')t7 WHERE expacc IN (SELECT id FROM estate_expaccs)  )T6");
            $sumexpeamnt = $rslt[0]['debitamnt']; 
               echo "<td style='text-align:right'>".number_format($sumexpeamnt,2)."</td><td></td>";   
            }
           '<td>fsfsf</td></tr>';
    ?>          
        
<!--<tr><td><b>Totals</b></td><td style="text-align:right">&nbsp;&nbsp;</td><td style="text-align:right"></td><td style="text-align:right">&nbsp;&nbsp;</td></tr>-->
<tr><td colspan="<?php echo $numad;?>"><hr /></td></tr>
</tbody></table><br/>


 <br /><br />
<span align="left" style="font-size:x-small">Printed by: <?php echo $_SESSION['uname']. "&nbsp;&nbsp&nbsp".date("d-m-Y H:i:s") ?></span> 


     <?php
 }
 ?>
 
 </div> <br />
<div style="page-break-after:always"> </div>


</body>
</html> 