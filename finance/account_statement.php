<?php
 session_start();
  if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
} else {
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Income/expense Statement </title>
 
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #957c17; height:25px; }
.center{text-align: center;}
.left{text-align: left;}
a {
      text-decoration:none;
   }
    a:hover {text-decoration:underline;}
@media print
{ 
#printNot {display:none}

}
-->
</style>
<?php
date_default_timezone_set('Africa/Nairobi');
include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>
<script src="js/amcharts/amcharts/amcharts.js"></script>
<script src="js/amcharts/amcharts/serial.js"></script>
<script>
$(function() {

   $("#iexpnsexcel").click(function(e){
            var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					exclude: ".noExl",
					name: "Exported File",
					filename: "Income Statement"
				});
                                	});
 
    $.getJSON("json_redirect.php?action=getexpensegrphrprt&startdate="+$("#expnsefrmdate").val()+'&enddate='+$("#expnsetodate").val(), function(data) {
   
    AmCharts.makeChart( "chartdiv", {
  "type": "serial",
  "dataProvider": data,
  "theme": "light",
  "categoryAxis": {
  "autoGridCount": false,
  "gridCount": data.length,
  "gridPosition": "start",
  "labelRotation": 90
},
"valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "Expenses"
  }],
  "startDuration": 1,
    "categoryField": "accname",
  "graphs": [ {
    "valueField": "debitamnt",
    "type": "column",
    "fillAlphas": 0.8,
    "fillColorsField": "color",
    "lineAlpha": 0.2,
    "balloonText": "[[category]]: <b>[[value]]</b>"
  } ]
  
  // ... other config parameters
} );
  });
});
</script>
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
$("#iexpnsexcel").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-grip-diagonal-se"
            },
            text: true
             
});
});
</script>
</head>
<body style="padding-left: 20px; padding-right: 20px; padding-bottom: 20px;;overflow-x: visible!important;">

<div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print Report</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="iexpnsexcel" class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Export To Excel</span></span></span></button>

</div>
<br />

<?php
$from_date1 = $_GET['startdate'];
$from_date = date('Y-m-d', strtotime($from_date1));
$to_date1 = $_GET['enddate'];
$to_date = date('Y-m-d', strtotime($to_date1));
//$supplier=$_GET['supplier'];
// include 'links.php';

include 'operations/Mumin.php';

$id=$_SESSION['dept_id'];

//$user=$_SESSION['usname'];

$mumin=new Mumin();

$crdtotal = 0; $debitotal = 0;
echo'<div class="container">';
echo '<div id="printableArea" >';

echo '<table width="100%"  border="0">';   
echo '<tr>';
//echo '<td> <img src="../assets/images/gold new logo.jpg" id="" height="80" width="120" /></img> </td>';
echo '<table width="100%">';   
echo '<tr>';
echo '<td width="100px"><img id="logo1" src="images/gold.png"></td>';
echo '<td> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani  </font></i> </p><font style="font-size:8px;">'.$_SESSION['details'].'</font>';
echo '</td>
<td><div class="topic"><font size="3"><b>Expense Report</font></b><input type="hidden" id="expnsefrmdate" value="'.$from_date.'"></input><input type="hidden" id="expnsetodate" value="'.$to_date.'"></input></div></td>
</tr>
</table>';?>
<?php
//echo '<tr><td>Account No. &nbsp; <b>&nbsp;&nbsp;&nbsp; </b> Account Name: &nbsp; <b></b></td><td align=right>Ejamaat/Entity No.&nbsp;&nbsp; &nbsp; Tel: &nbsp;</td></tr>';
echo '<hr /><p font-size="2" align="right"> From&nbsp; <b>'.$from_date1.'</b>&nbsp; to &nbsp;<b>'.$to_date1.'</b></p>'; 

$grantotal = 0;
echo '<table id="report" class="table table-condensed" style="width:100%" cellpading=4 class="exporttable">';
 echo '<tr><th>12 point Budget </th><th> EXPENSE </th>   <th class="right"> Amount</th> </tr>';     
    echo  '<tbody></tr>';
    
    
 $eqry =$mumin->getdbContent("SELECT expnseaccs.id,expnseaccs.accname FROM expnseaccs,expenseactmgnt WHERE expenseactmgnt.expenseacc = expnseaccs.id  AND expenseactmgnt.deptid = '$id' GROUP BY expnseaccs.id order by accname"); //Expense accounts
              for($i=0;$i<count($eqry);$i++){
          $accname = $eqry[$i]['accname'];
          $accid = $eqry[$i]['id'];
          // if ($_SESSION['grp']=='EXTERNAL') {
         // $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT (amount) as debitamnt FROM  estate_bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' AND sector='".$_SESSION['sector']."' UNION
         //                                      SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' and sector='".$_SESSION['sector']."' AND estate_id= '$id')t7 WHERE expacc = '$accid' )T6");
         //  } else {
         // $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT (amount) as debitamnt FROM  estate_bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
          //                                      SELECT sum(amount) as debitamnt FROM (SELECT IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM estate_directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '$accid' )T6");
          // }
		
          
          $expenseamnt = $mumin->getdbContent("SELECT sum(debitamnt) as debitamnt FROM(SELECT IF(isinvce='1',amount,amount*-1) as debitamnt,id FROM  bills WHERE expenseacc ='$accid'  AND estate_id = '$id' AND bdate BETWEEN '$from_date' AND '$to_date' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `journals` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsmbrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT IF(dramount='0',cramount*-1,dramount)as debitamnt,tno FROM `bad_debtsupplrs` WHERE tbl = 'E' and type = 'E' AND jdate  BETWEEN '$from_date' AND '$to_date' AND deptid = '$id' AND acc = '$accid' UNION
                                                SELECT sum(amount) as debitamnt,jid FROM (SELECT jid,IF(revsd='1' and dexpno LIKE '%R%',amount*-1,amount)as amount,IF(revsd='1' AND dexpno LIKE 'R%',cacc,dacc)as expacc, IF(revsd='1' and dexpno LIKE 'R%',dacc,cacc)as bankacct FROM directexpense WHERE dexpdate BETWEEN '$from_date' AND '$to_date' AND estate_id= '$id' )t7 WHERE expacc = '$accid' )T6");
        
          $debitamt= $expenseamnt[0]['debitamnt'];
          if($debitamt == 0){
                 $disply = 'display:none;';
                 $disclas =  'noExl';
                 }else{
                 $disply = '';
                 $disclas =  '';
                 }
          echo "<tr style='height: 20px;".$disply."' class='$disclas'><td></td><td><a target='blank' href='expensedtails.php?fromdate=$from_date&enddate=$to_date&expactid=$accid'>".$accname."</a></td>  <td class='right' style='padding-right: 10px'>".number_format($debitamt,2)."</td> </tr>";
          $debitotal = $debitamt + $debitotal;
      }
        $balan = $grantotal+$crdtotal - $debitotal;
        
echo '<td colspan=3 style="height: 3px" ></td>';
echo '<tr><td style="border-top: 1px solid black;border-bottom: 1px solid black;" class="right"></td><td style="border-top: 1px solid black;border-bottom: 1px solid black;" class="right"><b>Expense Total</b></td><td class="right" style="border-top: 1px solid black;border-bottom: 1px solid black;padding-right: 10px">'.number_format($debitotal,2).'</td></tr>';
echo '<td colspan=3 style="border-bottom: 1px solid;height: 3px"></td>';
echo'</tbody></table><br>';

//echo '<div style="page-break-after:always"> </div>';
 
?>
<div id="chartdiv" style="width: 640px; height: 400px; margin-left: auto;
margin-right: auto;"></div>
<?php
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> ';
?>
</div>
</div>
</body>
</html>
<?php
}
?>