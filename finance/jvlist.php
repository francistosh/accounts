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
			<td><span style="float:right;font-size: 12px;padding-right: 30px;"><b><?php echo $_SESSION['dptname']; ?></b></span><div class="topic"><font size="3"><b>Journal Voucher List</b></font></div></td>
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
         
          
      
           $qr="SELECT * FROM jentry WHERE jdate BETWEEN '$sdate' AND '$edate' AND estId = '$est_id' ORDER BY jdate ASC";
           
          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $count=0; $sum=0;
           echo'<hr /><p align="right">From:&nbsp<b> '.$sdate1.'</b> &nbsp&nbspTo:&nbsp <b>'.$edate1.'</b></p>';
          echo"<table class='table table-condensed' id='jlist' style='line-height:15px;border-spacing:10px;border-top: dotted 1px;'>";
           
          echo"<thead><th>S.No</th><th>Date</th><th>Doc.No</th><th>Debit Acc</th><th>Credit Acc</th><th>Remarks</th><th style='text-align:right'>Amount</th></thead>";    
          echo"<tbody style='font-size: 13px;font-family:Trebuchet MS;'><tr><td colspan='7'><hr/></td></tr>";
          for($i=0;$i<=count($data)-1;$i++){
              
        $count=$count+1;
          $sum = $data[$i]['amount'] +$sum ;      
          if($data[$i]['dbacc']=='1' && $data[$i]['cbacc'] == '0' ){
              
           $acc=$mumin->getdbContent("SELECT acname as accname FROM bankaccounts WHERE bacc  = '".$data[$i]['dbtacc']."' LIMIT 1");
          
          $acc1=$mumin->getdbContent("SELECT incacc,accname,typ FROM incomeaccounts WHERE incacc= '".$data[$i]['crdtacc']."' LIMIT 1");
          }
          elseif($data[$i]['dbacc']=='0' && $data[$i]['cbacc'] == '1' ) {
              
           $acc=$mumin->getdbContent("SELECT incacc,accname,typ FROM incomeaccounts WHERE  incacc= '".$data[$i]['dbtacc']."' LIMIT 1");
          
          $acc1=$mumin->getdbContent("SELECT acname as accname FROM bankaccounts WHERE bacc = '".$data[$i]['crdtacc']."' LIMIT 1");
          }
                   
        elseif ($data[$i]['dbacc'] == $data[$i]['cbacc']) {
            $acc=$mumin->getdbContent("SELECT acname as accname FROM bankaccounts WHERE bacc = '".$data[$i]['dbtacc']."' AND deptid = '$est_id' LIMIT 1"); 
            $acc1=$mumin->getdbContent("SELECT acname as accname FROM bankaccounts WHERE bacc = '".$data[$i]['crdtacc']."' AND deptid = '$est_id' LIMIT 1");
          
            }  
              
          
             
           if($acc){
                  
                  $fromacc=$acc[0]['accname'];
                  @$toacc= $acc1[0]['accname'];
            }
              
           
                  
         
          
            echo"<tr style='height: 20px'><td>".$count.".</td><td>".date('d-m-Y',  strtotime($data[$i]['jdate']))."</td><td>".$data[$i]['jvno']."</td><td >".$fromacc."</td><td>".$toacc."</td><td>".$data[$i]['rmks']."</td><td  style='text-align:right'>".number_format($data[$i]['amount'],2)."</td> </tr>";  
            
            }
            echo '<tr><td colspan="7" style="border-bottom: solid 2px"></td></tr>';
           // echo "<tr><td colspan='3'>&nbsp&nbsp<b>TOTAL</b></td><td></td><td></td><td></td><td colspan='2' style='text-align: right;'><b>".number_format($sum,2)."</b></td></tr>";
            echo "<tr style='height: 20px'><td></td><td><b>TOTAL</b></td><td></td><td></td><td></td><td></td><td class= 'right'><b>".number_format($sum,2)."</b></td></tr>";
			echo '<tr><td colspan="7" style="border-top: solid 2px"></td></tr></tbody>';
            echo"</table>";  
           echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div> <br />';

?></div>
    </body>
</html>