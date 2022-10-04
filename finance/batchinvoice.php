<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level!=999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['invoices']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>receipt print | Mombasa Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
    
    
<script>
    
    
$(function() {
    

  
   $("#rcpprint201").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-print" 
            }
        });
    
    $("#rcpclose201").button({
            icons: {
                
                secondary: "ui-icon-arrowthick-1-e" 
            }
        });
        
         
      
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
</head>
   
<body style="overflow-x: hidden;background: white">   
  
   
 <?php
  
     $moh=trim($_GET['moh']);
     $period=trim($_GET['period']);
     $amount=trim($_GET['amount']);
     $sector=trim($_GET['sector']);
     $credit=trim($_GET['credit']);
     $remarks=trim($_GET['remarks']);
     
     
 
     
         $n="SELECT * FROM mumin WHERE moh LIKE '$moh'";
         
         $data=$mumin->getdbContent($n);
        
          
         $numbering=1;
          
         $sum=0;
          
         $sum1=0;
          
          
         $date=date('Y-m-d');
           
          echo"<table class='recpview'>";
           
          echo"<tr><th>SN</th><th>Date</th><th>Doc.No</th><th>Dept/Acc</th><th>Names</th><th>Sabil No</th><th>Remarks</th><th style='text-align:right'>Amount</th></tr>";    
          
       
          
          for($i=0;$i<=count($data)-1;$i++){
              
                 
              $invoicee=$mumin->get_MuminNames($data[$i]['hofej']);
              
              $docnos=sprintf('%06d',intval($mumin->refnos("invno")));
              
              
              echo"<tr><td>".$numbering."</td><td>".$date."</td><td>".$docnos."</td><td>".$credit."</td><td>".$invoicee."</td><td>".$data[$i]['sabilno']."</td><td>".$remarks."</td><td style='text-align:right'>".  number_format($amount,2)."</td></tr>";
              
              $numbering+=1;
              
              $sum+=floatval($data[$i]['amount']);
              
              
          }
         echo"<tr><td></td><td></td><td></td><td><td></td></td></td><td>CASH TOTALS</td><td style='text-align:right'>". number_format($sum,2)."</td></tr>";    
          
        
        
    
 
    
 
         
 
  ?>
</body>
</html> 