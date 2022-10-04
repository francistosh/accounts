<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {  
    
header("location: ../index.php");

}
else{
  
$level=$_SESSION['acc'];
    
    if($level!=999){
  
  header("location: ../index.php"); 
        
    } 
    
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    
<head>
    
<title>Estates</title> 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

include 'operations/Mumin.php';

$mumin=new Mumin();

//$usr=$_SESSION['uname'];  
 
//$access=$_SESSION['grp'];   

$id=$_SESSION['est_prop'];

$priv=$_SESSION['priviledge'];

$qr="SELECT estate_name FROM anjuman_estates WHERE id LIKE '$id'";

$est=$mumin->getdbContent($qr);

$estname=$est[0]['estate_name'];

$qr2="SELECT * FROM priviledges WHERE id LIKE '$priv' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);


$qr3="SELECT mohalla FROM anjuman_estates WHERE id LIKE '$id' LIMIT 1";

$res=$mumin->getdbContent($qr3);   

$moh=trim($res[0]['mohalla']);


$_SESSION['mohalla']=$moh;
    


?>


<script>
    
  $(function() {
    
   
  
  $("#tenantejno" ).autocomplete({source: ejamaatNos});  
   
 
  $('select').selectbox();
   
  $("#billdate" ).datepicker({ dateFormat: 'yy-mm-dd'} );
  
  $("#savetenant").button({
            icons: {
                primary: "ui-icon-disk" ,
                        secondary:"ui-icon-check"
            },
            text: true
             
});
 
	$('#notify').vTicker({ 
		speed: 500,
		pause: 3000,
		animation: 'fade',
		mousePause: true,
		showItems: 3
	});
        

 
    });
 
</script>




</head>  
    
<body style="overflow-x: hidden;">
    
    
    
    
<div id="div_browsercontainer">
  
  <div id="div_pagecontainer">
      
    
    
    
    
    
      <div id="div_jamaatlogo"><a href="index.php"><img src="../assets/images/gold new logo.png" width="105" height="105" title="GO HOME"></img></a></div>  
      
    
      
      
    <div id="invhd" style="width:100%;height: 100px; background:goldenrod;border-bottom:1px #eee solid;padding-top: 5px; margin: 0px auto 5px auto">
      
        <div id="invhd1" style="width:70%;border-right: 1px gray dotted;border-left: 1px gray dotted;padding-left: 4px;height: 80px; background:transparent; margin: 0px auto 0px auto"> 
         
           
           <font size="6" color="white" style="margin-right:200px;margin-left: 5px;font-weight: bold;line-height: 30px; font-family:Verdana, Arial, Helvetica, sans-serif"><?php echo $estname ?><p><font style="color: #eee;font-size: 12px;font-weight: bold">&nbsp;&raquo;HOME </font></p></font> 
     
      
          
  
  </div> 
           
        <div id="div_logout"><a href="logout.php"><img src="../assets/images/logout-icon.png" width="105" height="105" title="Logout"></img></a></div>
    </div>
     
    
    
      <div style="width: 800px;float: left">
   
       
       
        <fieldset style="border:1px orange solid;color:orange;font-size: 20px;font-weight: bold;font-style: italic">  
            <legend>Accounting/Financials</legend>
       
    <table class="ordinal" style="margin: 20px auto 20px auto"> 
        <tr><td><a class="r_dashboard" style="background-color: lightgreen" href="<?php if(intval($priviledges[0]['invoices'])==1){ echo "create_invoice.php";}else{ echo "#";} ?>"><div class="fontbig">Bills/Invoices</div>
                    <div class="fontsmall">Billing &amp; invoices</div></a></td><td>
                        <a class="r_dashboard" style="background-color: #9c8468" href="<?php if(intval($priviledges[0]['receipts'])==1){ echo "receipts.php";}else{ echo "#";} ?>"><div class="fontbig">Receipts</div><div class="fontsmall">Make receipts</div></a></td><td>
                            <a  style="background-color: darkkhaki" class="r_dashboard" href="<?php if(intval($priviledges[0]['withdrawals'])==1) { echo "";}else{ echo "";} ?>">
                                <div class="fontbig"></div><div class="fontsmall"></div></a></td><td><a class="r_dashboard" style="background-color: lightslategrey"
                                      href="<?php if(intval($priviledges[0]['jv'])==1){ echo "jv.php";}else{ echo "#";} ?>"><div class="fontbig">JVs</div><div class="fontsmall">
                                            Jv Operations</div></a></td><td><a style="background-color: #cccc00" class="r_dashboard"
                                                  \href="<?php if(intval($priviledges[0]['suppliers'])==1){ echo "suppliersmanagement.php";}else{ echo "#";} ?>">
                                                  <div class="fontbig">Suppliers</div><div class="fontsmall">Suppliers M'gment</div></a></td></tr> 
        <tr><td><a class="r_dashboard" style="background-color: lightskyblue" href="<?php if(intval($priviledges[0]['payments'])==1){ echo "payments.php";}else{ echo "#";} ?>">
                    <div class="fontbig">Payments</div><div class="fontsmall">Make payments</div></a></td><td><a
                            href="<?php  if(intval($priviledges[0]['debtors'])==1){echo "debtorsmanagement.php";} else{ echo "#";}?>" style="background-color: lightseagreen" class="r_dashboard"><div class="fontbig">Debtors</div>
                            <div class="fontsmall">Debtors M'gment</div></a></td><td>
                                <a class="r_dashboard"  href="<?php if(intval($priviledges[0]['bankaccounts'])==1){echo "bankmanagement.php";} else{ echo "#";}?>" style="background-color: chocolate"><div class="fontbig">Bank Accs</div><div class="fontsmall">Banks management</div></a></td><td><a class="r_dashboard" style="background-color: green" 
                                      href="<?php if(intval($priviledges[0]['statements'])==1){ echo "statements.php";}else{ echo "#";} ?>"><div class="fontbig">Statements</div><div class="fontsmall">Process Statements</div></a></td><td><a style="background-color: midnightblue" class="r_dashboard" href="<?php  if(intval($priviledges[0]['incomeaccounts'])==1){echo "#";} else{ echo "#";}?>"><div class="fontbig"></div><div class="fontsmall"></div></a></td></tr> 
      
   </table>
        </fieldset>  
       
          <fieldset style="border:1px orange solid;color:orange;font-size: 20px;font-weight: bold;font-style: italic">  
       
            <legend>Mumin Database</legend>
       <table class="ordinal" style="margin: 20px auto 20px auto"> 
           <tr><td><a style="background-color:orange" class="r_dashboard" 
                      href="<?php if(intval($priviledges[0]['database'])==1){ echo "database_reports.php";}else{ echo "#";} ?>"><div class="fontbig">D'base</div><div class="fontsmall">Get Mumineen Data</div></a> </td><td><a style="background-color: darkseagreen" class="r_dashboard" href="#"><div class="fontbig"></div><div class="fontsmall"></div></a> </td><td><a style="background-color: lightgray" class="r_dashboard" href=""></a> </td><td><a style="background-color: #ede4d4" class="r_dashboard" href=""></a> </td><td> <a  class ="r_dashboard" style="background-color: brown" href=""> </a></td></tr> 
    
       </table></fieldset>
          
          
          
          <fieldset style="border:1px orange solid;color:orange;font-size: 20px;font-weight: bold;font-style: italic">  
       
            <legend>Configurations and settings</legend>
       <table class="ordinal" style="margin: 20px auto 20px auto"> 
           <tr><td><a style="background-color: rosybrown" class="r_dashboard"
                      href="<?php if(intval($priviledges[0]['admin'])==1){ echo "grant_priviledges.php";}else{ echo "#";} ?>"><div class="fontbig">Admin</div><div class="fontsmall">Grant/Deny rights</div></a> </td><td><a style="background-color: lightblue" class="r_dashboard" href="#"></a> </td><td><a style="background-color: lightpink" class="r_dashboard" href=""></a> </td><td><a style="background-color: lightgray" class="r_dashboard" href=""></a> </td><td><a style="background-color: #ede4d4" class="r_dashboard" href=""></a> </td></tr> 
    
       </table></fieldset>
       
  
    
    
    

    
          
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
      </div>
       
      <div  id="notification_anouncementbar"> 
          <div id="notifyheader" style="width: 100%;-webkit-border-top-left-radius: 5px;-moz-border-top-left-radius: 5px;-moz-border-top-right-radius: 5px;-webkit-border-top-right-radius: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;float: right;height: 40px;font-size: 17px;font-family: Arial;font-weight: bold;line-height: 40px;text-align: center;vertical-align: middle;background: orange;color: white">Events/Notices</div>
          <div id="notify" style="width: 174px;height: 95%; padding-left: 3px; padding-right: 3px;margin-top: 50px;background:transparent;font-family: Helvetica,Arial,sans-serif;font-size: 12px;color: #444">
            
              <p><!--<marquee  width='180' height='400' direction='up' scrollamount="1">!--> 
                  <ul>
                   <?php
                      
                   $q="SELECT * FROM posts";
                   
                   $data=$mumin->getdbContent($q);
                   
                   for($i=0;$i<=count($data)-1;$i++){
                       
                      echo"<li>". $data[$i]['text']."<br/><div  style='width:150px;height:2px;background-color:gold'><div  style='width:50px;height:2px;background-color:blue;float:left'></div><div  style='width:50px;height:2px;background-color:green;float:right'></div></li>" ;
                   }
                   ?>
                      
                  </ul>  
                      
                  <!--</marquee>!-->
              </p>
              
          </div>   
          
          
      </div> 
  </div>
  
</div>  
    
</body>
</html>