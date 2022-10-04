<?php session_start(); 
date_default_timezone_set('Africa/Nairobi');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Credit Notes</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>
 
<style type="text/css">
<!--


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
    <body style="background:#FFF;overflow-x: visible!important;">
     <div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print </span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php
        
 include 'operations/Mumin.php';
 
          $mumin=new Mumin();
          
          
          $sdate1=trim($_GET['sdate']);
          
          $sdate = date('Y-m-d', strtotime($sdate1));
          
          $edate1=trim($_GET['edate']);
          
          $edate = date('Y-m-d', strtotime($edate1));
          
          $est_id=$_SESSION['dept_id'];
          
          $category=trim($_GET['category']);
            
          $dpt=trim($_GET['dpt']);
          //$days_between = floor(abs($sdate - $edate) / 86400);
        if($dpt!="ALL"){
          
            
            if($category=="PAID"){
                 
                $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND pdamount=amount AND incacc LIKE '$dpt' AND isinvce='0' ORDER BY idate";
                 
          }
          else if($category=="PENDING"){
               
              $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND incacc LIKE '$dpt' AND pdamount<amount AND isinvce='0' ORDER BY idate";
               
          }
          else{
                
               $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND incacc LIKE '$dpt' AND isinvce='0' ORDER BY idate";
               
          
          }
          }
          else{
            
              
              if($category=="PAID"){
                  
                $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND pdamount=amount AND isinvce='0' ORDER BY idate";
                 
          
          }
          else if($category=="PENDING"){
                   
              $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND pdamount<amount AND isinvce='0' ORDER BY idate";
                 
          }
          else{
            
               $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND isinvce='0' ORDER BY idate";
                    
               }
              
          }
           
         
          
          $data=$mumin->getdbContent($qr);
          
          
          
          $sum=0;
           
          $dept1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc  LIKE  '$dpt' LIMIT 1");
              
          if($dept1){
              
              $deptname=$dept1[0]['accname'];
          }
          else{
              $deptname="All departments";
          }
         
 //$debid=$data[0]['debtor'];
                    //echo "SELECT debtorname FROM estate_debtors WHERE id LIKE '$debid' AND estId LIKE '$est_id' LIMIT 1";
 
      $disp = 'block';
echo '<div class="container">';
echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:8px">'.$_SESSION['details'].'</span> </td>';
echo'<td><span style="float:right;font-size: 12px; padding-right: 40px"><b>'.$_SESSION['dptname'].'</b></span><div class="topic"><font size="3"><b>Credit Note List</font></b></div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p font-size="2" align="right"> Account Name: &nbsp; <b>'.$deptname.'</b><br>Credit Note List From:&nbsp; <b>'.$sdate1.'</b>&nbsp; to &nbsp;<b>'.$edate1.'</b></p>';
echo '<tr><td></td><td align=right> </td></tr>';
echo '<tr><td></td><td align=right></td></tr>'; 
echo '</table></div>';
echo '<hr />';
echo '<br />';

echo '<table class="table table-bordered" id="treport" >';
echo '<thead><tr><th> Date</th><th> Doc. No.</th><th>Incme Acct</th><th>Sabil No</th><th>Names</th><th>Remarks</th> <th class="wrap">Invoice No</th><th style="text-align:right">Amount&nbsp;&nbsp;</th></tr></thead>';
echo '<tbody>';

      
          
          for($i=0;$i<=count($data)-1;$i++){
              
              
              
              //if($data[$i]['hofej']!=="N/A" || $data[$i]['hofej']!="" || !$data[$i]['hofej'] ){
                 if(intval($data[$i]['dno'])==0){
                  
                     $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                     
                     $sabilno1=$data[$i]['sabilno'];
                  $hsenum = $mumin->get_houseno($data[$i]['hofej']);
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                    
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                   $payer=$debtor[0]['debtorname'];
                   
                   $sabilno1="N/A";
                   $hsenum="";
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc  LIKE  '$accid' LIMIT 1");
              
              $dept=$deptq[0]['accname'];
              
              
              echo"<tr><td>".date('d-m-Y',strtotime($data[$i]['idate']))."</td><td>".$data[$i]['invno']."</td><td>".$dept."</td><td style='text-transform:uppercase'>".$sabilno1."</td><td >".$payer ."</td><td >".$data[$i]['rmks']."</td><td><p class='wrap'>".$data[$i]['crdtinvce']."</p></td><td style='text-align:right'>".  number_format($data[$i]['amount'],2)."&nbsp&nbsp;</td></tr>";
              
               
              
              $sum+=floatval($data[$i]['amount']);
          }
          
                   

echo'<tr><td colspan="7" style="text-align: center" > <b>TOTAL</b></td><td style="text-align:right"><b>'.number_format($sum,2).'</b>&nbsp;&nbsp;</td></tr>';

echo'</tbody></table><br />';


//echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div> <br />';
echo '<div style="page-break-after:always"> </div>';
        
           
?>
    </body>
</html>