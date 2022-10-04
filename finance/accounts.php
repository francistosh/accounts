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
 
//$access=$_SESSION['grp'];   
$_SESSION['dept_id'] = $_GET["action"];
$id=$_SESSION['dept_id'];

$qr="SELECT deptname,tel AS mobno,email AS estemail FROM department WHERE deptid LIKE '$id'";

$est=$mumin->getdbContent($qr);

$estname=$est[0]['deptname'];
$_SESSION['dptname'] = $estname;
$mobno = $est[0]['mobno'];
$estemail =  $est[0]['estemail'];
$userid = $_SESSION['acctusrid'];

$qrey ="SELECT name,email,mobno,details FROM anjuman_details";
$compny=$mumin->getdbContent($qrey);
$_SESSION['anjumname'] = $compny[0]['name'];
$_SESSION['email'] = $compny[0]['email'];
$_SESSION['mobno'] = $compny[0]['mobno'];
$_SESSION['details'] = $compny[0]['details'];

$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

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
        .topBar {
	width: 100%;
	height: 22px;
	position:relative;
	top: 0;
	text-align: center;
	border-bottom: 1px solid #500;
	box-shadow: 0 2px 5px #ccc;
	padding-top: 4px;
	color: #fff;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	-moz-border-radius:3px;
    -webkit-border-radius:3px;
    border-radius:3px;
    -moz-box-shadow:0 0 5px #700;
    -webkit-box-shadow:0 0 5px #700;
    box-shadow:0 0 5px #700;
	z-index:1000;
}
.topBar .link {
	padding: 2px 8px;
	background-color: #831e1a;
	color: #fff;
	border-radius: 2px;
	font-size: 12px;
	font-weight: bold;
}
.topBar .link:hover {
	/* background-color: #e62601; */
	background-color: #4787ed
}
.topBar a {
	text-decoration: none;
	color: #fff;
}
.topBar:target {
	top: -36px;
	position: absolute;
	-webkit-transition: top 0.4s ease-in;
	-moz-transition: top 0.4s ease-in;
}
.topBar:target .btnOpen {
	top: 31px;
	height: 30px;
	font-size: 12px;
	line-height: 34px;
	-webkit-transition-property: top;
	-webkit-transition-duration: .4s;
	-moz-transition-property: top;
	-moz-transition-duration: .4s;
}
.topBar:target .btnClose {
	display: none;
}
.topBar:target .btnOpen, .topBar {
	background: rgb(226,87,81);
	background: -moz-linear-gradient(top,  rgba(226,87,81,1) 0%, rgba(228,93,86,1) 49%, rgba(213,82,76,1) 50%, rgba(226,87,81,1) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(226,87,81,1)), color-stop(49%,rgba(228,93,86,1)), color-stop(50%,rgba(213,82,76,1)), color-stop(100%,rgba(226,87,81,1)));
	background: -webkit-linear-gradient(top,  rgba(226,87,81,1) 0%,rgba(228,93,86,1) 49%,rgba(213,82,76,1) 50%,rgba(226,87,81,1) 100%);
	background: -o-linear-gradient(top,  rgba(226,87,81,1) 0%,rgba(228,93,86,1) 49%,rgba(213,82,76,1) 50%,rgba(226,87,81,1) 100%);
	background: -ms-linear-gradient(top,  rgba(226,87,81,1) 0%,rgba(228,93,86,1) 49%,rgba(213,82,76,1) 50%,rgba(226,87,81,1) 100%);
	background: linear-gradient(top,  rgba(226,87,81,1) 0%,rgba(228,93,86,1) 49%,rgba(213,82,76,1) 50%,rgba(226,87,81,1) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e25751', endColorstr='#e25751',GradientType=0 );
}
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
         <?php
         $startdate = date('Y-m-d');
                  $todate =  date('Y-m-d');
                  $qrpds=$mumin->getdbContent("SELECT * FROM pdchqs WHERE rdate <= '$todate' AND est_id = '$id' AND banked = '0'");
                 if(count($qrpds) >0){
                     echo '<div class="topBar" id="notify">';
echo 'Welcome '.$_SESSION['jname'].'! You have: <a href="listpdcheques.php?from_date=2016-01-01&to_date='.$todate.'" title="'.count($qrpds).' PD Cheques due for banking" class="link"> (&nbsp;'.count($qrpds).'&nbsp;)&nbsp; PD Cheques due for banking</a>&nbsp;
</div>'; 
                 }
         
         
        if(date("d")<="20"){
        $lastmonthstart=date("d-m-Y", mktime(0, 0, 0, date("m")-1, 1, date("Y")));
        $lastmonthend=date("d-m-Y", mktime(0, 0, 0, date("m"), 0, date("Y")));
        $emailalert="<a class='link' href='email-statement.php?start=".$lastmonthstart."&end=".$lastmonthend."'>Email Last Month Statements?</a>";
       // echo $emailalert;
        
        }?>
    	<h2 class="titletext"></h2>
    </div>
  </div>
  <div id="div_pagecontent">
      <div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</span></div>
          <span style="text-align: right;display:block">Company: <b><?php echo $estname;?></b></span>
      </div>
      
      <!--Left Panel Starts Here-->
<?php include_once 'leftmenu.php'; ?>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
    
<?php include_once 'topmenu.php'; ?>
      
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