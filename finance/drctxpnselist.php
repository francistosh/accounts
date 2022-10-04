 <?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Journal Voucher List</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
?>
<style type="text/css">
<!--
th{background-color:#F8B500 !important;color:white;font-weight:bold;}

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
</head >
    <body style="background:#FFF;overflow-x: visible!important;">
        <div align="center" id="topBar" style="background: #fff;width: 100%;height: 30px;margin: 0;-moz-border-radius-bottomleft: 5px;-moz-border-radius-bottomright: 5px;-webkit-border-bottom-left-radius: 5px;-webkit-border-bottom-right-radius: 5px;border-bottom-left-radius: 5px;border-bottom-right-radius: 5px">
			<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
			<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
			<!--<button onclick="TriggerOutlook()" id="stemail">Email</button>-->
		</div>
        <br><div class="container">
				  
        <div id="xlogohead" style="margin: 0px auto 10px auto;border-bottom: 5px #000;height: 100px;background:#FFF">
			<table width="100%">
			<tr>
			<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px" /></img></td>
			<td>
				<div id="titlesvi" style="font-size: 20px;font-family: Cambria,Georgia,serif;">
				<p><b>Anjuman-e-Burhani</b></p><span style="font-size:8px;"><?php echo $_SESSION['details'];?></span>
				</div>
			</td>
			<td><span style="float:right;font-size: 12px;padding-right: 30px;"><b><?php echo $_SESSION['dptname']; ?></b></span><div class="topic"><font size="3"><b>Direct Expense Voucher List</b></font></div></td>
			</tr>
			</table>
		</div>
<?php
        date_default_timezone_set('Africa/Nairobi');
 include '/operations/Mumin.php';
 
          $mumin=new Mumin();
          
          
          $sdate1=trim($_GET['startdate']);
          $sdate = date('Y-m-d',  strtotime($sdate1));
          
          $edate1=trim($_GET['enddate']);
          $edate = date('Y-m-d',  strtotime($edate1));
          $est_id=$_SESSION['dept_id'];
         $drctxpense=trim($_GET['drctxpense']);
          
                   
               //$qr="SELECT * FROM estate_jentry WHERE jdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' ORDER BY jdate ASC";
               if($drctxpense=='ALL'){
            $qr= "SELECT dexpno,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,dexpdate,rmks,cacc,dacc,costcentrid,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' and estate_id ='$est_id' order by dexpdate ";
            
                 } elseif ($drctxpense !=='ALL') {
             $qr= "SELECT * FROM (SELECT dexpno,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,dexpdate,rmks,cacc,dacc,costcentrid,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate BETWEEN '$sdate' AND '$edate' and estate_id ='$est_id' order by dexpdate)t7 WHERE expacc = '$drctxpense' ";    
             }
      
          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $count=0; $sum=0;
           echo'<hr /><p align="right">From:&nbsp<b> '.$sdate1.'</b> &nbsp&nbspTo:&nbsp <b>'.$edate1.'</b></p>';
          echo"<table class='table table-condensed' id='jlist' style='line-height:30px;border-spacing:15px;border-top: dotted 1px; width: 100%;'>";
           
          echo"<thead><th>S.No</th><th>Date</th><th>Doc.No</th><th>Debit Acc</th><th>Credit Acc</th><th>Cost Center</th><th>Remarks</th><th style='text-align:right'>Amount</th></thead>";    
          
          for($i=0;$i<=count($data)-1;$i++){
              
        $count=$count+1;
          $sum = $data[$i]['amount'] +$sum ;   
          $acc=$mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id  = '".$data[$i]['expacc']."' LIMIT 1");
          
          $acc1=$mumin->getdbContent("SELECT acname FROM bankaccounts WHERE bacc = '".$data[$i]['bankacct']."' LIMIT 1");
          $coctntrename = $mumin->getcostcentername($data[$i]['costcentrid']);
          if($data[$i]['dacc']== $data[$i]['expacc']){
              $debitname= $acc[0]['accname'];
              $creditname = $acc1[0]['acname'];
          }else if($data[$i]['dacc']== $data[$i]['bankacct']) {
              $debitname = $acc1[0]['acname'];
              $creditname = $acc[0]['accname'];
          }
        
            echo "<tr style='height:15px;font-size:12px;font-family:Trebuchet MS;'><td>".$count.".</td><td style='width:100px;'>".date('d-m-Y',  strtotime($data[$i]['dexpdate']))."</td><td>".$data[$i]['dexpno']."<td style='width:150px;'>".$debitname."</td><td style='width:150px;'>".$creditname."</td><td>".$coctntrename."</td><td>".$data[$i]['rmks']."</td><td  style='text-align:right'>".number_format($data[$i]['amount'],2)."</td> </tr>";  
            
            }
            echo '<tr><td colspan="8" style="border-bottom: solid 2px"></td></tr>';
            echo "<tr><td colspan='6'>&nbsp&nbsp<b>TOTAL</b></td><td colspan='2' style='text-align: right;'><b>".number_format($sum,2)."</b></td></tr>";
            echo '<tr><td colspan="8" style="border-top: solid 2px"></td></tr>';
            echo"</table>";  
           echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';

?></div>
    </body>
</html>