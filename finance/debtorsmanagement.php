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

if($priviledges[0]['debtors']!=1){
   
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
  
           $( "#supprint" ).button({
            icons: {
                primary: "ui-icon-print"
            },
            text: false
             }).click(function(){
            
            var newWin= window.open("");
            newWin.document.write(document.getElementById("editsupp").outerHTML);
            newWin.print();
            newWin.close();
          return false; 
 
       });
       
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
         border-radius: 3px;
         line-height: 30px;
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
    
    $qr="SELECT ccname FROM costcenters WHERe ccid LIKE '$id'";
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
                    
                 <!-- <li class="menuitems"><a href="create_invoice.php?idaction=new">New Invoice</a></li> -->
                  <li class="menuitems"><a href="debtorsmanagement.php?action=new">Add new debtor</a></li> 
                 <li class="menuitems" ><a href="debtorsmanagement.php?action=edit">View/Edit debtor</a></li>
                 
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
        	<h3 class="titletext">Debtor's sub-section</h3>
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
          <tr><td>Debtor Name (*):</td><td><input  type="text" id="debname" class="formfield"></input></td></tr>            
          <tr><td></td><td><font class="tooltits">e.g  Kenchic retailers</font></td></tr>  
           <tr><td>Debtor telephone (*):</td><td><input id="debmobile" type="text" class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g 0710123456,0711123456,0712123456</font></td></tr> 
          
           <tr><td>Email address (*):</td><td><input id="demail" type="text"   class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g xyz@yahoo.com,xyz@gmail.com</font></td></tr>
          
          <tr><td>Postal Address &amp; Zip:</td><td><input id="dzip" type="text"  class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g 20100-00100</font></td></tr>
          <tr><td>City:</td><td><input id="dcity" type="text"  class="formfield"></input> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">e.g Mombasa,Nakuru e.t.c</font></td></tr>
          
          <tr><td>Remarks:</td><td><textarea class="formfield" id="debrmks" ></textarea> 
               </td></tr>
          <tr><td></td><td><font class="tooltits">Brief remarks</font></td></tr>
          <tr><td></td><td><button id="savdebtor" class="formbuttons">Save</button>&nbsp;<button id="cacldebtor" class="formbuttons">Cancel</button>  
               </td></tr>
         </table>
      
      
           
           <?php
           }
           else if($action=="edit"){
           echo "<div id='suppliersFilterBar'><button id='supprint'  style='float: left'>Print</button></div>";
     
           $qer="SELECT * FROM estate_debtors WHERE estId LIKE '$id'"; 
      
       $data=$mumin->getdbContent($qer);
    
        
      
      echo "<table id='editsupp' class='invview'>"; 
      echo '<thead>';
       echo "<tr><th>SN</th><th>Names</th><th style='font-size:10px'>Telephone</th><th style='font-size:10px'>Email</th><th style='font-size:10px'>Postal Addr</th><th style='font-size:10px'>City</th><th style='font-size:10px'></th>";
      echo '</thead>';
      echo '<tbody>';
      for($j=0;$j<=count($data)-1;$j++){    
               
               
     echo "<tr><td  id='cgl".$j."'>".$data[$j]['dno']."</td><td id='cnl".$j."'>".$data[$j]['debtorname']."</td><td id='ctl".$j."'>".$data[$j]['debTelephone']."</td><td id='cml".$j."' >".$data[$j]['email']."</td><td id='cpl".$j."'>".$data[$j]['postal']."</td><td id='ccl".$j."'>".$data[$j]['city']."</td><td><a id='k".$j."' class='changedebtoraction' href='#'>Edit</a>&nbsp;|&nbsp;</td></tr>";
       // <a id='v".$j."' class='changedelete5' href='#'>Delete</a>
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
    
   
    
    

    
    
    
     
    <div id="deleteconfirm5" style="display:none ;color: red" title="Confim Deletion">
        <input type="hidden" id="cidd"></input>
        <p ><u>Are you sure you want to delete ?</u> </p><p>This action is permanent and irreversible. All records and statement attached to this debtor would be deleted and become inaccessible permanently</p> 
        <table><tr><td><button id="okcancel5">Cancel</button> </td><td><button id="okdelete5">Ok,Delete</button></td></tr></table>
    </div>
    
          </div>
    </div>
          </div>
</div>
</body>
</html> 