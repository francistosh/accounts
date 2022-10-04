  <?php
session_start();  
 
if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    
    $id=$_SESSION['dept_id'];
//die($id);
    $userid = $_SESSION['acctusrid'];
    if($level>999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);
if($priviledges[0]['receipts']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $displ = '';
     $rcptsearch = '';
     $recpsearch = '';
     $pdsubmit = '';
}else if($priviledges[0]['readonly']!=1){
    $displ = '<button id="ckreceipt">complete</button>';
    $pdsubmit = '<button id="pdsubmit">Submit</button>';
    $rcptsearch = '<button name="rcptsearch" id="rcptsearch"> Search</button>';
    $recpsearch = '<button name="recpsearch" id="recpsearch"> Search</button>';
}
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>PDs | Jamaat  Information System</title>
    
 
<?php

include '../partials/stylesLinks.php';  
 
include 'links.php';
 

?>
     
<script>
    
    
$(function() {
   $("#pdchqbank").click(function(){
      $("#rep_pdchqs").show();

   });
   $('#editsupp').dataTable( {
	"bSort":false,
	// "sPaginationType": "full_numbers",
	"iDisplayLength": 25,
	"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
	"bJQueryUI": true
  } );
  	$( "#dialog-message" ).dialog({
			modal: true,
			width: 400,
			buttons: {
				Ok: function() {
				window.location.replace("pdcheqs_operation.php");
				}
		}
});
$( "#from_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#to_date" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#to_date" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#from_date" ).datepicker( "option", "maxDate", selectedDate );
}
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
         color: #FFF;
         border-radius: 3px;
         line-height: 30px;
         
	}
        .menuitems li a:hover{
            color: white;
        }
.menuitems a:visited {
	text-decoration:none;
	color:#333;
	
	}
        label 
{
width: 200px;
padding-left: 20px;
margin: 5px;
float: left;
text-align: left;
}
        
	</style>

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
</head>
   
<body> 
  
    <?php
    
                              
                                
                                $id=$_SESSION['dept_id'];
                                
                                $qr11="SELECT deptname FROM department WHERE deptid LIKE '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['deptname'];
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</span></div>
      <span style="text-align: right;display:block">Company: <b><?php echo $_SESSION['dptname'];?></b></span>
      </div>
    <!--Left Panel Starts Here-->
    <div id="div_leftpanel">
 
      <?php include_once 'leftmenu.php'; ?>
  
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
         <?php include_once 'topmenu.php'; ?>
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext"></h3>

        </div>
        <div id="div_formcontainer">
        	<div id="tabs2">
    <?php 
     
     $type=@$_GET['type'];
     
     
     if($type==""){
         ?>
    <?php
     }
         ?>
              
  

            <?php 
                  $startdate = $_GET['from_date'];
                  $todate =  $_GET['to_date'];
                  $qrpds=$mumin->getdbContent("SELECT * FROM pdchqs WHERE rdate BETWEEN '$startdate' AND '$todate' AND est_id = '$id' AND banked = '0'");
                 if(count($qrpds) == 0)
{
    die('<div id="dialog-message" title="PD Cheques for Banking!">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:4px 5px 50px 0;"></span>
	<b>Sorry, there are no PD cheques ready to be banked. </b></p></div>');
}
                  ?>
            
            <fieldset style="border: 1px gold solid"><legend style="color: #00BFFF;font-weight: bold;font-style: italic;font-size: 14px">Matured PD Cheques</legend>
         <form method="post" name="pdcheqs" id="pdcheqs" action="postpdcheqs.php">
                <table id='editsupp' style="width:100%;"> 
            <thead>
       <tr><th hidden></th><th>Date</th><th>Sabil No</th><th>Names</th><th>Chq No</th><th>Bank</th><th>Account</th><th>Amount</th><th>Select</th></tr>
            </thead>
      <tbody>
      
            <?php
            $t=1;
      for($k=0;$k<=count($qrpds)-1;$k++){    
             $name = $mumin->get_MuminHofNamesFromSabilno($qrpds[$k]['sabilno']);
             $incmactnme = $mumin->getincmename($qrpds[$k]['incacc']);   
     echo "<tr><td hidden='true' id='incmact".$k."'>".$qrpds[$k]['incacc']."</td><td  id='cgl".$k."'>".$qrpds[$k]['rdate']."</td><td id='pdsablno".$k."'>".$qrpds[$k]['sabilno']."</td><td id='cnl".$k."'>".$name."</td><td id='ctl".$k."'>".$qrpds[$k]['chqno']."</td><td id='cml".$k."' >".$qrpds[$k]['chqdet']."</td><td>".$incmactnme."</td><td id='cpdamnt".$k."' style='text-align:right'>".number_format($qrpds[$k]['amount'],2)."</td><td><input type='checkbox' class='selectpdchq' name='chqtobank[]' id='chqtobank".$k."' value='".$qrpds[$k]['tno']."'></input></td></tr>";
           // <a id='v".$j."' class='changedelete5' href='#'>Delete</a>
             }?>
      </tbody>
      </table><br>
                <input class="submitbutton" name="bankslctdpds" type="submit" value="Receipt Selected Cheque"/> <br>&nbsp;</br> 
                </form>
                </div>
            </fieldset>
            <table id="invoicesstable2" class="ordinal" style="width: 100%"></table>  

           </div>
        </div>
        
      </div>

    </div>
    <!--Right Panel Ends Here-->
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