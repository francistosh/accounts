<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
        $id=$_SESSION['dept_id'];
   $userid = $_SESSION['acctusrid'];
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head runat="server">
<title>Statements</title>
 
<style type="text/css">
<!--
#tablist{ font-family:"Trebuchet MS"; width:100%; border-collapse:collapse; }
#tablist{ font-size:85%; text-align: left; }
#tablist td {border:1px solid black;padding:3px 4px 2px 5px;}
.right{ text-align: right; }
#tablist th { background-color:#FFCCCC; padding-top:5px;
padding-bottom:4px;border:1px solid black; }

@media print
{ 
#printNot {display:none}
thead {display: table-header-group;}
}
-->
</style>
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

 ?>

<script>
    
     $(function() {
   
   
  
    $("#pprint").button({
            icons: {
                primary: "ui-icon-print" ,
                        secondary:"ui-icon-document"
            },
            text: true
             
});


  $("#pcancel").button({
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-circle-close"
            },
            text: true
             
});


  $("#stemail").button({  
            icons: {
                primary: "ui-icon-cross" ,
                        secondary:"ui-icon-mail-closed"
            },
            text: true
             
});



 
    });

   
</script>
</head>
    
    <body style="background: white;overflow-x: visible!important;">
        
 <div align="center" id="printNot">
<button class="sexybutton sexymedium sexyyellow" onclick="window.print();"><span><span><span class="print">Print List</span></span></span></button>
<a href="statements.php?type=selectivebatch"><button class="sexybutton sexymedium sexyyellow" ><span><span><span class="cancel">Close</span></span></span></button></a>
</div>
<br />
        
        <?php
        
        date_default_timezone_set('Africa/Nairobi');
        $sabils=$_POST['selctivesabno'];
    print_r($sabils);
	die();
       // $account=$_POST['bstataccount'];
        
        $invdate=date('Y-m-d',strtotime($_POST['invdate']));
        
        $incmeacc=$_POST['incmeacc'];
        $invcamount=$_POST['invcamount'];
        $slctvremarks=$_POST['slctvremarks'];
        $user=$_SESSION['jname'];
        $ts=date('Y-m-d h:i:s');
        $id=$_SESSION['dept_id'];
        
       
echo '<div id="printableArea">';

echo '<table width="100%"  border="0">';   
echo '<tr>';
echo '<td colspan="2"> <p> <i><font style="font-size:20px;text-align: left;font-weight:bold;font-family: Cambria,Georgia,serif;">&nbsp&nbsp; Anjuman-e-Burhani  </font></i> </p> <span style="font-size:10px">'.$_SESSION['details'].'</span> </td><td><img src="../assets/images/gold new logo.jpg" style="float:right" height="80" width="100" /></img></td>';

echo '</tr> ';
echo '</table>';
echo '<div align="right"><font size="5"><b>Selective Batch Invoice</font></b> </div>';
echo '<hr />';
echo '<div><table id="report">';
//echo '<tr><td><b>Account Name: &nbsp; <b>Mumineen Batch Invoice</b></td><td align=right>&nbsp;&nbsp; &nbsp;&nbsp; </td></tr>';
///echo '<tr><td>Account Transaction List From:&nbsp; <b>'.$start.'</b>&nbsp; to &nbsp;<b>'.$end.'</b></td><td align=right>Email:&nbsp;</td></tr>'; 
echo '</table></div>';
echo '<hr />';
echo '<br />';

echo '<table id="tablist" style="width:100%" cellpading=4>';
echo '<tbody><tr><td colspan="6"><hr></td></tr>';  
echo '<tr><th><b>Date</b></th><th><b>Invoice No</b></th><th><b>Account</b></th> <th><b>Name</b></th><th><b>Sabil No</b></th><th><b>Amount</b></th></tr>';
$wqry =$mumin->getdbContent("SELECT accname FROM  incomeaccounts WHERE incacc = '$incmeacc'");
$acctname1 = $wqry[0]['accname']; $sumt = 0;

$localIP = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_SANITIZE_STRING); // get IP ADDRESS
 for($s=0;$s<=count($sabils)-1;$s++){
            $ej=$mumin->get_MuminHofEjnoFromSabilno($sabils[$s]);
            
           // $sectr = $mumin->getsectorname($ej);
             $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
             $invoicee=$mumin->get_MuminNames($ej)."&nbsp;";
            $qr11="INSERT INTO invoice(estId,idate,amount,invno,rmks,hofej,sabilno,us,ts,incacc,isinvce,sector) VALUES 
                ('$id','$invdate','$invcamount','$docnos','$slctvremarks','$ej','$sabils[$s]','$user','$ts','$incmeacc','1','$localIP')";
            $data3=$mumin->insertdbContent($qr11);
            echo"<tr><td>".date('d-m-Y', strtotime($invdate))."</td><td>".$docnos."</td><td>".$acctname1."</td><td>".$invoicee."</td><td>".$sabils[$s]."</td><td style='text-align:right;padding-right:10px'>".  number_format($invcamount,2)."</td></tr>";
            $sumt = $sumt + $invcamount;
            
            
            }
            
            echo "<tr><td colspan='5' style='text-align: center'><b>Total</b></td><td style='text-align:right;padding-right:10px'><b>".number_format($sumt,2)."</b></td></tr>";
            echo'</tbody></table><br />';



echo '<div style="page-break-after:always"> </div></div>';
        
        
?>
          
 
  
          
 
</body>
    
</html>