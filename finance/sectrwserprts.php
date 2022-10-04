<?php
session_start(); 

if(!(isset($_SESSION['eloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['acc'];
    
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE id LIKE ".$_SESSION['priviledge']." LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['statements']!=1){
   
header("location: index.php");
}
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

$usr=$_SESSION['uname'];  
 
$access=$_SESSION['grp'];   

$id=$_SESSION['est_prop'];

$moh=$_SESSION['mohalla']; 
 

?>

<script src="../assets/js/framework/jquery.localisation-min.js"></script>
<script src="../assets/js/framework/jquery.scrollTo-min.js"></script>
<script src="../assets/js/framework/ui.multiselect.js"></script>
<link  type="text/css" href="../assets/css/ui.multiselect.css" rel="stylesheet"/>   
<script>
     $(function() {
     $( "#miestart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#mieend" ).datepicker( "option", "minDate", selectedDate );
}
}); 

   $( "#mieend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#miestart" ).datepicker( "option", "maxDate", selectedDate );
}
});

     $( "#constart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#conend" ).datepicker( "option", "minDate", selectedDate );
}
}); 
       $( "#conend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#constart" ).datepicker( "option", "maxDate", selectedDate );
}
});
  $( "#statstart" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#statend" ).datepicker( "option", "minDate", selectedDate );
}
});

  $( "#statend" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#statstart" ).datepicker( "option", "maxDate", selectedDate );
}
});
$("#contrsumry").button({
            icons: {
                primary: "ui-icon-check",
                secondary: "ui-icon-triangle-1-e" 
            }
        });

$("#contrsu").button({
            icons: {
                primary: "ui-icon-carat-2-n-s",
                secondary: "ui-icon-triangle-1-e" 
            }
        });
    $("#statisticsgenerate").button({
            icons: {
                primary: "ui-icon-carat-2-n-s",
                secondary: "ui-icon-triangle-1-e" 
            }
        });
$("#contrsumry").click((function(){ 
    var startdte = $("#constart").val();
    var endte = $("#conend").val();
    var actname = $("#contribacc").val();
    
    window.open('../finance/contributionrprt.php?type=list&startdate='+startdte+'&todate='+endte+'&actid='+actname+'&sector=','','width=1500,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
    
    }));
$("#contrsu").click((function(){ 
    var startdte = $("#constart").val();
    var endte = $("#conend").val();
    var actname = $("#contribacc").val();
    
    window.open('../finance/contributionrprt.php?type=summary&startdate='+startdte+'&todate='+endte+'&actid='+actname+'&sector=','','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
    
    }));

$("#statisticsgenerate").click((function(){ 
    var startdte = $("#statstart").val();
    var endte = $("#statend").val();
    var actname = $("#statbacct").val();
    
    window.open('../finance/statistics.php?type=summary&startdate='+startdte+'&todate='+endte+'&actid='+actname+'&sector=','','width=800,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');
    
    }));

$("#muminiestate").click((function(){ 
    var startdte = $("#miestart").val();
    var endte = $("#mieend").val();
   
    window.open('../finance/statistics.php?type=incmexpsummary&startdate='+startdte+'&todate='+endte+'&actid=&sector=','','width=900,height=800,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=0,left=0,top=0');
    
    }));
     });
 
</script>

<style>
      
     
.menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
	padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	  background: #357918;
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
	 
 
    #div_toAccount{
        width: 350px;
        height: 35px;
        background: transparent;
        z-index: 10;
        color: black;
        font-size: 20px;
        left: 610px;
        top: 390px;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        position: absolute;
        
        
    }
     #div_fromAccount{
        width: 350px;
        height: 35px;
        background: transparent;
        z-index: 10;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        color: black;
        font-size: 20px;
        left: 610px;
        top: 331px;
        position: absolute;
        
        
    }
      
    </style>


</head>  
    
<body style="overflow-x: hidden;"> 
     
        <?php  
                          
                                   
                                
                                $qr11="SELECT estate_name FROM anjuman_estates WHERE est_id = '$id' LIMIT 1";
                               
                                 $data11=$mumin->getdbContent($qr11);
                                
                                 $estname=$data11[0]['estate_name'];
                                  
                                
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['uname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp<span style="text-align: right; display:<?php if($_SESSION['grp']=='EXTERNAL'){ echo 'block;';} else{ echo 'none';}?>"> Sector: &nbsp<?php echo $_SESSION['sector'];?></span></div>
      <span style=" text-align: right;display:<?php if($_SESSION['grp']=='MASOOL'){ echo 'block;';} else{ echo 'none';}?>"> MASOOL</span>
      </div>
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
      	<div id="div_menutitle">Dash Board</div>
        <div id="div_menucontent">
       
        	<ul class="menuitems">
                    
            <li class="menuitems" ><a href="sectrwserprts.php?type=contribsummry">Contribution Summary</a></li>
            <li class="menuitems"><a href="sectrwserprts.php?type=statistics">Statistics</a></li>
            <li class="menuitems"><a href="sectrwserprts.php?type=inexpense">Income Summary</a></li>
            <li class="menuitems" ><a href="#">Reports 4</a></li> 
           <li class="menuitems"><a href="logout.php" class="menuitems"> Log Out</a> </li>
       </ul>
        </div>
      </div>
    </div>
    <!--Right Panel Starts Here-->
    <div id="div_rightpanel">
   	  <div id="div_datainput">
      	<div id="div_formtitle">
        	<h3 class="titletext">Sector Reports </h3>
        </div>
        <div id="div_formcontainer">
            
        <div id="tabs2">
                <?php
            
            $type=$_GET['type'];
            
            if($type=="inexpense")
            {
            ?>
            <fieldset style="border: 1px #6f2c2c solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Income/Expense Summary</legend> 
                        <table class="ordinal" >
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="miestart" name="miestart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="mieend" name="mieend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td></td><td><button id="muminiestate">Generate</button></td></tr>
                     </table>
                </fieldset>
               <?php
            }
            elseif ($type=="contribsummry") { ?>
                 <fieldset style="border: 1px #6f2c2c solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Contribution Report</legend> 
                        <table class="ordinal" >
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="constart" name="constart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="conend" name="conend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                <tr><td>Account Name:</td><td><select class="formfield" id="contribacc">
                            
                                <?php
                                $qr="SELECT * FROM estate_incomeaccounts where `$id` = '1'"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select></td></tr>
                     <tr><td></td><td colspan="2"><button id="contrsumry">List</button> &nbsp;<button id="contrsu">Summary</button></td></tr>
                     </table>
                </fieldset>  
            <?php
                }
                elseif ($type=="statistics") {
                ?>
                    <fieldset style="border: 1px #6f2c2c solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend style="color: #00BFFF;font-weight: bold;font-style: italic">Statistics</legend> 
                        <table class="ordinal" >
                     <tr><td>Start Date :</td><td style="width: 80px"><input id="statstart" name="statstart" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td><td>&nbsp;End date :</td><td><input id="statend" name="statend" class="formfield" value="<?php echo date('d-m-Y'); ?>"/></td></tr>
                     <tr><td>Account Name:</td><td><select class="formfield" id="statbacct">
                            
                                <?php
                                $qr="SELECT * FROM estate_incomeaccounts where `$id` = '1'"; 
                                
                                $data=$mumin->getdbContent($qr);
                                
                                 for($h=0;$h<=count($data)-1;$h++){
                      
                                     echo "<option value=".$data[$h]['incacc'].">".$data[$h]['accname']."</option>";
                                   } 
                            
                            ?>
                        </select></td></tr>
                     <tr><td></td><td><button id="statisticsgenerate">Generate</button></td></tr>
                     </table>
                </fieldset>
                <?php
                        }
              ?>
         </div>
   
 </div>
 
</div>
      
</div>     
        
</div>
</div>
</body>
</html>