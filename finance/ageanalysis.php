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
    
<head>
    
<title>Jims</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:13px; text-align: left; }
.right{ text-align: right; padding-right: 20px}


@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}

}
-->
</style>
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
});
</script>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">	<div class="container">
           <div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Statement</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php
        
  
          $ageanlyze=trim($_GET['ageanlyze']);
          
          $est_id=$_SESSION['dept_id'];

          $analyzetype=trim($_GET['type']);
          $todaydate = date('Y-m-d');
          
        //DATEDIFF(CURRENT_DATE, Timestamp )>=60
          
        
         /* $qr="SELECT ejno,rdate FROM estates_recptrans";
      
          $r=$mumin->getdbContent($qr);
          
          
         $qr60="SELECT sabilno FROM estates_recptrans  WHERE DATEDIFF( '$enddate', rdate ) <=60) sabilno ASC";
          
          $data60=$mumin->getdbContent($qr60);
          
          
          $qr90="SELECT sabilno FROM estates_recptrans  WHERE DATEDIFF( '$enddate', rdate ) <=90) sabilno ASC";
          
          $data90=$mumin->getdbContent($qr90);
          
          
          $qr120="SELECT sabilno FROM estates_recptrans  WHERE DATEDIFF( '$enddate', rdate ) <=120) sabilno ASC";
          
          $data120=$mumin->getdbContent($qr120);*/
          
         $les30 = 0; $les60 = 0; $les90 = 0; $greater90 = 0;
       
echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img id="logo1" src="images/gold.png"></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p><font style="font-size:8px;">'.$_SESSION['details'].'</font>';
echo '</td>';
echo '<td><div class="topic"><font size="3"><b>Age Analysis Report</font></b><br><p font-size="2"><center>From:&nbsp;<b>'.date('d-m-Y').'</center></p></div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr />';
echo '<table id="report" class="table table-bordered" style="width:100%" cellpading=4>';
echo '<thead><tr><th>Title</th><th>Name</th><th class="right">0-30 Days</th> <th class="right">31-60 Days</th> <th class="right">61-90 Days</th><th class="right"> > 90 Days</th><th class="right"> Total </th></tr></thead>';
echo '<tbody>';
           $grandtotal = 0;
    if($analyzetype == 'sabil'){
        if($ageanlyze =='all'){
        $ageqry = $mumin->getdbContent("SELECT DISTINCT(sabilno) FROM invoice WHERE estId = '$est_id' and dno = '0' AND amount>pdamount order by sabilno");
	}
        else {
	$ageqry = $mumin->getdbContent("SELECT distinct(sabilno) FROM invoice WHERE sabilno = '$ageanlyze' AND estId = '$est_id' order by sabilno");    
        
	}
      // echo count($ageqry);
        for($k=0;$k<= count($ageqry)-1;$k++){
            $qryt = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM invoice WHERE sabilno = '".$ageqry[$k]['sabilno']."' AND DATEDIFF( idate,'$todaydate' ) <=30 AND idate <= '$todaydate'");
           $qry2 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM invoice WHERE sabilno = '".$ageqry[$k]['sabilno']."' AND DATEDIFF( idate,'$todaydate' ) >= 31 and DATEDIFF( idate,'$todaydate' ) <=60 AND idate <= '$todaydate' ");
           $qry3 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM invoice WHERE sabilno = '".$ageqry[$k]['sabilno']."' AND DATEDIFF( idate,'$todaydate' ) >=61 and DATEDIFF( idate,'$todaydate' ) <=90 AND idate <= '$todaydate'");
           $qry4 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM invoice WHERE sabilno = '".$ageqry[$k]['sabilno']."' AND DATEDIFF( idate,'$todaydate' ) >90 AND idate <= '$todaydate'");
            if($qryt[0]['amount']!= '-'){
                $displamt = number_format($qryt[0]['amount'],2);
                $realamnt = $qryt[0]['amount'];
            }
            else{
                $displamt = '-';
                $realamnt = 0;
            }
            if($qry2[0]['amount']!= '-'){
                $displamt2 = number_format($qry2[0]['amount'],2);
                $realamnt2 = $qry2[0]['amount'];
            }
            else{
                $displamt2 = '-';
                $realamnt2 = 0;
            }
            if($qry3[0]['amount']!= '-'){
                $displamt3 = number_format($qry3[0]['amount'],2);
                $realamnt3 = $qry3[0]['amount'];
            }
            else{
                $displamt3 = '-';
                $realamnt3 = 0;
            }
            if($qry4[0]['amount']!= '-'){
                $displamt4 = number_format($qry4[0]['amount'],2);
                $realamnt4 = $qry4[0]['amount'];
            }
            else{
                $displamt4 = '-';
                $realamnt4 = 0;
            }
            $les30 = $les30 + $realamnt;
            $les60 = $les60 + $realamnt2;
            $les90 = $les90 + $realamnt3;
            $greater90 = $greater90 + $realamnt4;
            $mutotal = $realamnt4 + $realamnt3 + $realamnt2 + $realamnt;
           $mname = $mumin->get_MuminHofNamesFromSabilno($ageqry[$k]['sabilno']);
            echo '<tr><td>&nbsp;&nbsp;'.$ageqry[$k]['sabilno'].'</td><td>'.$mname.'</td>
                  <td class="right">'.$displamt.'</td><td class="right">'.$displamt2.'</td><td class="right">'.$displamt3.'</td><td class="right">'.$displamt4.'</td><td class="right">'.number_format($mutotal,2).'</td></tr>';
       		$grandtotal = $grandtotal + $mutotal;
		}
    } else if($analyzetype == 'supplier'){
         if($ageanlyze =='all'){
	
        $ageqrz = $mumin->getdbContent("SELECT DISTINCT(supplier) FROM bills WHERE estate_id = '$est_id'  AND amount>pdamount");
        
	}
        else {
	$ageqrz = $mumin->getdbContent("SELECT distinct(supplier) FROM bills WHERE supplier = '$ageanlyze' AND estate_id = '$est_id'");    
       
	}
        
        for($k=0;$k<= count($ageqrz)-1;$k++){
            $qryyt = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM bills WHERE supplier = '".$ageqrz[$k]['supplier']."' AND DATEDIFF( bdate,'$todaydate' ) <=30 AND bdate <= '$todaydate'");
           $qryy2 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM bills WHERE supplier = '".$ageqrz[$k]['supplier']."' AND DATEDIFF( bdate,'$todaydate' ) >= 31 and DATEDIFF( bdate,'$todaydate' ) <=60 AND bdate <= '$todaydate'");
           $qryy3 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM bills WHERE supplier = '".$ageqrz[$k]['supplier']."' AND DATEDIFF( bdate,'$todaydate' ) >=61 and DATEDIFF( bdate,'$todaydate' ) <=90 AND bdate <= '$todaydate'");
           $qryy4 = $mumin->getdbContent("SELECT IFNULL(SUM(amount-pdamount),'-') as amount FROM bills WHERE supplier = '".$ageqrz[$k]['supplier']."' AND DATEDIFF( bdate,'$todaydate' ) >90 AND bdate <= '$todaydate'");
            if($qryyt[0]['amount']!= '-'){
                $displyamt = number_format($qryyt[0]['amount'],2);
                $damnt = $qryyt[0]['amount'];
                
            }
            else{
                $displyamt = '-';
                $damnt = 0;
            }
            if($qryy2[0]['amount']!= '-'){
                $displyamt2 = number_format($qryy2[0]['amount'],2);
                $damnt2 = $qryy2[0]['amount'];
            }
            else{
                $displyamt2 = '-';
                $damnt2 = 0;
            }
            if($qryy3[0]['amount']!= '-'){
                $displyamt3 = number_format($qryy3[0]['amount'],2);
                $damnt3 = $qryy3[0]['amount'];
            }
            else{
                $displyamt3 = '-';
                $damnt3 = 0;
            }
            if($qryy4[0]['amount']!= '-'){
                $displyamt4 = number_format($qryy4[0]['amount'],2);
                $damount4 = $qryy4[0]['amount'];
            }
            else{
                $displyamt4 = '-';
                $damount4 = 0;
            }
            $suplrname = $mumin->getdbContent("SELECT suppName FROM suppliers WHERE supplier = '".$ageqrz[$k]['supplier']."' AND estId = '$est_id'");    
            $les30 = $les30+$damnt;
            $les60 = $les60 + $damnt2;
            $les90 = $les90 + $damnt3;
            $greater90 = $greater90 + $damount4 ;
            $totalamnt = $damnt + $damnt2 + $damnt3 + $damount4;
            echo '<tr><td colspan="2">&nbsp;&nbsp;'.$suplrname[0]['suppName'].'</td>
                  <td class="right">'.$displyamt.'</td><td class="right">'.$displyamt2.'</td><td class="right">'.$displyamt3.'</td><td class="right">'.$displyamt4.'</td><td class="right">'.number_format($totalamnt,2).'</td></tr>';
       		$grandtotal = $grandtotal + $totalamnt;
            
       }
    }

          
         // $empty_temp=$mumin->updatedbContent("DROP TABLE $tbname"); //delete contents  of temp table  in readness for next  operation
          
  echo'<tr><td colspan="7"></td></tr>';    
          
             
        
          
         

echo'<tr><td colspan="2" style="">Totals</td><td class="right">'.number_format($les30,2).'</td><td class="right">'.number_format($les60,2).'</td><td class="right">'.number_format($les90,2).'</td><td class="right">'.number_format($greater90,2).'</td><td class="right">'.number_format($grandtotal,2).'</td></tr>';

echo'</tbody></table><br />';


echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
         
         
          
         
         
         
         
         
         
         
  echo"</table>";
          
?>
</div>
    </body>
</html>