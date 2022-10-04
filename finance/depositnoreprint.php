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
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
if($priviledges[0]['deposits']!=1){
   
header("location: index.php");
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

<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:80%; border-collapse:collapse; }
#report{ font-size:85%; text-align: left; }
.right{ text-align: right; }
#report th { background-color:#9c8468; height: 25px; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
treport{width:100%}
}
-->
</style>
</head>
    <body style="background:#FFF;overflow-x: visible!important;" >
           <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button class="sexybutton sexymedium sexyyellow" onclick="window.location.href = 'deposit.php?type=printdeposit'"><span><span><span class="cancel">Close</span></span></span></button>
</div>
<br />

<?php
    $depstno =  trim($_GET['depsitno']);

    $getdepst = $mumin->getdbContent("SELECT  hofej,dno,recpno,rdate,chqno,chqdet,amount,pmode,recptrans.bacc,depots,sabilno,incomeaccounts.accname FROM recptrans,incomeaccounts WHERE incomeaccounts.incacc = recptrans.incacc AND isdeposited = '$depstno' AND est_id = '$id'");
//$row1 = mysql_fetch_assoc($getdepst);
    $row9 = $mumin->getdbContent("SELECT hofej,dno,recpno,rdate,chqno,chqdet,amount,pmode,recptrans.bacc,depots,sabilno,incomeaccounts.accname FROM recptrans,incomeaccounts WHERE incomeaccounts.incacc = recptrans.incacc AND isdeposited = '$depstno' AND est_id = '$id' LIMIT 1");
        $t =count($row9)-1;
    $pmode = $row9[$t]['pmode'];
        $bank = $row9[$t]['bacc'];
        $depots = $row9[$t]['depots'];
    $bnkacctname = $mumin-> getbankname($bank);
 
        $bnkactname = $bnkacctname;
  echo '<div id="printableArea" >'; 
    echo '<table id="tpreview" style="width:650px;margin-left:auto;margin-right: auto">
<tr><td colspan="10"><center><span style="font-size:18px;font-weight:normal;float:left;"> <b>Deposit List No: '.$depstno.' </b></span><span style="font-size:22px;font-weight:bold;"> ANJUMAN-E-BURHANI</span><span style="font-size:12px;font-weight:normal; float:right;">'.$_SESSION['dptname'].'</span><center>
<br/><span style="font-size:16px;font-weight:normal;"><input type="text" id="pymntmode" value="'.$pmode.'" style="display:none"><input type="text" id="bankid"  style="display:none"><center>'.ucfirst($pmode).' Deposit on '.date('d-m-Y',  strtotime($depots)).'  to <input type="text" value="'.$bnkactname.'" disabled style="border:none;text-align: center;width:300px"></input>&nbsp; </center></span><br/>
    </td></tr>';
echo'<tr><u><th>R. No</th> <th>R. Date</th><th>Sabil No</th><th>Name</th><th>Act</th><th>Chq. No</th> <th>Amount</th></u></tr>';    
 //for ($t=0;$t <= count()){}
$totaldeposited = 0;
for($r=0;$r<=count($getdepst)-1;$r++){
        if($getdepst[$r]['dno'] == '0'){
        $tnaame = $mumin->get_MuminNames($getdepst[$r]['hofej']);
        }elseif ($getdepst[$r]['dno'] != '0') {
         $tnaame = $mumin->get_debtorName($getdepst[$r]['dno']);  
        }
         echo'<tr><td><a href="receipting.php?action=reprintingreceipt&recpno='.$getdepst[$r]['recpno'].'" target="blank">'.$getdepst[$r]['recpno'].'</a></td> <td>'.date('d-m-Y',strtotime($getdepst[$r]['rdate'])).'</td><td>'.$getdepst[$r]['sabilno'].'</td><td>'.$tnaame.'</td><td>'.$getdepst[$r]['accname'].'</td><td>'.$getdepst[$r]['chqno'].' : '.$getdepst[$r]['chqdet'].'</td> <td style="text-align: right;padding-right:20px" >'.number_format($getdepst[$r]['amount'],2).'</td></tr>';   
      $totaldeposited = $totaldeposited + $getdepst[$r]['amount'];
}

echo'<tr><td colspan="6" style="text-align:center;height:25px;"><b> '.$bnkactname.' Total </b></td><td style="text-align: right;padding-right:20px"><b>'.number_format($totaldeposited,2).'</b></td></tr>';   
 
echo '</table>';
echo '<hr/>'; 
echo '<i>Printed by:</i> '.$_SESSION['jname'].'&nbsp;&nbsp;&nbsp;&nbsp;'.date("d-m-y H:i:s").'&nbsp;';
echo '</div>';
  ?>

    </body>
</html>