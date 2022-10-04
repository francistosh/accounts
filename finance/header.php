<?php
 
   
 
include '../partials/stylesLinks.php';  
 
include 'links.php';



?>
<div id="div_pagecontainer">
    <div id="div_pageheader">
  	<div id="div_orglogo"><img src="../assets/images/smallhomegoldlogo.png" width="80" height="84" alt="Mombasa Jamaat Home"/></div>
    <div id="div_orgname">
    	<h1 class="titletext"></h1>
    </div>
    <div id="div_currentlocation">
    	<h2 class="titletext"></h2>
    </div>
  </div>
  <div id="div_pagecontent">
  	<div id="div_logindetails">You are logged in as:  <?php echo $_SESSION['jname'];?></div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
   	<?php include_once 'adminleftmenu.php'; ?>
