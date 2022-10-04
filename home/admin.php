<?php 
session_start(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Anjuman -e- Burhani, Mombasa</title> 
<?php
include '../partials/stylesLinks.php'; 
?>
<link href="../finance/css/1-CommonLayout.css" rel="stylesheet" type="text/css" />
<link href="../finance/css/2-JamaatNavMenu.css" rel="stylesheet" type="text/css" />
<link href="../finance/css/theme.css" rel="stylesheet" type="text/css" /> 
<link href="../finance/css/3-JamaatLevel3.css" rel="stylesheet" type="text/css" />
<link href="../finance/css/3-JamaatForms.css" rel="stylesheet" type="text/css" />  
<link href="../finance/css/3-JamaatTabs.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../finance/css/override.css"/>

 
</head>
    
<body style="overflow-y: hidden;">
         
 <div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"> Mombasa Jamaat Online</h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext">System</h2>
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
                    
            
                 
          <li class="menuitems"><a href="../general/logindata.php?action=logout" class="menuitems"> Log Out</a> </li>
       </ul>
        </div>
      </div>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Super Admin</h3>
        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
         
    
  
    <table class="ordinal" style="background: transparent">     
        
        <tr><td><a style="text-decoration: none" href="../muminoperations/"><div class="button mumin"  id="b_mumin"><h2>Mumin operations</h2></div></a></td>
            <td><a  style="text-decoration: none" href="../office/"><div class="button office" ><h2>Accounts</h2></div></a></td>  
        <td><a style="text-decoration: none" href="../properties/"><div class="button estates"  ><h2>Properties</h2></div> </a></td></tr>
        <tr><td><a style="text-decoration: none" href="../finance/setup.php?action="><div class="button property" ><h2>Estates</h2></div></a></td>
        <td><div class="button employee"  href="#"><h2>Employees</h2></div></td>
        <td><a style="text-decoration: none" href="../general/logindata.php?action=logout"><div id="b_home" class="button fmb" ><h2>FMB</h2></div></a></td></tr>
        
         
   </table>     
   
  </div>  
  </div>
</div>
    </div>
  </div>
 </div>
</body>
</html>