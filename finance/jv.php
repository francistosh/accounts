<?php
session_start(); 

if(!(isset($_SESSION['jmsloggedIn']))) {
  
header("location:../index.php"); 
    
}
else{
  
    $level=$_SESSION['jmsacc'];
    $id=$_SESSION['dept_id'];
    $userid = $_SESSION['acctusrid'];
    if($level >999){
  
        header("location: ../index.php"); 
        
    }
    else{
   
include 'operations/Mumin.php';

$mumin=new Mumin();
  
$qr2="SELECT * FROM priviledges WHERE userid = '$userid' AND deptid = '$id' LIMIT 1";

$priviledges=$mumin->getdbContent($qr2);

if($priviledges[0]['jv']!=1){
   
header("location: index.php");
}
if($priviledges[0]['readonly']==1){
    $jvcreate = '';
     $creatable = '';
}else if($priviledges[0]['readonly']!=1){
    $jvcreate = '<button id="passjv" class="formbuttons" >Create</button>';
    $creatable = '<input  type="submit" id="creatable" value="Append" class="formfield" style="width: 100px; font-weight: bold"></input>';
       }
}
}
date_default_timezone_set('Africa/Nairobi');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
   
<head>
<title>Journals</title>
    
 
<?php

include '../partials/stylesLinks.php';  

 
include 'links.php';


?>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
    <script>
    $(function() {
        
      var clsingdate = $("#clsingdate" ).val(); 
    
      $("#jvdate" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: parseInt(clsingdate)+parseInt(1)} );
         $("#journaldate" ).datepicker({ dateFormat: 'dd-mm-yy',minDate: parseInt(clsingdate)+parseInt(1)} );
  $("#jvckdate" ).datepicker({ dateFormat: 'yy-mm-dd'} );
    
 $("#ckdte" ).datepicker({ dateFormat: 'dd-mm-yy'} );
$( "#jvstartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#jvenddate" ).datepicker( "option", "minDate", selectedDate );
}
});
$( "#jvenddate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#jvstartdate" ).datepicker( "option", "maxDate", selectedDate );
}
}); 
$( "#jentrystartdate" ).datepicker({
defaultDate: "+1w",
changeMonth: true,
numberOfMonths: 1,
dateFormat: 'dd-mm-yy',
onClose: function( selectedDate ) {
$( "#jentryenddate" ).datepicker( "option", "minDate", selectedDate );
}
});



  
   $("#printjv").button({
            icons: {
                primary: "ui-icon-print"
                
            }
        });
        
         $("#newjv").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
        });
    
     $("#passjv").button({
            icons: {
                primary: "ui-icon-document"
                 
            }
        });
         
        $("#jvlist").button({
            icons: {
                primary: "ui-icon-bookmark"
                
            }
        });
        $('.amount') .keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ colorize: true, roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
   });
      
      
    });
 
</script>
<link rel='stylesheet' type='text/css' href='properties/js/print.css' media="print" />
 
 <style>
      
.menuitems a:link {
	text-decoration:none;
	color:#333;
	font-size:11px;
        padding:10px 5px 10px 5px;
	}
	
 
  .menuitems li:hover {
	 background: #357918;
         color: white;
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
         
        height: 35px;
        background: transparent;
        
        color: black;
        font-size: 12px;
         
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
       
        
        
    }
     #div_fromAccount{
        
        height: 35px;
        background:  transparent;
        z-index: 10;
        text-align: left;
        vertical-align: middle;
        line-height: 35px;
        color: black;
        font-size: 12px;
         
         
        
        
    }
      
    </style>
    
</head>
   
<body style="overflow-x: hidden;"> 
  
    
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
  	<div id="div_logindetails" ><div>You are logged in as: <?php echo $_SESSION['jname'];?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp</div>
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

        <div id="div_formcontainer">
            
        <div id="tabs2">
    
    <?php
        
        @$action=$_GET['action'];
        
        if($action=="new"){
            
            ?>
          <fieldset style="border: 1px ghostwhite solid;margin: 10px;color: black;font-size: 15px;font-weight: bold"> 
            <legend>New Bank J.V</legend>
            <!--<form method="post" action="">!-->
            <table  class="ordinal">
            
                <tr><td>Date :</td><td><?php
                                 
                                $qrtr="SELECT deptid as estate_id,cdate as date FROM closing_period WHERE deptid = '$id' ORDER BY id DESC LIMIT 1 "; 
                                
                                $datatr=$mumin->getdbContent($qrtr);
                                
                                 for($h=0;$h<=count($datatr)-1;$h++){
                                   $qru=  "SELECT DATEDIFF('".$datatr[$h]['date']."','".date('Y-m-d')."') AS DiffDate";
                                    $datau=$mumin->getdbContent($qru);
                                    for($k=0;$k<=count($datau)-1;$k++){
                                     echo "<input hidden='true' type='text' id='clsingdate'  class='formfield' value='".$datau[$k]['DiffDate']."'>";
                                   //  echo "<option value=".$data[$h]['date'].">".$data[$h]['date']."</option>";
                                   } }
                            
                            ?>
		<input id="jvdate" value="<?php echo date('d-m-Y')?>" name="jvdate"  class="formfield" ></input></td><td></td></tr>
                 <tr><td>From Account:</td><td id="crdtbnk">
                    <select name="jvto2" id="jvto2" class="formfield">
                    <option value="" >-- Select Acct --</option>
                            <?php
                                  
                                  
                                $q4="SELECT bacc,acname,acno FROM bankaccounts WHERE deptid LIKE '$id' UNION SELECT incomeaccounts.incacc,accname,' ' as typ FROM incomeaccounts,incomeactmgnt WHERE (typ = 'G' OR typ = 'L') AND incomeactmgnt.incacc = incomeaccounts.incacc AND incomeactmgnt.deptid = '$id'";
                                   
                                $data4=$mumin->getdbContent($q4);
                                
                                 for($k=0;$k<=count($data4)-1;$k++){ 
                      
                                    echo "<option value=".$data4[$k]['bacc'].">".$data4[$k]['acname'] ." ".$data4[$k]['acno']."</option>";
                                      }
                                 
                                   
                            ?>    
                
                </select>
                    
                </td><td id="datelabel" hidden>Cheque Date:&nbsp;</td><td id="dateinpt" hidden><input id="ckdte" type="text" class="formfield"></input></td><td hidden="true"><input id="myLabel" value=""></input></td></tr>         
                <tr id="typebank" hidden><td>Cheque No:&nbsp;*</td><td><input id="chkno" type="text" class="formfield"></input></td>
                    <td>Cheque details:&nbsp;*</td><td><input id="chkdetails" type="text" class="formfield"></input></td></tr>
                </tr>
                <tr><td>To Account :</td>
                        <td id="dbtbnk">
                    <select name="jvfrom2" id="jvfrom2" class="formfield">
                    <option value="">-- Select Acct --</option>
                <?php
                                  
                                $q5="SELECT bacc,acname,acno FROM bankaccounts WHERE deptid LIKE '$id' UNION SELECT incomeaccounts.incacc,accname,' ' as typ FROM incomeaccounts,incomeactmgnt WHERE (typ = 'G' OR typ = 'L') AND incomeactmgnt.incacc = incomeaccounts.incacc AND incomeactmgnt.deptid = '$id'";
                            
                                $data5=$mumin->getdbContent($q5);
                                
                                 for($k=0;$k<=count($data5)-1;$k++){ 
                      
                                    echo "<option value=".$data5[$k]['bacc'].">".$data5[$k]['acname']."  ".$data5[$k]['acno']."</option>";
                                     
                                     
                                   }
                            
                            ?>    
                
                </select>
                    
                </td><td hidden="true"><input id="myLabel2" value=""></input></td>
                    </tr>
                   <!--  <tr><td></td><td><div id="div_fromAccount"></div></td><td></td></tr>-->
             
            <!--<tr><td></td><td><div id="div_toAccount"></div></td><td></td></tr>-->
             <tr><td>Amount :</td><td><input id="jvamount" value=""  name="jvamount"  class="amount"></input></td><td></td></tr>
          
            <tr><td>Remarks :</td><td><textarea id="jvrmks" name="jvrmks" class="formfield"></textarea></td><td></td></tr>
            <tr><td></td><td><?php echo $jvcreate;?></td><td></td></tr>
            
            
        </table>
     <!--  </form>!-->
          </fieldset>
        <?php
        }
        
        ?>
        <?php
        
        if($action=="modify"){
            
            ?>
        <form id="jvformmodify" method="post" action="#" style="width: 650px">   
        <table class="ordinal">  
            <tr><td>Enter JV No :</td><td><input value="<?php echo $_POST['searchmodf'] ?>"  name="searchmodf" class="text-input validate[required]"></input></td><td><input type="submit" class="buttons" value="search" name="searchjvmod"/></td></tr>
            
            
        </table>
        </form>
        <?php
        }
        ?>
        
          <?php
        
        if($action=="print"){
            
            ?>
          <fieldset style="border: 1px ghostwhite solid;margin: 10px;color:black;font-size: 15px;font-weight: bold"> 
            <legend>Print J.V </legend>
              <form method="post" action="">
        <table class="ordinal" style="width: 500px;float: left">  
            <tr><td>Enter JV No :</td><td><input name="getjv" class="formfield"></input></td><td><input type="submit" value="Search" class="formbuttons" name="searching"></input></td></tr>
           
        </table>
           </form>
          </fieldset>
             
        <?php
        }
        ?>
       <?php
        
        if($action=="list"){
            ?>
           
              <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>JV List</legend><form  action="" method="post"> 
               
           <table style="width: 650px;float: left" class="ordinal"> 
                   
                   
                   
               <tr><td>From Date :</td><td><input id="jvstartdate" name="jvstartdate"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td></td><td></td></tr>
                   <tr><td>To Date :</td><td><input  id="jvenddate" name="jvenddate" value="<?php echo date('d-m-Y'); ?>"   class="formfield"/></td></tr>
                       
                   <tr><td></td><td><input name="viewjvlist" type="submit" id="jvlist" value="View list"></input></td><td></td><td></td></tr></table></form></fieldset>
    
       
          
        <?php
        }
        if($action=="journalentry"){
            ?>
           
              <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Journal Entry</legend>
                  <div>
                      <font style="font-size:12px">No of Rows : </font> <input type="text" id="rowcount" class="formfield"> </input> <br></br>
                          <?php echo $creatable; ?>
                  </div><br>
                  <div>
                      <font style="font-size:10px">(A - Asset, L - Libility, I - Income , E - Expenditure)</font>
                      <table style="width: 650px;float: left" class="ordinal">
                  <tr><td style="width: 70px">Type</td><td>Ledger Account</td><td>Dr Amount</td><td>Cr Amount</td></tr>
                      </table>
                      <table style="width: 650px;float: left" class="ordinal" id="appendtable">
                          
                      </table>
                      
                  </div>

              </fieldset>
    
       
          
        <?php
        }
          if($action=="jentrylist"){
            ?>
           
              <fieldset style="border: 1px ghostwhite solid;margin: 1px;color: black;padding-left: 5px;font-size: 15px;font-weight: bold"><legend>Journal Entry List</legend><form  action="" method="post"> 
               
           <table style="width: 650px;float: left" class="ordinal"> 
                   
                   
                   
               <tr><td>From Date :</td><td><input id="jentrystartdate" name="jentrystartdate"  value="<?php echo date('d-m-Y'); ?>" class="formfield"/></td><td></td><td></td></tr>
                   <tr><td>To Date :</td><td><input  id="jentryenddate" name="jentryenddate" value="<?php echo date('d-m-Y'); ?>"   class="formfield"/></td></tr>
                       
                   <tr><td></td><td><input name="viewjentrylist" type="submit" id="jentrylist" value="View list"></input></td><td></td><td></td></tr></table></form></fieldset>
    
       
          
        <?php
        }
        ?>
        
        
   <?php
                  
          
          
         if(isset($_POST['searching'])){
            
             $jv=$_POST['getjv'];
             if($jv==''){
                 echo "<script>
                  $.modaldialog.error('<b>Please input a J.V Number</b>', {
          title: 'Error occured',
          showClose: true
          });
                    </script>";
             }else{
               
               $q="SELECT * FROM jentry WHERE jvno LIKE '$jv' AND estId LIKE '$id' LIMIT 1";  
               
               $data=$mumin->getdbContent($q);
               
               if($data){
              
              echo"<script>window.location.href='jv_preview.php?jvdate=".$data[0]['jdate']."&jvfrom=".$data[0]['dbtacc']."&jvto=".$data[0]['crdtacc']."&jvamount=".$data[0]['amount']."&jvrmks=".$data[0]['rmks']."&jvno=".$data[0]['jvno']."&crdtype=".$data[0]['cbacc']."&dbtype=".$data[0]['dbacc']."&ckdte=".$data[0]['chqdate']."&chkno=".$data[0]['chqno']."&chkdetails=".$data[0]['chqdet']."';</script>";

               }
               else{  
                                 echo "<script>
                  $.modaldialog.error('<b>J.V Number not found </b>', {
          title: 'Error occured',
          showClose: true
          });
                    </script>";
               }
           }}
            ?>    
      
      
      
      
      
      
      
      
         
      
  </div>
    
        </div>
          </div>
    </div>
  </div><?php include 'footer.php' ?>
   <div id="d_progress" style="display: none;background: transparent;border: none;text-align: center;vertical-align:middle; line-height: 50px;padding-top: 10px">
     <img align="center" src="../assets/images/icon_animated_prog_dkgy_42wx42h.gif"></img>
 </div> 
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