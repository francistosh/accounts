 <?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Bad debts List</title> 
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
 
$("#costcntrexcel").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});

 $("#costcntrexcel").click(function(e){
       // alert('test');
       var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Cost Centre Report"
				});
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
			<td><span style="float:right;font-size: 12px;padding-right: 30px;"><b><?php echo $_SESSION['dptname']; ?></b></span><div class="topic"><font size="3"><b>Journal Entry List</b></font></div></td>
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
         

            $qr= "SELECT jdate,jno,tbl,IF(dramount <> '0.00',' ',acc) as debitacct,IF(cramount <> '0.00',' ',acc) as crdtacct,dramount, cramount,`type` FROM bad_debtsmbrs WHERE jdate BETWEEN '$sdate' AND '$edate' AND deptid = '$est_id' ";
            

      
          
          $data=$mumin->getdbContent($qr);
          
          $numbering=1;
          
          $count=0; $sumdebit=0; $sumcredit=0;
          echo'<hr /><p align="right">From:&nbsp<b> '.$sdate1.'</b> &nbsp&nbspTo:&nbsp <b>'.$edate1.'</b></p>';
          echo"<table class='table table-condensed' id='jlist' style='line-height:30px;border-spacing:15px;border-top: dotted 1px; width: 100%;'>";
           
          echo"<thead><th>S.No</th><th>Date</th><th>Doc.No</th><th>Accounts</th><th>Remarks</th><th style='text-align: right'>Debit Amount</th><th style='text-align: right'>Credit Amount</th></thead>";    
          echo"<tr><td colspan='7'><hr></hr></td></tr>";
          for($i=0;$i<=count($data)-1;$i++){
              //echo '.$mumin->getPrevKey($data[$i]['jno'].";
              if($data[$i]['jno']!= @$data[($i-1)]['jno']){
        $count=$count+1;
        }
          //$sum = $data[$i]['amount'] +$sum ;
          if($data[$i]['type'] == 'E' && $data[$i]['debitacct'] == ' ' ){
          $acc=$mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id  = '".$data[$i]['crdtacct']."' LIMIT 1");
          $acctname = $acc[0]['accname'];
          }else if($data[$i]['type'] == 'E' && $data[$i]['crdtacct'] == ' ') {
          $acc=$mumin->getdbContent("SELECT accname FROM expnseaccs WHERE id  = '".$data[$i]['debitacct']."' LIMIT 1");    
          $acctname = $acc[0]['accname'];
          
          } else if($data[$i]['tbl'] == 'M'){
           $acctname  = $mumin->get_MuminNames($data[$i]['type']);
          }
          if($data[$i]['dramount'] == '0.00'){
              $displaydramount = '-';
              $displaycramount = number_format($data[$i]['cramount'],2);
          } else if($data[$i]['cramount'] == '0.00'){
              $displaydramount =  number_format($data[$i]['dramount'],2);
              $displaycramount = '-';
          }
          $sumdebit = $sumdebit + $data[$i]['dramount'];
          $sumcredit = $sumcredit + $data[$i]['cramount'];
                           if($data[$i]['jno']!= @$data[($i-1)]['jno']){ // check previous journal number
                 echo '<tr><td colspan="6" style="border-bottom: solid 2px"></td></tr>';
            }
            echo "<tr style='height:15px;font-size:12px;font-family:Trebuchet MS;'><td>".$count.".</td><td style='width:100px;'>".date('d-m-Y',  strtotime($data[$i]['jdate']))."</td><td>".$data[$i]['jno']."<td>".$acctname."</td><td></td><td style='width:150px;text-align: right;padding-right: 40px'>".$displaydramount."</td><td style='text-align: right;padding-right: 20px'>".$displaycramount."</td></tr>";  

            }
            echo '<tr><td colspan="7" style="border-bottom: solid 2px"></td></tr>';
            echo "<tr><td colspan='5'>&nbsp&nbsp<b>TOTAL</b></td><td style='text-align: right;padding-right: 40px'><b>".number_format($sumdebit,2)."</b></td><td style='text-align: right;padding-right: 20px'><b>".number_format($sumcredit,2)."</b></td></tr>";
            echo '<tr><td colspan="7" style="border-top: solid 2px"></td></tr>';
            echo"</table>";  
           echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div> <br />';

?></div>
    </body>
</html>