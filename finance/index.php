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
<title>Jims2 | Accounts </title>
 <?php include 'links.php'; ?>
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
  .label-danger {
  background-color: #d9534f;
}
.label {
  display: inline;
  padding: .2em .6em .3em;
  font-size: 75%;
  font-weight: bold;
  line-height: 1;
  color: #fff;
  text-align: center;
  white-space: nowrap;
  vertical-align: baseline;
  border-radius: .25em;
  float: right;
}      
        .footer { margin:auto; margin-top:15px; width:925px; height:38px; text-align:left; }
.footer td { color:#FFF; }
.footer a { color:#FFF; margin: 0px 10px; }
</style>
<script>
     $(function() {
    (function blink() { 
  $('.label').fadeOut(500).fadeIn(500, blink); 
})();
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
     });
    </script>
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
<?php if($_SESSION['jmsgrp']!= 'ADMIN') {include_once  'homeleftmenu.php'; }  else {
     include_once  'adminleftmenu.php';
 }?>
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
        <div id="tabular">
           
      <?php 
   
                      $colourSet = array(
        'green','blue','gum','green','orange','brown','green','purple','red','blue','gum'
    );
      $numColours = count($colourSet);
     
    $colourInd = 0;
    if($priviledges[0]['admin'] == '1'){
        $qrdpts="SELECT deptid,deptname,descr FROM department";
        } else{
            $qrdpts="SELECT deptid,deptname,descr FROM department WHERE active = '1' ";
        }
        $dprtmnts=$mumin->getdbContent($qrdpts);
        $todate =  date('Y-m-d');
         for($j=0;$j<=count($dprtmnts)-1;$j++){
             
             $dptnt = $dprtmnts[$j]['deptname'];
             $dprtid = $dprtmnts[$j]['deptid'];
             $deptdesc = $dprtmnts[$j]['descr'];
              $qrpds=$mumin->getdbContent("SELECT * FROM pdchqs WHERE rdate <= '$todate' AND est_id = '$dprtid' AND banked = '0'");
              if(count($qrpds)>0){
                  $show = '<span class="label label-danger">'.count($qrpds).'</span>';
              }else{
                  $show = '';
              }
             if(in_array($dprtid, $deptids)){ $display = "accounts.php?action=$dprtid"; $title="";}else{ $display = "#"; $title="Contact Admin! $dptnt : Access Denied";}
             //echo '<div id="b"><a class="butt '.$colourSet[$colourInd].'" href="accounts.php?action='.$dprtid.'"><h3>'.$dptnt.'</h3></a></div>';
            echo '<div id="b"><a  class="butt '.$colourSet[$colourInd].'" href="'.$display.'" title="'.$title.'">'.$show.'<h3>'.$dptnt.'</h3><p>('.$deptdesc.')</p></a></div>';

              $colourInd = ($colourInd + 1) % $numColours;
         }
        ?>

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