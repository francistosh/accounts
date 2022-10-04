  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];
//die($id);
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  //Check PRIVILEDGE Levels
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
if($priviledges[0]['deposits']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = '';
    $prevwbtn = '';
}else if($priviledges[0]['readonly']!=1){
    $displ = '<button onclick="previewdeposit()"> Deposit Amount</button>';
    $prevwbtn =  '<button id="prvwdeposit"> Preview</button>';
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Deposit</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>
<script src="../assets/js/framework/jquery-ui-1.10.4.custom.js"></script>
<script>
    $(function() {
           $( "#slctddepodate" ).datepicker({
defaultDate: "+1w",
changeMonth: false,
numberOfMonths: 1,

maxDate:0,
dateFormat: 'dd-mm-yy',
});
       });
</script>

<style type="text/css">
    
<!--
#report{ font-family:"Trebuchet MS"; width:80%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }
.ui-dialog .ui-dialog-title { overflow: visible !important; }
@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
#treport{width: 100%;}
#report{width: 100%;}
#prvwdeposit{display: none}

}
-->
</style>

<!--<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> -->
<link rel="stylesheet" href="../assets/css/jquery-ui.css" />
</head>
    <body style="overflow-x: visible!important;" >
        
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />
<?php
        
          
          $sdate1=trim($_GET['sdate']);
          $sdate = date('Y-m-d', strtotime($sdate1));
          $est_id=$_SESSION['dept_id'];
          $acct = trim($_GET['acct']);
          $pmd=trim($_GET['pmd']);
            
              if($acct == "all"){
                  $actqry = "";
              }
              else{
                  $actqry = 'AND incacc = '.$acct.'';
                // $gry1 = $mumin->getdbContent("SELECT bacc FRom incomeaccounts WHERE incacc = '$acct' ");
                // for($p=0;$p<''){}
              }
        if($pmd=="CASH"){
            $qr="SELECT * FROM recptrans WHERE rdate <=  '$sdate' AND est_id LIKE '$est_id' AND isdeposited = '0' AND pmode = 'CASH' $actqry ORDER BY rdate";
          }
          else if($pmd=="CHEQUE"){
             $qr="SELECT * FROM recptrans WHERE rdate <=  '$sdate' AND est_id LIKE '$est_id' AND isdeposited = '0' AND pmode = 'CHEQUE' $actqry ORDER BY rdate"; 
          }else if($pmd=="ALL"){
             $qr="SELECT * FROM recptrans WHERE rdate <=  '$sdate' AND est_id LIKE '$est_id' AND isdeposited = '0' AND pmode = '' $actqry ORDER BY rdate"; 
          }
          

          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $sum=0;
          $sum1=0;
                       

    
      $disp = 'none';

            
          echo '<div id="printableArea" style="overflow-x: visible!important;>';

echo '<table width="80%"  border="0" style="margin-right: auto; margin-left: auto">';   
echo '<tr>';
echo '<td colspan="2"> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:10px">'.$_SESSION['details'].'</span> </td><td><span style="float:right;font-size: 10px; padding-right: 30px"><b>'.$_SESSION['dptname'].'</b></span><br><img src="../assets/images/gold new logo.jpg" style="float:right" height="80" width="100" /></img></td>';
echo '</tr> ';
echo '</table>';
echo '<div align="right" style="margin-right: auto; margin-left: auto;width: 80%" ><font size="3"><b>Undeposited Receipts</font></b> </div>';
echo '<hr />';
echo '<div><table id="report" width="80%" style="margin-right: auto; margin-left: auto" >';
echo '<tr><td colspan="7" style="font-size: 12px">&nbsp; </b> Undeposited: &nbsp; <b>'.$pmd.'</b> Receipts as at <b>'.$sdate1.'</b></td></tr>';
echo '<tr><td style="text-align: center" ><input id="paymntmde" hidden="true" value="'.$pmd.'"></input><input id="strtdte" hidden="true" value="'.$sdate1.'"></input>';
echo '<select  class="formfield" id="bnkacct2" onchange="recheckaccount()"> <option value="all">--Income Account--</option>'; 
                              
                                $iqry="SELECT incomeaccounts.incacc,incomeaccounts.accname FROM incomeaccounts,incomeactmgnt WHERE incomeactmgnt.incacc = incomeaccounts.incacc AND  typ= 'I' AND incomeactmgnt.deptid = '$id' GROUP BY incomeaccounts.incacc"; 
                            
                                $data6=$mumin->getdbContent($iqry);
                                
                                 for($h=0;$h<=count($data6)-1;$h++){
                      
                                     echo "<option value=".$data6[$h]['incacc'].">".$data6[$h]['accname']."</option>";
                                   } 
                    
echo '<select></td>'; 
echo '<td> &nbsp;<select  class="formfield" id="bnkaccnt" > <option value="all">--To Account:--</option>'; 
                                
                                $iqry="SELECT * FROM bankaccounts WHERE deptid = '$id'  ORDER BY type"; 
                            
                                $data6=$mumin->getdbContent($iqry);
                                
                                 for($h=0;$h<=count($data6)-1;$h++){
                      
                                     echo "<option value=".$data6[$h]['bacc'].">".$data6[$h]['acname'].":&nbsp".$data6[$h]['acno']."</option>";
                                   } 
                    
echo '<select></td><td colspan="2" style="float:left"><input type="text" class="formfield" id="slctddepodate" readonly="true" value="'.date('d-m-Y').'"></input></td><td colspan=2>&nbsp&nbsp&nbsp&nbsp<b>TOTAL</b> : <input type = "text" value="0" id="amttodeposit" readonly="true" align="right" class="formfield" style="font-weight:bold"></input></td><td> '.$displ.' '.$prevwbtn.'</td></tr>'; 
echo '</table></div><script> $("#bnkacct2").val('.$acct.');</script>';

echo '<br/>';

echo '<table id="treport" style="margin-right:auto; margin-left:auto" cellpading=4>';
echo '<thead><tr><th colspan="2"> Date</th> <th colspan="2"> Recp. No.</th> <th colspan="2">Names</th> <th colspan="2"> Sabil No</th> <th colspan="2">Mode</th><th colspan="2">Chq No.</th><th>Incme Acct</th><th style="text-align:right">Amount&nbsp;&nbsp;</th><th><a href="#" id="sumall">Select All</a> | <a href="#" id="clearall">Clear All</a></th></tr></thead>';
          
          
         for($i=0;$i<=count($data)-1;$i++){
              
              
              if($data[$i]['chqno']){
              
              if($data[$i]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                  
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$accid'  LIMIT 1"); 
              
              @$dept=$deptq[0]['accname'];
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td colspan='2' id='rcpnodpst".$i."'>".$data[$i]['recpno']."</td><td colspan='2'>".$payer ."</td><td colspan='2'>".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$data[$i]['pmode']."</td><td colspan='2'>".$data[$i]['chqno']." : &nbsp".$data[$i]['chqdet']."</td><td>$dept</td><td style='text-align:right;padding-right:10px'>".number_format($data[$i]['amount'],2)."</td><td><input type='checkbox' class='checks' id='depsit$i' value='".$data[$i]['amount']."' onclick='oncheckbox($i)'></input></td></tr>";
              
              $numbering+=1;
              
              $sum1+=$data[$i]['amount'];
              
              }
          }
         // echo '<td colspan=16><hr /></td>';
          if($pmd=="CHEQUE" || $pmd=="ALL"){
         echo"<tr><th colspan='12' style='text-align: right;padding-right: 20px'>CHEQUE TOTALS</th><th></th><th></th><th style='text-align:right;padding-right:10px'>". number_format($sum1,2)."</th></tr>";    
       echo '<td colspan=16><hr /></td>';
          }else{
              
          }
          
          //cheque
          
          for($i=0;$i<=count($data)-1;$i++){
              
              
              if(!$data[$i]['chqno']){
              
              if($data[$i]['hofej']){
                 
                  $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                  
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                  
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno LIKE '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                  $payer=$debtor[0]['debtorname'];
                  
              }
              
              $accid=$data[$i]['incacc'];
              
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc = '$accid' LIMIT 1");
              
              @$dept=$deptq[0]['accname'];
              
              
              echo"<tr><td colspan='2'>".date('d-m-Y',  strtotime($data[$i]['rdate']))."</td><td colspan='2' id='rcpnodpst".$i."'>".$data[$i]['recpno']."</td><td colspan='2'>".$payer ."</td><td colspan='2'>".strtoupper($data[$i]['sabilno'])."</td><td colspan='2'>".$data[$i]['pmode']."</td><td colspan='2'></td><td>$dept</td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td><td><input type='checkbox' class='checks' id='depsit$i' value='".$data[$i]['amount']."' onclick='oncheckbox($i)'></input></td></tr>";
              
              $numbering+=1;
              
              $sum+=$data[$i]['amount'];
              
              }
          }
          if($pmd=="CASH" || $pmd=="ALL"){
         echo"<tr><th colspan='12' style='text-align: right;padding-right: 20px'>CASH TOTALS</th><th></th><th></th><th style='text-align:right;padding-right:10px'>". number_format($sum,2)."</th></tr>";    
          
          echo '<td colspan=16><hr /></td>';
          }

echo'<tr><td colspan=12 style="text-align: right"><b>GRAND TOTALS</b></td><td style="text-align:right;padding-right:10px" colspan="3"><b>'. number_format($sum1+$sum,2).'</b></td></tr>';
//echo '<td colspan=16><hr /></td>';
echo'</tbody></table><br />';


echo '<div id="report">Please check your balance and bring any discrepancies within 15 days</div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';
echo '<div style="page-break-after:always"> </div>';
         
     
  echo"</table>";
          
?>

    </body>
    
</html>
