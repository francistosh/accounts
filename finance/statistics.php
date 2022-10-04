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
     <?php 
 
 
 
 if ($type=='summary') {
 ?>
<table width="100%"  border="0">  
<tr>

<td width="70%">
<b><i><font size="5"></font><font size='5' >&nbsp;&nbsp;<?php echo  $_SESSION['estatefullname']?></font></i></b><br />
<span style="font-size:75%">&nbsp;&nbsp; Mobile: <?php echo $_SESSION['estmobno']?>',&nbsp;&nbsp;Email: <?php echo $_SESSION['estemail']?>
</span>
</td>
<td class="right"> <img  src="../assets/images/gold new logo.jpg" height="80" width="120" /></img> </td>
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
            $rsl =$mumin->getdbContent("SELECT distinct(sector) as sector from mumin WHERE moh = '".$_SESSION['mohalla']."' ");
                $numad = count($rsl)+1;
            for($k=0;$k<count($rsl);$k++){
                    echo "<th>".$rsl[$k]['sector']."</th>";
                                        
                }
                echo '</tr></thead>';
            ?>
<tbody><tr><td colspan="<?php echo $numad;?>"><hr></td></tr>
    <tr style="background-color: #ccccff"><td>Mumineen</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(ejno) as number from mumin WHERE moh = '".$_SESSION['mohalla']."' AND sector = '".$rsl[$k]['sector']."' ");
                    echo "<td style='text-align:center'>".$rsle[0]['number']."</td>";                                    
                }?></tr>
    <tr style="background-color: #cccccc"><td>Houses</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as houses from mumin WHERE moh = '".$_SESSION['mohalla']."' AND sector = '".$rsl[$k]['sector']."' ");
                    echo "<td style='text-align:center'>".$rsle[0]['houses']."</td>";
                    
                }?>
    </tr>
    <tr style="background-color: #ccccff"><td>Contributed</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as contributed FROM estates_recptrans WHERE rev = '0' AND sector = '".$rsl[$k]['sector']."' AND rdate BETWEEN '$from_date' AND '$to_date' AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid' AND dno = '0') ") ;
                    echo "<td style='text-align:center'>".$rsle[0]['contributed']."</td>"; 
                    
                }?></tr>
    <tr style="background-color: #cccccc"><td>Not Contributed</td><?php for($k=0;$k<count($rsl);$k++){
        $rsle =$mumin->getdbContent("SELECT COUNT(DISTINCT(sabilno)) AS notcontributed FROM mumin WHERE sabilno NOT IN (SELECT distinct(sabilno) as sabilno FROM estates_recptrans WHERE rev = '0' AND sector = '".$rsl[$k]['sector']."' AND rdate BETWEEN '$from_date' AND '$to_date' AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid' AND dno = '0')) AND sector = '".$rsl[$k]['sector']."' ");
                    echo "<td style='text-align:center'>".$rsle[0]['notcontributed']."</td>";                                    
                }?> 
    </tr>
     <tr ><td style="color: red">% Contributed</td><?php for($k=0;$k<count($rsl);$k++){
         $rsle =$mumin->getdbContent("SELECT count(distinct(sabilno)) as houses from mumin WHERE moh = '".$_SESSION['mohalla']."' AND sector = '".$rsl[$k]['sector']."' ");
        $rsle1 =$mumin->getdbContent("SELECT count(distinct(sabilno)) as contributed FROM estates_recptrans WHERE rev = '0' AND sector = '".$rsl[$k]['sector']."' AND rdate BETWEEN '$from_date' AND '$to_date' AND  sabilno in (SELECT distinct(sabilno) FROM estate_invoice WHERE incacc ='$incmeactid' AND dno = '0')");
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


<?php
}
 else if ($type=='incmexpsummary'){
     $countincme =$mumin->getdbContent("SELECT * FROM  estate_incomeaccounts  WHERE typ = 'I' and `$id` = '1' ");
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
        <tr><td colspan="<?php echo $numad;?>"><hr /></td></tr>
<tr><td><b>Profit/Loss</b></td>
<?php
        for($g=0;$g<count($rsl);$g++){
            $rslt =$mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT sum(amount) as debitamnt FROM  estate_bills WHERE estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND sector= '".$rsl[$g]['sector']."' UNION
                                         SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct,jid FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' and sector= '".$rsl[$g]['sector']."' AND estate_id= '$id')t7 WHERE expacc IN (SELECT id FROM estate_expaccs)  )T6");
            $sumexpeamnt = $rslt[0]['debitamnt'];
            $rsle =$mumin->getdbContent("SELECT sum(IF(isinvce=1,amount,0)) as debitamount,sum(IF(isinvce=0,amount,0)) as creditamnt FROM  estate_invoice WHERE estId = '$id' AND idate BETWEEN '$from_date' AND '$to_date' AND sector =  '".$rsl[$g]['sector']."' ");
            $sumcredtamnt = $rsle[0]['debitamount']- $rsle[0]['creditamnt']; 
            $profitloss = $sumcredtamnt - $sumexpeamnt;
            echo "<td style='text-align:right'>".number_format($profitloss,2)."</td><td></td>";
        }

?>

</tr>
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