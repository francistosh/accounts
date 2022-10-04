<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['bankaccounts']!=1){
   
header("location: index.php");
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>finance | Mombasa Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';

?>
     
    
<script>
    
    
$(function() {
    
   
    // DataTable configuration
  $('#editsupp').dataTable( {
	"bSort": false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
    
       
        $("#okcancel5").button({
            icons: {
                primary: "ui-icon-check"
            }});
           $("#okdelete5").button({
            icons: {
                primary: "ui-icon-trash"
            }});
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
<style type="text/css">
.menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
	}
	
 
  .menuitems li:hover {
	 background: orange;
         color: white;
	}   

.menuitems a:visited {
	text-decoration:none;
	color:#333;
	
	}
	</style>
        
        
</head>
   
<body style="overflow-x: hidden;"> 
  
    
    <?php
    
     
    $id=$_SESSION['est_prop'];
    
    $qr="SELECT ccname FROM costcenters WHERE id LIKE '$id'";
$est=$mumin->getdbContent($qr);
$estname=$est[0]['ccname'];
                                
    ?>
 
   
    
     <div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"> Mombasa Jamaat Online</h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext">Estates Module</h2>
    </div>
  </div>
  <div id="div_pagecontent">
  	<div id="div_logindetails">You are logged in as:  <?php echo $_SESSION['uname'];?></div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
   	  <div id="div_pic">
      
            <div id="div_logout" class="button" style="margin-left:10px;"> 
       	<a href="index.php">
          <button class="formbuttons" value="1">
          
              <table style="margin-left: 30px" width="116" border="0">
            <tr>
              <td width="36" height="36" style="text-align:right;"><img src="../assets/images/backward.png" width="35" height="35"/> </td>
              <td width="70" style="text-align:center;">Home</td>
            </tr>
          </table>
          
          </button>
         </a> 
        </div>
      </div>
      
        
      <div id="div_menu">
      	<div id="div_menutitle">Quick links</div>
        <div id="div_menucontent">
       
        	<ul class="menuitems">
                    
                       
            <!--<li class="menuitems"><a href="bankmanagement.php?action=new">Add new Account</a></li> !-->
            <li class="menuitems" ><a href="bankmanagement.php?action=edit">View/Edit account</a></li>
            <li  class="menuitems" ><a href="index.php">Home</a></li> 
              
                    
                 
          <li class="menuitems"><a href="logout.php" class="menuitems"> Log Out</a> </li>
       </ul>
        </div>
      </div>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Bank Management sub-section</h3>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
    
    <?php
           
           $action =$_GET['action'];
           
           
           if($action==""){
              
               
           }
           
           else if($action=="new"){
    
    ?>
     
            
        
         <table class="ordinal"> 
          <tr><td>Account No :</td><td><input   onkeypress="return isNumberKey(event);"  type="text" id="acnox" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g  288819292</font></td></tr>
           <tr><td>Account Name:</td><td><input id="accnamess" type="text" class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g sabil account</font></td></tr> 
          
           <tr><td>Bank Name:</td><td><input id="banknamess" type="text" class="formfield"></input> 
               </td></tr>    
          <tr><td></td><td><font class="tooltits">e.g Habib Bank Zurich</font></td></tr> 
          
           <tr><td>Opening amount:</td><td><input id="opam" type="text"  onkeypress="return isNumberKey(event);" class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g 48000</font></td></tr>
          <tr><td></td><td><button id="savbnk" class="formbuttons">Save</button></td><td>
               </td></tr>
         </table>
     
           
           <?php
           }
           else if($action=="edit"){
           echo "<div id='suppliersFilterBar' style='width:830px'> <button id='supprint' class='formbuttons' style='float: left;margin:4px 0px 4px 4px'>Print</button></div>";
     
           $qer="SELECT * FROM estate_bankaccounts WHERE estate_id LIKE '$id'"; 
      
       $data=$mumin->getdbContent($qer);
     
      
      echo "<table id='editsupp' class='invview'>"; 
      echo '<thead>';
       echo "<tr><th>SN</th><th>Acc .No</th><th style='font-size:10px'>Acc. Name</th><th style='font-size:10px'>Bank -Branch</th><th style='font-size:10px'>Balance</th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
               
               
     echo "<tr><td  id='cgl".$j."'>".$data[$j]['id']."</td><td id='cnl".$j."'>".$data[$j]['acno']."</td><td id='ctl".$j."'>".$data[$j]['acname']."</td><td id='cml".$j."' >".$data[$j]['bankname']."</td><td id='cpl".$j."'>".$data[$j]['amount']."</td><td></tr>";
      
             }
      echo '</tbody>';
      echo "</table>";
       
           
            
           }
           ?>
             
 <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
 <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
  </div>
      
      
      
      
     
      
  </div>
    
</div>
        
    </div>
    
  </div>
    
    
      
    
    
    
     
     
    
      
    
</div>
</body>
</html> 