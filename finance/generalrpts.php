  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  include 'operations/Mumin.php';

$mumin=new Mumin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>JIMS 2 | Receipts</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
date_default_timezone_set('Africa/Nairobi');
?>

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" id="invcelstoxcel"><span><span><span class="cancel">Excel</span></span></span></button>
           </div>
<br />
<?php
          echo '<div id="printableArea">';
        $action=$_GET['action'];
		
		if ($action == 'muminbalances'){
		
          $sdate1=trim($_GET['sdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $edate1=trim($_GET['edate']);
          $edate = date('Y-m-d', strtotime($edate1));
          $incacc = trim($_GET['incacc']);
          $sabilno = trim($_GET['sabilno']);
		  $ej=$mumin->get_MuminHofEjnoFromSabilno($sabilno);        
		  $muminSector=$mumin->getdbContent("SELECT sector, moh, email, hseno FROM mumin WHERE ejno LIKE '$ej'");
          $statementRecevee=$mumin->get_MuminHofNamesFromSabilno($sabilno)."<br/>Mohalla :&nbsp;&nbsp;".$muminSector[0]['moh'];
          $email= $muminSector[0]['email'];
			$hseno= $muminSector[0]['hseno'];
			$debtelno ='';
			$display = "display: block";
          
          $numbering=1;
          
          $sum=0;
          $sum1=0;
                       
    
              $deptname="All";
   
    
      $disp = 'none';

            
echo '<table width="100%">';   
echo '<tr>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span> </td>';
echo'<td><span style="float:right;font-size:12px; padding-right: 30px"><b>'.$_SESSION['dptname'].'</b></span><div class="topic"><font size="4"><b>Mumin Balances Report</font></b> </div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr />';
echo '<div><table id="report" style="font-size:12px;padding:10px;">';
echo '<tr><td>Account Name: &nbsp; <b>'.$statementRecevee.' </b>&nbsp;&nbsp;&nbsp; Tel No : '.$debtelno.'</td>';
echo '<td><p font-size="2" align="right">From:&nbsp; <b>'.$sdate.'</b>&nbsp; to &nbsp;<b>'.$edate1.'</b></p></td>';
echo '</tr>';
echo '<tr><td style="'.$display.'">Sabil No: &nbsp; '.strtoupper($sabilno).'&nbsp;&nbsp; House No.&nbsp;'.ucfirst($hseno).'&nbsp;&nbsp; Massol Name: &nbsp;</td><td style="text-align:Center">  </td></tr>';
echo '</table>';
$qry3= "SELECT SUM(amount) as bbfamnt from (SELECT SUM(IF(isinvce='1',amount,-1*amount)) as amount,tno  FROM invoice WHERE  estId LIKE '$id'  AND idate < '$from_date'  AND dno = '0' AND opb = '0' AND sabilno='".$mumincontent[$j]['sabilno']."' $incmeqry UNION 
                    SELECT (SUM(amount))*-1 as amount,tno  FROM recptrans WHERE est_id LIKE '$id' AND rdate < '$from_date' AND sabilno='".$mumincontent[$j]['sabilno']."' AND dno = '0' $incmeqry UNION 
                    SELECT sum(dramount) - sum(cramount) as amount,tno FROM bad_debtsmbrs WHERE deptid = '$id' AND jdate < '$from_date' AND acc = '".$mumincontent[$j]['sabilno']."' AND tbl = 'M'  $incmeqry ) t1";
                    $bbf =$mumin->getdbContent($qry3); 


          }
?>
    </body>
</html>
<?php }?>