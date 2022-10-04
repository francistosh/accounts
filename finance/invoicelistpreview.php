<?php session_start(); 
date_default_timezone_set('Africa/Nairobi');
if(!isset($_SESSION['jmsloggedIn'])){
  
    echo  "You must Login to see this page : <a href='../index.php'>Click to Login</a>";
       
}
else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Invoice List</title> 
<?php

include '../partials/stylesLinks.php';  
include 'links.php';
?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
<style type="text/css">
<!--
#report{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#report{ font-size:12px; text-align: left; }
.right{ text-align: right; }
#report th { background-color: #9c8468 !important; }

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
 $("#invcelstoxcel").button({  
            icons: {
                primary: "ui-icon-arrowthickstop-1-s" ,
                        secondary:" ui-icon-arrowthickstop-1-s"
            },
            text: true
             
});
   $("#invcelstoxcel").click(function(e){
             var x = $(".exporttable").clone();
$(x).find("tr td a").replaceWith(function(){
  return $.text([this]);
});
   x.table2excel({
					//exclude: ".noExl",
					name: "Exported File",
					filename: "Accounts summary"
				});
                                	});
});
 function demoFromHTML() {
     
    var pdf = new jsPDF('p', 'pt', 'ledger');
    // source can be HTML-formatted string, or a reference
    // to an actual DOM element from which the text will be scraped.
    source = $('#printableArea')[0];
//alert('Test');
    // we support special element handlers. Register them with jQuery-style 
    // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
    // There is no support for any other type of selectors 
    // (class, of compound) at this time.
    specialElementHandlers = {
        // element with id of "bypass" - jQuery style selector
        '#bypassme': function (element, renderer) {
            // true = "handled elsewhere, bypass text extraction"
            return true
        }
    };
    margins = {
        top: 80,
        bottom: 60,
        left: 40,
        width: 800
    };
    // all coords and widths are in jsPDF instance's declared units
    // 'inches' in this case
    pdf.fromHTML(
    source, // HTML string or DOM elem ref.
    margins.left, // x coord
    margins.top, { // y coord
        'width': margins.width, // max width of content on PDF
        'elementHandlers': specialElementHandlers
    },

    function (dispose) {
        // dispose: object with X, Y of the last line add to the PDF 
        //          this allow the insertion of new lines after html
        pdf.save('Invoice List.pdf');
    }, margins);
}              
</script>
</head>
    <body style="background:#FFF;overflow-x: visible!important;">
     <div align="center" id="printNot">
<button id="prntbldgr" class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<button id="closebldgr" class="sexybutton sexymedium sexyyellow" onclick="window.close();"><span><span><span class="cancel">Close</span></span></span></button>
<button id="invcelstoxcel" class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Excel</span></span></span></button>
<button id="invcepdf" class="sexybutton sexymedium sexyyellow" onclick="javascript:demoFromHTML();" ><span><span><span class="cancel">PDF</span></span></span></button>
   
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
          
        if($dpt!="ALL"){
          
            $qryies = "SELECT distinct(invoice.incacc)as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND idate BETWEEN '$sdate' AND '$edate' AND invoice.incacc = '$dpt' AND invoice.estId = '$est_id'";
            
          }
          else{
            $qryies = "SELECT distinct(invoice.incacc)as incacc,accname FROM invoice,incomeaccounts WHERE invoice.incacc = incomeaccounts.incacc AND idate BETWEEN '$sdate' AND '$edate' AND invoice.estId = '$est_id'";
              
          }
          $indata = $mumin->getdbContent($qryies);
          
          $sum=0;
           
          $dept1=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc  LIKE  '$dpt' LIMIT 1");
              
          if($dept1){
              
              $deptname=$dept1[0]['accname'];
          }
          else{
              $deptname="All Accounts";
          }
         

      $disp = 'block';
echo '<div class="container">'; 
echo '<div id="printableArea">';

echo '<table width="100%">';   
echo '<tr>';
echo'<td width="100px"><img src="../assets/images/gold new logo.jpg" width="100px"/></img></td>';
echo '<td><p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">Anjuman-e-Burhani </font></i></p><span style="font-size:8px">'.$_SESSION['details'].'</span></td>';
echo'<td><span style="float:right;font-size: 12px; padding-right: 40px"><b>'.$_SESSION['dptname'].'</b></span><br><div class="topic"><font size="3"><b>Invoice List</font></b></div></td>';
echo '</tr> ';
echo '</table>';
echo '<hr /><p font-size="2" align="right">Account Name: &nbsp; <b>'.$deptname.'</b>';
echo '<br>Invoice List From:&nbsp; <b>'.$sdate1.'</b>&nbsp; to &nbsp;<b>'.$edate1.'</b></p>'; 

echo '<table id="treport" class="table table-bordered exporttable">';
echo '<thead><tr><th style="width:60px"> Date</th><th> Doc. No.</th><th>Account</th><th>Sub Acct</th><th>Sabil No</th><th>Name</th><th>Remarks</th><th style="text-align:right">Amount&nbsp;&nbsp;</th></tr></thead>';
echo '<tbody>';

      for($k=0;$k<=count($indata)-1;$k++){
          $incmesum = 0;
          echo"<tr><th colspan='8'><b>".$indata[$k]['accname']."</b></th></tr>";
                          if($category=="PAID"){
                   
                $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND pdamount=amount AND incacc LIKE '".$indata[$k]['incacc']."' AND isinvce='1' AND opb = '0' ORDER BY idate,invno";
                  
                   
          }
          else if($category=="PENDING"){
                
              $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND incacc LIKE '".$indata[$k]['incacc']."' AND pdamount<amount AND isinvce='1' AND opb = '0' ORDER BY idate,invno";
                           
          }
          else{
            
               $qr="SELECT * FROM invoice WHERE idate BETWEEN '$sdate' AND '$edate' AND estId LIKE '$est_id' AND incacc LIKE '".$indata[$k]['incacc']."' AND isinvce='1' AND opb = '0' ORDER BY idate,invno";
      
              
          }
           $data=$mumin->getdbContent($qr);
          for($i=0;$i<=count($data)-1;$i++){
             //if($data[$i]['hofej']!=="N/A" || $data[$i]['hofej']!="" || !$data[$i]['hofej'] ){
                 if(intval($data[$i]['dno'])==0){
                  
                     $payer=$mumin->get_MuminNames($data[$i]['hofej']);
                     
                     $sabilno1=$data[$i]['sabilno'];
                     $hsenum = $mumin->get_houseno($data[$i]['hofej']);
              }
              else{
                 
                  $debid=$data[$i]['dno'];
                    
                  $debtor=$mumin->getdbContent("SELECT debtorname FROM debtors WHERE dno = '$debid' AND deptid LIKE '$est_id' LIMIT 1");
                  
                   $payer=$debtor[0]['debtorname'];
                   
                   $sabilno1="N/A";
                   
                   $hsenum = "";
              }
              
              $accid=$indata[$k]['incacc'];
              @$subacctid=$data[$i]['subacc'];
              $deptq=$mumin->getdbContent("SELECT accname FROM incomeaccounts WHERE incacc  LIKE  '$accid' LIMIT 1");
              
             @$dept=$deptq[0]['accname'];
              
             $subactnm = $mumin->getdbContent("SELECT accname FROM subincomeaccs WHERE id = '$subacctid'");
             @$subactname = $subactnm[0]['accname'];
              
              echo"<tr><td style='width:100px'>".date('d-m-Y',  strtotime($data[$i]['idate']))."</td><td><center>".$data[$i]['invno']."</center></td><td>".$dept."</td><td style='text-align:center'>".$subactname."</td><td style='text-transform:uppercase'><center>".$sabilno1."</center></td><td>".$payer ."</td><td>".$data[$i]['rmks']."</td><td style='text-align:right;padding-right:10px'>".  number_format($data[$i]['amount'],2)."</td></tr>";
              
               $incmesum +=floatval($data[$i]['amount']);
              
              $sum+=floatval($data[$i]['amount']);
          }
echo'<tr><td colspan="7" style="text-align: center;"><b>'.@$dept.' Total</b></td><td style="text-align:right;padding-right:10px"><b>'.number_format($incmesum,2).'</b></td></tr>';
          
              }
          
echo'<tr><td colspan="7" style="text-align: center;border-bottom:double;"><b>TOTALS</b></td><td style="text-align:right;padding-right:10px;border-bottom:double;"><b>'.number_format($sum,2).'</b></td></tr>';
echo'</tbody></table><br />';


//echo '<div id="report"></div> <br /><br />';
echo '<span align="left" style="font-size:x-small">Printed by: '.$_SESSION['jname'].' &nbsp;&nbsp; '.date("d-m-Y H:i:s"). '</span> </div></div> <br />';
echo '<div style="page-break-after:always"> </div>';
        
           
?>

    </body>
</html>
<?php } ?>