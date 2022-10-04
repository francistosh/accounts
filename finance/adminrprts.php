<?php

ob_start();

session_start();

if(!isset($_SESSION['jmsloggedIn'])){
  
    echo  "You must Login to see this page : <a href='../index.php'>Click to Login</a>";
       
}
else if(isset($_SESSION['jmsacc'])!="999" || isset($_SESSION['jmsacc'])!="10"){
     
     echo  "Access denied : <a href='../index.php'>Contact admin for assistance</a>";
}
 

else{

include '../partials/stylesLinks.php';  
 
include 'links.php';

include './operations/Mumin.php';

$mumin=new Mumin();

//$usr=$_SESSION['uname'];  
    $deptids = array();
//$access=$_SESSION['grp'];   
$userid = $_SESSION['acctusrid'];
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' ORDER BY deptid";
 
$priviledges=$mumin->getdbContent($qr2);
 for ($h=0;$h<=count($priviledges)-1;$h++){
          $deptids[] =+ $priviledges[$h]['deptid'];
      }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jims2 | Reports</title>
 <?php include 'links.php'; ?>
<script>
    $(function() {
     $("#sdate12").datepicker({ dateFormat: 'dd-mm-yy',onClose: function( selectedDate ) {
$( "#edate12" ).datepicker( "option", "minDate", selectedDate );
}} );
      $("#edate12").datepicker({ dateFormat: 'dd-mm-yy',onClose: function( selectedDate ) {
$( "#sdate12" ).datepicker( "option", "maxDate", selectedDate );
}} );
       $("#admlistview").live('click',function(){
          var $fromdate12=$("#sdate12").val();
          var $todate12=$("#edate12").val();
         
        window.open('../finance/receiptsreport.php?sdate='+$fromdate12+'&edate='+$todate12,'','width=1300,height=800,toolbar=0,menubar=1,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
      
  });
  
 });
    </script>
<style type="text/css">
  .menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
        padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	 background: #357918;
         color: white;
         border: solid 1px;
         border-radius: 3px;
         line-height: 30px;
	}

.menuitems a:visited {
	text-decoration:none;
	color:#333;
	
	}
        .footer { margin:auto; margin-top:15px; width:925px; height:38px; text-align:left; }
.footer td { color:#FFF; }
.footer a { color:#FFF; margin: 0px 10px; }
</style>

</head>

<body>
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
      <div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> </div>
      <span style="text-align: right;display:block;">Welcome</span>
      </div>
      
      <!--Left Panel Starts Here-->
<?php 
     include_once  'adminleftmenu.php';
 ?>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
    
	  <div id="div_navigation">
      	<ul id="menu">
            <li><a href="#">Database</a>
                <div class="dropdown_column">  
                <a href="<?php if(intval($priviledges[0]['database'])==1){ echo "database_reports.php?action=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Mumineen data</p></a> 
                 <a href="<?php if(intval($priviledges[0]['database'])==1){ echo "database_reports.php?action=";}else{ echo "#";} ?>" class="navButton"><p class="navButton">Financial data</p></a>
        	</div> 
            </li> </ul>
      </div>
        <div id="tabs2">
            <fieldset style="border: 1px ghostwhite solid"><legend style="color: black;font-size: 13px;font-weight: bold">Choose Category</legend>
            <table  class="ordinal"> 
                   
                   
                   
                   <tr><td>From Date :</td><td><input id="sdate12" name="sdate12"   class="formfield" value="<?php echo date('d-m-Y');?>"/></td></tr>
                   <tr><td>To Date :</td><td><input  id="edate12"  name="edate12" class="formfield" value="<?php echo date('d-m-Y');?>"/></td> </tr>
                   <tr><td></td><td><button class="formbuttons"  id="admlistview">View List</button></td><td></td><td></td></tr></table> 

            </fieldset>

      </div>
    </div>
    <!--Right Panel Ends Here-->
    
  </div>
 <?php include 'footer.php' ?>
</div>
     <script>
$('.arrow').addClass('collapsed');

$('#menu-primary-navigation > li > a.arrow').click(function(e) {  // select only the child link and not all links, this prevents sub links from being selected. 
    var sub_menu = $(this).next('.sub-menu'); // store the current submenu to be toggled  
    e.preventDefault();
    $('.sub-menu:visible').not(sub_menu).slideToggle('fast'); // select all visible sub menus excluding the current one that was clicked on and close them 
    sub_menu.slideToggle('fast'); // toggle the current sub menu 
	
    $("li a.arrow").addClass('collapsed');  // Add the collapse class to the clicked a	 
    $(this).removeClass('collapsed').addClass('expanded');    //Remove the collapse class from only the clicked tag
});
</script>
</body>
</html>
<?php
}
ob_flush();
?>