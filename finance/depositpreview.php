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
if($priviledges[0]['readonly']==1){
    $displ = 'display: none';
}else if($priviledges[0]['readonly']!=1){
    $displ = '';
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<?php
$bankacct = $_GET['bankacct'];
$bnkacctname = $mumin-> getbankname($bankacct);
$ddate = date('d-m-Y', strtotime($_GET['ddate']));
?>
<html>
    
<head>
    
<title>Deposit preview</title> 
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
<button class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
</div>
             <div id="deposit_previewl" style="border: 0;" title="Confirmation">
         
            
    <table id="tpreview" style="width:650px;margin-left:auto;margin-right: auto;overflow: visible!important;" >
<tr><td colspan="9"><center><span style="font-size:18px;font-weight:normal;float:left;"> <b> Deposit Preview:  </b></span><span style="font-size:22px;font-weight:bold"> ANJUMAN-E-BURHANI</span><span style="font-size:12px;font-weight:normal; float:right;"></span><span style="font-size:12px;font-weight:normal; float:right;"><?php echo $_SESSION['dptname'];?></span><center>
                <br/><span style="font-size:16px;font-weight:normal;"><input type="text" id="pymntmode" value="'.$pmode.'" style="display:none"></input><input type="text" id="bankid"  style="display:none"><center> Deposit to <input type="text" value="<?php echo $bnkacctname; ?>"  style="border:none;text-align: center;width:300px"></input>&nbsp;On:&nbsp;&nbsp; <?php echo $ddate;?> </center></span><br/>
    </td></tr>
        <tr><u><th>R. No</th> <th>R. Date</th><th>Sabil No</th><th>Name</th><th>Acct</th><th>Chq. No</th> <th>Amount</th></u></tr>   

 <?php 
           $receipts =  explode(",",$_GET['rcptsnumbrs']);
           $sumdepo = 0;
          for($i=0;$i<=count($receipts)-2;$i++){
         
              $query = $mumin->getdbContent("SELECT hofej,dno,recpno,rdate,chqno,chqdet,amount,sabilno,incomeaccounts.accname  FROM recptrans,incomeaccounts WHERE incomeaccounts.incacc = recptrans.incacc AND  recpno = '$receipts[$i]' and est_id = '$id' ");
               if($query[0]['dno'] == '0'){
        $tnaame = $mumin->get_MuminNames($query[0]['hofej']);
        }elseif ($query[0]['dno'] != '0') {
         $tnaame = $mumin->get_debtorName($query[0]['dno']);  
        }
        if($query[0]['chqno'] =='' || $query[0]['chqdet'] ==''){
            $chquesdetails = 'CASH';
        }else{
            $chquesdetails = $query[0]['chqno']. ':' .$query[0]['chqdet'];
        }
              echo "<tr><td>".$query[0]['recpno']."</td><td>".date('d-m-Y',strtotime($query[0]['rdate']))."</td><td>".$query[0]['sabilno']."</td><td>".$tnaame."</td><td>".$query[0]['accname']."</td><td>".$chquesdetails."</td><td style='text-align: right;padding-right:20px'>".number_format($query[0]['amount'],2)."</td></tr>";
          $sumdepo = $query[0]['amount'] + $sumdepo;
              
        }
 

  ?> 
        <tr><td colspan="5" style="text-align:center;height:25px;"><b><?php echo $bnkacctname; ?> Total</b></td><td></td><td style="text-align: right;padding-right:20px"><b><?php echo number_format($sumdepo,2) ?></b></td></tr>  
 
</table>
<hr/> 
<?php
echo '<i>Printed by:</i> '.$_SESSION['jname'].'&nbsp;&nbsp;&nbsp;&nbsp;'.date("d-m-y H:i:s").'&nbsp;';
?>
</div>
</body >
</html>